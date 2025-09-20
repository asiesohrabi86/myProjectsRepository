<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActivationCode;
use App\Notifications\ActivationCodeNotification;
use App\Notifications\LoginNotification;
use Illuminate\Http\Request;

trait twoFactorType
{
    public function loggedIn(Request $request , $user)
    {
        if($user->hasTwoFactorAuthenticationEnabled())
        {
            // دیگر logout انجام نمی‌شود
            // فقط سشن two_factor_passed را پاک می‌کنیم تا مجبور به وارد کردن کد شود
            $request->session()->forget('two_factor_passed');
            $request->session()->put('auth',[
                'user_id'=>$user->id,
                'using_sms'=>false,
                'remember'=>$request->has('remember'),
            ]);
            if($user->two_factor_type=='sms')
            {
                $code=ActivationCode::generateCode($user);
                $user->notify(new ActivationCodeNotification($code, $user->phone_number));
                $request->session()->push('auth.using_sms','true');
            }
            return redirect(route('auth.token'));
        }
        // اگر two factor فعال نبود، سشن two_factor_passed را ست می‌کنیم
        $request->session()->put('two_factor_passed', true);
        return redirect()->route('profile');
    }

}

?>