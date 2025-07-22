<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    use twoFactorType;

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Google user data:', ['email' => $googleUser->email, 'name' => $googleUser->name]);
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'two_factor_type' => 'off',
                    'phone_number' => null,
                    'email_verified_at' => now(),
                ]);
                
                Log::info('New user created from Google login', ['user_id' => $user->id]);
            }
            
            Log::info('User object', $user ? $user->toArray() : []);
            Auth::login($user);
            Log::info('Auth check after login: ' . (Auth::check() ? 'YES' : 'NO'));
            if (!Auth::check()) {
                Log::error('Failed to login user after Google authentication', ['user_id' => $user->id]);
                throw new Exception('Failed to login user');
            }
            Log::info('User successfully logged in via Google', ['user_id' => $user->id]);
            
            // استفاده از متد loggedIn برای مدیریت two factor
            return $this->loggedIn($request, $user);
            
        } catch (Exception $e) {
            Log::error('Google login error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'خطا در ورود با گوگل: ' . $e->getMessage());
        }
    }
}
