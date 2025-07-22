<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // اگر کاربر لاگین است و two_factor_type او sms است و session مربوط به twofactor کامل نشده
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->two_factor_type === 'sms') {
                // اگر کاربر هنوز twofactor را کامل نکرده باشد (مثلاً session خاصی ست نشده)
                // فرض: اگر session ندارد یا مقدار خاصی ندارد، باید به صفحه وارد کردن کد برود
                if (!session()->has('two_factor_passed')) {
                    return redirect()->route('auth.token');
                }
            }
        }
        return $next($request);
    }
} 