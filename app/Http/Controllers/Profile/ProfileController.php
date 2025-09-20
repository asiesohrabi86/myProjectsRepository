<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivationCode;
use App\Models\Cart;
use App\Models\Order;
use App\Notifications\ActivationCodeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Message\SMS\MelliPayamakService;

class ProfileController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth','verified']);
   }
   
   public function index()
   {
       $user = Auth::user();
       $orders = $user->orders()->latest()->take(3)->get(); // آخرین ۳ سفارش
       return view('profile.home', compact('user', 'orders'));
   }

    public function twoFactorAuth()
    {
        $user = Auth::user();
        return view('profile.twofactor', compact('user'));
    }

    public function insTwoFactorAuth(Request $request)
    {
        $request->validate([
            'type' => 'required|in:off,sms',
            'phone_number' => 'required_if:type,sms|regex:/^09[0-9]{9}$/'
        ]);

        $user = Auth::user();
        
        if ($request->type == 'sms') {
            Log::info('Starting SMS verification process', [
                'user_id' => $user->id,
                'phone' => $request->phone_number
            ]);

            try {
                $code = rand(100000, 999999);
                Log::info('Generated verification code', [
                    'user_id' => $user->id,
                    'code' => $code
                ]);

                // ذخیره موقت کد و شماره موبایل در سشن
                session([
                    'two_factor_code' => $code,
                    'pending_phone_number' => $request->phone_number
                ]);
                
                Log::info('Saved verification code to session', [
                    'user_id' => $user->id,
                    'code' => $code
                ]);

                // ارسال کد فعال‌سازی با استفاده از نوتیفیکیشن
                $user->notify(new ActivationCodeNotification(
                    $code,
                    $request->phone_number,
                    config('sms.default_channel')
                ));

                Log::info('Sent activation code notification', [
                    'user_id' => $user->id,
                    'phone' => $request->phone_number,
                    'channel' => config('sms.default_channel')
                ]);
                
                return redirect()->route('phone.verify')->with('success', 'کد فعالسازی به شماره تلفن شما ارسال شد.');
            } catch (\Exception $e) {
                Log::error('Failed to send activation code', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->with('error', 'خطا در ارسال کد فعالسازی. لطفاً دوباره تلاش کنید.');
            }
        } else {
            $user->two_factor_type = 'off';
            $user->save();
            return redirect()->route('profile')->with('success', 'احراز هویت دو مرحله‌ای غیرفعال شد.');
        }
    }

    public function getPhoneVerify(Request $request)
    {
        $user = Auth::user();
        return view('profile.phone-verify', compact('user'));
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric|digits:6'
        ]);

        $user = Auth::user();
        
        // بررسی کد از سشن
        if ($request->token == session('two_factor_code')) {
            // ذخیره شماره موبایل و فعال‌سازی احراز هویت دو مرحله‌ای
            $user->phone_number = session('pending_phone_number');
            $user->two_factor_type = 'sms';
            $user->save();
            
            // پاک کردن اطلاعات موقت از سشن
            session()->forget(['two_factor_code', 'pending_phone_number']);
            
            // ست کردن سشن two_factor_passed
            session(['two_factor_passed' => true]);
            
            return redirect()->route('profile')->with('success', 'احراز هویت دو مرحله‌ای با موفقیت فعال شد.');
        }

        return back()->withErrors(['token' => 'کد وارد شده صحیح نیست']);
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get();
        return view('profile.orders', compact('user', 'orders'));
    }

    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('profile.change-password', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profile')->with('success', 'رمز عبور با موفقیت تغییر کرد');
    }

    public function testSms()
    {
        try {
            // بررسی محدودیت زمانی
            $hour = (int)date('H');
            if ($hour >= 22 || $hour < 8) {
                return 'ارسال پیامک در این ساعت امکان‌پذیر نیست. لطفاً بین ساعت 8 صبح تا 10 شب تلاش کنید.';
            }

            $smsService = new \App\Http\Services\Message\SMS\MelliPayamakService();
            
            // نمایش تنظیمات فعلی (بدون نمایش رمز عبور)
            $config = [
                'username' => config('sms.username'),
                'from' => config('sms.otp_from'),
                'api_url' => config('sms.api_url')
            ];
            
            $result = $smsService->sendSmsSoapClient(
                config('sms.otp_from'),
                ['09113561287'],
                'تست ارسال پیامک'
            );
            
            if ($result) {
                return 'پیامک با موفقیت ارسال شد';
            } else {
                return 'خطا در ارسال پیامک. لطفاً تنظیمات زیر را بررسی کنید:<br>' . 
                       'Username: ' . $config['username'] . '<br>' .
                       'From: ' . $config['from'] . '<br>' .
                       'API URL: ' . $config['api_url'];
            }
        } catch (\SoapFault $e) {
            return 'خطای SOAP: ' . $e->getMessage() . '<br>کد خطا: ' . $e->getCode();
        } catch (\Exception $e) {
            return 'خطای عمومی: ' . $e->getMessage();
        }
    }
}
