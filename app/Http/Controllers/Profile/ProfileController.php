<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivationCode;
use App\Notifications\ActivationCodeNotification;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth','verified']);
   }
   
    public function index()
    {
        return view('profile.home');
    }

    public function twoFactorAuth()
    {
        return view('profile.twofactor');
    }

    public function insTwoFactorAuth(Request $request)
    {
        $data=$request->validate([
            'type'=>['required','in:off,sms'],
            'phone'=>['required_unless:type,off',Rule::unique('users','phone_number')->ignore($request->user()->id)],
            ]);

            if($data['type']=='sms')
            {
                if($request->user()->phone_number != $data['phone'])
                {
                   $code=ActivationCode::generateCode($request->user());
                   $request->session()->flash('phone',$data['phone']);
                   $request->user()->notify(new ActivationCodeNotification($code,$data['phone']));

                   
                    return redirect(route('phone.verify'));
                }else
                {
                    $request->user()->update([
                        'two_factor_type'=>'sms'
                        ]);
                }
            
            }


            if($data['type']=='off')
            {
                $request->user()->update([
                    'two_factor_type'=>'off'
                ]);
            }
       return back();
    }

    public function getPhoneVerify(Request $request)
    {
        $request->session()->reflash();
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token'=>'required'
        ]);

        $status=ActivationCode::verifyCode($request->token,$request->user());

        if($status)
        {
            $request->user()->activationCode()->delete();
            $request->user()->update([
                'two_factor_type'=>'sms',
                'phone_number'=>$request->session()->get('phone'),
            ]);
        }else
        {
            alert()->error('کد تاییدیه به درستی وارد نشده','خطا')->persistent('خیلی خوب');
            return redirect('profile/twofactor');
        }

        return $request->token;
    }
}
