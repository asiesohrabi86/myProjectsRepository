<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogRouteActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // شرایط برای لاگ کردن: درخواست GET موفق، دارای روت نام‌گذاری شده و خارج از پنل ادمین
        if ($request->isMethod('get') && $response->getStatusCode() === 200 && $request->route()) {
            
            $routeName = $request->route()->getName() ?? 'unnamed-route';
            
            if (str_starts_with($routeName, 'dashboard.') || str_starts_with($routeName, 'admin.')) {
                return $response;
            }

            // ثبت فعالیت با تمام اطلاعات مورد نیاز
            activity('route-visit')
               ->withProperties([
                   // *** مهم‌ترین اصلاح: افزودن session_id به پراپرتی‌ها ***
                   'session_id' => $request->session()->getId(), 
                   'ip_address' => $request->ip(),
               ])
               // causer به صورت خودکار توسط پکیج برای کاربر لاگین کرده ثبت می‌شود
               ->log('Visited ' . $routeName);
        }

        return $response;
    }
}