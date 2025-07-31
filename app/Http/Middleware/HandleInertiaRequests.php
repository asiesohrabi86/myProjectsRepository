<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use Tightenco\Ziggy\Ziggy; // <-- ایمپورت Ziggy

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'inertia'; // این باید نام فایل Blade اصلی شما باشد که اینرشیا را بوت‌استرپ می‌کند

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // ساختار داده منوی سایدبار بر اساس فایل Blade شما
        $sidebarMenu = [
            [
                'title' => 'داشبورد',
                'icon' => 'zmdi zmdi-view-dashboard',
                'url' => route('dashboard.index'),
                'active' => 'dashboard.index',
                'permission' => null,
            ],
            [
                'title' => 'مدیریت کاربران',
                'icon' => 'zmdi zmdi-account',
                'permission' => 'users',
                'active' => ['users.index', 'users.create'],
                'children' => [
                    ['title' => 'لیست کاربران', 'url' => route('users.index'), 'active' => 'users.index'],
                    ['title' => 'افزودن کاربر', 'url' => route('users.create'), 'active' => 'users.create'],
                ],
            ],
            [
                'title' => 'مدیریت محصولات',
                'icon' => 'zmdi zmdi-shopping-cart-plus',
                'permission' => null, 
                'active' => ['products.index', 'products.create'],
                'children' => [
                    ['title' => 'لیست محصولات', 'url' => route('products.index'), 'active' => 'products.index'],
                    ['title' => 'افزودن محصول', 'url' => route('products.create'), 'active' => 'products.create'],
                ],
            ],
            [
                'title' => 'مدیریت دسته بندی',
                'icon' => 'zmdi zmdi-folder',
                'permission' => null,
                'active' => ['categories.index', 'categories.create'],
                'children' => [
                    ['title' => 'لیست دسته بندی', 'url' => route('categories.index'), 'active' => 'categories.index'],
                    ['title' => 'افزودن دسته بندی', 'url' => route('categories.create'), 'active' => 'categories.create'],
                ],
            ],
            [
                'title' => 'مدیریت برندها',
                'icon' => 'zmdi zmdi-bookmark',
                'permission' => null,
                'active' => ['brands.index', 'brands.create'],
                'children' => [
                    ['title' => 'لیست برندها', 'url' => route('brands.index'), 'active' => 'brands.index'],
                    ['title' => 'افزودن برند', 'url' => route('brands.create'), 'active' => 'brands.create'],
                ],
            ],
            [
                'title' => 'مدیریت نظرات',
                'icon' => 'zmdi zmdi-comment-text',
                'permission' => 'comments',
                'active' => ['comments.index', 'unapproved.get'],
                'children' => [
                    ['title' => 'لیست نظرات', 'url' => route('comments.index'), 'active' => 'comments.index'],
                    ['title' => 'نظرات تاییدنشده', 'url' => route('unapproved.get'), 'active' => 'unapproved.get'],
                ],
            ],
            [
                'title' => 'مدیریت سفارشات',
                'icon' => 'zmdi zmdi-receipt',
                'permission' => 'orders-all',
                'active' => ['orders.index'],
                'children' => [
                    ['title' => 'لیست سفارشات', 'url' => route('orders.index'), 'active' => 'orders.index'],
                ],
            ],
            [
                'title' => 'مدیریت ویژگی ها',
                'icon' => 'zmdi zmdi-tag-more',
                'permission' => null,
                'active' => ['attributes.index'], // روت تاییدنشده شما در اینجا اشتباه بود
                'children' => [
                    ['title' => 'لیست ویژگی ها', 'url' => route('attributes.index'), 'active' => 'attributes.index'],
                ],
            ],
            [
                'title' => 'سطوح دسترسی',
                'icon' => 'zmdi zmdi-lock',
                'permission' => 'permissions',
                'active' => ['permissions.index', 'roles.index'],
                'children' => [
                    ['title' => 'همه دسترسی ها', 'url' => route('permissions.index'), 'active' => 'permissions.index'],
                    ['title' => 'همه نقش ها', 'url' => route('roles.index'), 'active' => 'roles.index'],
                ],
            ],
        ];

        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                if (!$request->user()) {
                    return null;
                }
                // شما فقط باید پرمیشن‌های کاربر را بفرستید، نه کل آبجکت کاربر
                return [
                    'user' => [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        // ... سایر اطلاعات لازم
                    ],
                ];
            },
            'ziggy' => fn () => [ // اشتراک‌گذاری Ziggy برای استفاده از تابع route() در ری‌اکت
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarMenu' => function () use ($sidebarMenu) {
                // فیلتر کردن منو بر اساس سطح دسترسی کاربر
                return collect($sidebarMenu)->filter(function ($item) {
                    return $item['permission'] === null || (Auth::user() && Auth::user()->can($item['permission']));
                })->values()->all();
            },
        ]);
    }
}