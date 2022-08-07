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
            return redirect(route('login'));
        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember')))
        {
            $user->activationCode()->delete();
            return redirect('/profile');
        }

        return redirect(route('login'));
    }
}
