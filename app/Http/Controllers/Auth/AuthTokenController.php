<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivationCode;
use App\Models\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        $request->session()->reflash();
        if(! $request->session()->has('auth'))
        {
            return redirect('/');
        }
        return view('profile.token');

    }

    public function postToken(Request $request)
    {
        $data=$request->validate([
            'token'=>'required',
        ]);

        if(! $request->session()->has('auth'))
        {
            return redirect(route('login'));
        }

        $user=User::findOrFail($request->session()->get('auth.user_id'));
        $status=ActivationCode::verifyCode($request->token,$user);

        if(! $status)
        {
            return back()->withErrors(['token' => 'کد وارد شده اشتباه است یا منقضی شده است.'])->with('show_resend', true);
        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember')))
        {
            $user->activationCode()->delete();
            session(['two_factor_passed' => true]); // ست کردن سشن بعد از موفقیت
            return redirect('/profile');
        }

        return redirect(route('login'));
    }

    public function resendActivationCode(Request $request)
    {
        if(! $request->session()->has('auth'))
        {
            return redirect(route('login'));
        }
        $user = \App\Models\User::findOrFail($request->session()->get('auth.user_id'));
        if($user->two_factor_type == 'sms') {
            $code = \App\Models\ActivationCode::generateCode($user);
            $user->notify(new \App\Notifications\ActivationCodeNotification($code, $user->phone_number));
            \Log::info('Activation code resent for user: ' . $user->id . ' code: ' . $code);
            return back()->with('status', 'کد تاییدیه جدید ارسال شد.');
        }
        return back()->withErrors(['token' => 'امکان ارسال مجدد کد وجود ندارد.']);
    }
}
