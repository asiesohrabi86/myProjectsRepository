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
                auth()->logout();
                $request->session()->flash('auth',[
                    'user_id'=>$user->id,
                    'using_sms'=>false,
                    'remember'=>$request->has('remember'),
                ]);
            

                if($user->two_factor_type=='sms')
                {
                    
                    $code=ActivationCode::generateCode($user);
                    // dd(auth()->user());
                    // $request->user()->notify(new ActivationCodeNotification($code, $user->phone_number));
                    $request->session()->push('auth.using_sms','true');
                }
                return redirect(route('auth.token'));
            }
            
            return $user->notify(new LoginNotification());
            return false;
    }

}

?>