<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use Tightenco\Ziggy\Ziggy;
use App\Models\ChatMessage;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'inertia';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
          
            'auth' => fn() => [
                'user' => $this->getAuthUser(), // استفاده از تابع کمکی
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            // **اصلاحیه اصلی: پاس دادن request به توابع**
            'sidebarMenu' => fn() => $this->getSidebarMenu($request),
            'notifications' => fn() => $this->getNotificationsData(5),
            'conversations' => fn() => $this->getUnreadConversations($request),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'newlySentMessage' => fn () => $request->session()->get('newlySentMessage'),
            ],
        ]);
    }

    // --- توابع کمکی با امضای صحیح ---
    protected function getAuthUser(): ?array
    {
        $user = Auth::user();
        if (!$user) return null;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff',
        ];
    }

    protected function getSidebarMenu(Request $request): array
    {
        $user = $request->user();
        if (!$user) return [];

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
                'active' => ['attributes.index'],
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

        return collect($sidebarMenu)->filter(fn($item) => empty($item['permission']) || $user->can($item['permission']))->values()->all();
    }

    protected function getUnreadConversations(Request $request): \Illuminate\Support\Collection
    {
        $user = $request->user();
        if (!$user) return collect();
        
        $adminUserId = Auth::id();

        // فقط پیام‌های خوانده نشده که توسط کاربران ارسال شده را واکشی می‌کنیم
        $unreadMessages = ChatMessage::query()
            ->whereNull('read_at')
            ->where('recipient_id', $adminUserId) // پیام‌هایی که برای ادمین ارسال شده
            ->with('user')
            ->latest()
            ->get();
        
        // آن‌ها را بر اساس فرستنده گروه‌بندی می‌کنیم
        $conversations = $unreadMessages->groupBy('user_id');

        return $conversations->map(function ($messages, $userId) {
            $user = $messages->first()->user;
            if (!$user) return null;

            return [
                'user' => [ 
                    'id' => $user->id, 
                    'name' => $user->name, 
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff'
                ],
                'last_message' => $messages->first()->message,
                'unread_count' => $messages->count(),
            ];
        })->filter()->values();
    }

    /**
     * @param Request $request
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    protected function getNotificationsData(int $limit = 5)
    {
        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        
        return $user->unreadNotifications->take($limit)->map(function ($notification) {
            return [
                'id' => $notification->id,
                'text' => $notification->data['text'] ?? 'اطلاعیه جدید',
                'icon' => $notification->data['icon'] ?? 'fa-bell',
                'time' => $notification->created_at->diffForHumans(),
                'url' => $notification->data['url'] ?? '#',
            ];
        });
    }
}
