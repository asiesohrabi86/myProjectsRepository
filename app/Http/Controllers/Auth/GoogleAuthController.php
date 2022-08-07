<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    use twoFactorType;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try{
            $googleUser=Socialite::driver('google')->user();
            // dd($googleUser->email);
            $user=User::where('email',$googleUser->email)->first();
            
            if(! $user)
            {
                $user=User::create([
                    'name'=>$googleUser->name,
                    'email'=>$googleUser->email,
                    'password'=>bcrypt(Str::random(16)),
                ]);
                
            }
            
            auth()->loginUsingId($user->id);
            // TODO Sweet Alert
            return $this->loggedIn($request,$user) ?: redirect('/login');


            }catch(Exception $e){
                alert()->error('خطا رخ داد','در ورود به سایت خطایی رخ داد')->persistent('متوجه شدم');
                return redirect(route('login'));
            }
    }
}
