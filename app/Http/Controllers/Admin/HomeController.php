<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Spatie\Activitylog\Models\Activity; 
use App\Http\Controllers\Admin\ChatController;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function index()
    {
        return Inertia::render('AdminDashboard/Dashboard', [
            'weeklyEarnings' => fn() => $this->getWeeklyEarningsData(),
            'bestSellerData' => fn() => $this->getBestSellerData(),
            'orderSummaryData' => fn() => $this->getOrderSummaryData(),
            'totalIncomeData' => fn() => $this->getTotalIncomeData(),
            // داده‌های جدید برای بخش ویجت‌ها
            'widgetsData' => fn() => $this->getWidgetsData(),
            // اضافه کردن داده محصولات برتر
            'topProducts' => fn() => $this->getTopProducts(),
            'newUsersData' => fn() => $this->getNewUsersData(),
            'notificationsData' => fn() => $this->getNotificationsData(),
            'chatData' => fn() => $this->getChatData(),
        ]);
    }
    
    
    /**
     * متد getWeeklyEarningsData با منطق جدید و ترتیب زمانی
     */
    private function getWeeklyEarningsData()
    {
        // 1. داده‌های فروش روزانه ۷ روز گذشته را از دیتابیس می‌گیریم
        $dailyTotals = Transaction::query()
            ->where('status', Transaction::STATUS_SUCCESS) 
            ->where('created_at', '>=', now()->subDays(6)->startOfDay()) 
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(paid) as total_paid')
            )
            ->groupBy('date')
            ->get()
            ->keyBy('date'); // کلید آرایه را تاریخ قرار می‌دهیم برای دسترسی سریع

        $weeklyEarnings = [];
        $previousDayEarning = null;
        $dayNameMap = ['Saturday'  => 'شنبه', 'Sunday'    => 'یکشنبه', 'Monday'    => 'دوشنبه', 'Tuesday'   => 'سه‌شنبه', 'Wednesday' => 'چهارشنبه', 'Thursday'  => 'پنج‌شنبه', 'Friday'    => 'جمعه'];

        // 2. یک حلقه از ۷ روز پیش تا امروز ایجاد می‌کنیم تا ترتیب زمانی حفظ شود
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->toDateString(); // e.g., "2023-08-02"

            // 3. درآمد روز جاری را از داده‌های گرفته شده استخراج می‌کنیم. اگر وجود نداشت، صفر در نظر می‌گیریم.
            $currentEarning = $dailyTotals->get($dateString, (object)['total_paid' => 0])->total_paid;
            
            // 4. روند را نسبت به درآمد روز قبل (در حلقه قبلی) محاسبه می‌کنیم
            if ($previousDayEarning !== null) {
                if ($currentEarning > $previousDayEarning) $trend = 'up';
                elseif ($currentEarning < $previousDayEarning) $trend = 'down';
                else $trend = 'stable';
            } else {
                $trend = 'stable'; // برای اولین روز روندی وجود ندارد
            }

            $dayNameEnglish = $date->format('l');

            $weeklyEarnings[] = [
                'dayName' => $dayNameMap[$dayNameEnglish],
                'dayKey'  => strtolower(substr($dayNameEnglish, 0, 3)),
                'earning' => (int)$currentEarning,
                'trend'   => $trend,
            ];

            $previousDayEarning = $currentEarning;
        }

        // 5. آرایه نهایی را که به ترتیب زمانی است برمی‌گردانیم (بدون مرتب‌سازی مجدد)
        return $weeklyEarnings;
    }

    /**
     * متد getBestSellerData با محاسبه فروش ماه شمسی (اصلاح شده)
     */
    private function getBestSellerData()
    {
        $user = Auth::user();

        // *** شروع اصلاحیه: محاسبه فروش بر اساس ماه شمسی جاری ***
        $jalaliNow = Verta::now();
        $startOfCurrentJalaliMonth = $jalaliNow->startMonth()->toCarbon();
        $endOfCurrentJalaliMonth = $jalaliNow->endMonth()->toCarbon();

        $currentMonthSales = Transaction::query()
            ->where('status', Transaction::STATUS_SUCCESS)
            ->whereBetween('created_at', [$startOfCurrentJalaliMonth, $endOfCurrentJalaliMonth])
            ->sum('paid');
        // *** پایان اصلاحیه ***

        $todaySales = Transaction::query()->where('status', Transaction::STATUS_SUCCESS)->whereDate('created_at', today())->sum('paid');
        $yesterdaySales = Transaction::query()->where('status', Transaction::STATUS_SUCCESS)->whereDate('created_at', now()->subDay())->sum('paid');
        
        $salesGrowth = ['percentage' => 0, 'directionText' => 'تغییری نکرده'];
        if ($yesterdaySales > 0) {
            $diff = $todaySales - $yesterdaySales;
            $percentage = ($diff / $yesterdaySales) * 100;
            $salesGrowth['percentage'] = round(abs($percentage), 1);
            $salesGrowth['directionText'] = $diff >= 0 ? 'فروش بیشتر' : 'فروش کمتر';
        } elseif ($todaySales > 0) {
            $salesGrowth['percentage'] = 100;
            $salesGrowth['directionText'] = 'فروش جدید';
        }

        return ['userName' => $user->name, 'monthSalesFormatted' => number_format($currentMonthSales) . ' تومان', 'salesGrowth' => $salesGrowth, 'salesPageUrl' => route('orders.index'),];
    }
    
    private function getOrderSummaryData()
    {
        $startDate = Verta::now()->subMonths(11)->startMonth()->toCarbon();
        $dailyData = Transaction::query()->where('status', Transaction::STATUS_SUCCESS)->where('created_at', '>=', $startDate)->select(DB::raw('DATE(created_at) as gregorian_date'), DB::raw('SUM(paid) as total_sales'), DB::raw('COUNT(*) as order_count'))->groupBy('gregorian_date')->get();
        $jalaliMonthlyAggregates = [];
        foreach ($dailyData as $day) {
            $vertaDate = Verta::instance($day->gregorian_date);
            $jalaliKey = $vertaDate->format('Y-m');
            if (!isset($jalaliMonthlyAggregates[$jalaliKey])) {
                $jalaliMonthlyAggregates[$jalaliKey] = ['total_sales' => 0, 'order_count' => 0];
            }
            $jalaliMonthlyAggregates[$jalaliKey]['total_sales'] += $day->total_sales;
            $jalaliMonthlyAggregates[$jalaliKey]['order_count'] += $day->order_count;
        }
        $chartData = [];
        $persianMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        for ($i = 11; $i >= 0; $i--) {
            $date = Verta::now()->subMonths($i);
            $jalaliKey = $date->format('Y-m');
            $monthName = $persianMonths[$date->month - 1];
            $sales = $jalaliMonthlyAggregates[$jalaliKey]['total_sales'] ?? 0;
            $count = $jalaliMonthlyAggregates[$jalaliKey]['order_count'] ?? 0;
            $chartData[] = ['name' => $monthName, 'totalSales' => $sales, 'orderCount' => $count];
        }
        return $chartData;
    }

    /**
     * داده‌های کارت درآمد هفتگی را آماده می‌کند 
     */
    private function getTotalIncomeData()
    {
        // تنظیم شروع هفته روی شنبه برای محاسبات دقیق
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        // محاسبه درآمد این هفته (از شنبه تا الان)
        $startOfThisWeek = now()->startOfWeek();
        $endOfThisWeek = now()->endOfWeek();
        $thisWeekIncome = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->sum('paid');

        // محاسبه درآمد هفته قبل
        $startOfLastWeek = now()->subWeek()->startOfWeek();
        $endOfLastWeek = now()->subWeek()->endOfWeek();
        $lastWeekIncome = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('paid');
        
        // محاسبه درصد رشد این هفته نسبت به هفته قبل
        $trend = ['percentage' => 0, 'direction' => 'stable'];
        if ($lastWeekIncome > 0) {
            $diff = $thisWeekIncome - $lastWeekIncome;
            $percentage = ($diff / $lastWeekIncome) * 100;
            $trend['percentage'] = round(abs($percentage), 1);
            $trend['direction'] = $diff >= 0 ? 'up' : 'down';
        } elseif ($thisWeekIncome > 0) {
            $trend['percentage'] = 100;
            $trend['direction'] = 'up';
        }

        // آماده‌سازی داده‌های نمودار برای 7 روز اخیر (که شامل روزهای این هفته است)
        $dailyTotals = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paid) as total'))
            ->groupBy('date')->get()->keyBy('date');

        $chartData = [];
        $shortDayNames = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج']; // شنبه تا جمعه

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateString = $date->toDateString();
            $dayOfWeek = $date->dayOfWeek; // 0=Sunday, 6=Saturday
            $jalaliDayOfWeek = ($dayOfWeek + 1) % 7; // تبدیل به ایندکس شمسی (شنبه=0)
            
            $chartData[] = [
                'name' => $shortDayNames[$jalaliDayOfWeek],
                'value' => (int)($dailyTotals[$dateString]->total ?? 0),
            ];
        }

        return [
            'thisWeekIncomeFormatted' => number_format($thisWeekIncome) . ' تومان',
            'trend' => $trend,
            'chartData' => $chartData
        ];
    }

    /**
     * داده‌های سه ویجت اصلی داشبورد را آماده می‌کند.
     */
    private function getWidgetsData()
    {
        // ویجت ۱: تعداد فروش امروز
        $todaySalesCount = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->whereDate('created_at', today())
            ->count();

        // 1. ابتدا تمام causer_id های یکتای امروز را پیدا می‌کنیم. اینها کاربران لاگین کرده ما هستند.
        $todayLoggedInUserIds = Activity::query()
            ->where('log_name', 'route-visit')
            ->whereDate('created_at', today())
            ->whereNotNull('causer_id')
            ->pluck('causer_id')
            ->unique();
        
        // تعداد آنها را می‌شماریم.
        $loggedInVisitorCount = $todayLoggedInUserIds->count();

        // 2. حالا به سراغ مهمانان می‌رویم. ما فقط سشن‌هایی را می‌خواهیم که متعلق به کاربرانی که در لیست بالا هستند، نباشند.
        // برای این کار، ابتدا تمام سشن‌های متعلق به کاربران لاگین کرده را استخراج می‌کنیم.
        $sessionsAssociatedWithUsers = Activity::query()
            ->where('log_name', 'route-visit')
            ->whereDate('created_at', today())
            ->whereIn('causer_id', $todayLoggedInUserIds)
            ->select(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.session_id')) as session_id"))
            ->pluck('session_id')
            ->unique();

        // 3. حالا تعداد سشن‌های مهمان یکتا را می‌شماریم که در لیست بالا نیستند.
        $guestVisitorCount = Activity::query()
            ->where('log_name', 'route-visit')
            ->whereDate('created_at', today())
            ->whereNull('causer_id') // فقط مهمانان
            // شرط اصلی: سشن آنها نباید در لیست سشن‌های کاربران لاگین کرده باشد.
            ->when($sessionsAssociatedWithUsers->isNotEmpty(), function ($query) use ($sessionsAssociatedWithUsers) {
                $query->whereNotIn(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.session_id'))"), $sessionsAssociatedWithUsers);
            })
            ->distinct(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.session_id'))"))
            ->count();

        // 4. تعداد کل بازدیدکنندگان برابر است با جمع این دو گروه کاملاً مجزا.
        $todayVisitorsCount = $loggedInVisitorCount + $guestVisitorCount;


        // ویجت ۳: مجموع کل درآمد (از ابتدا)
        $totalAllTimeIncome = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->sum('paid');

        return [
            'todaySalesCount' => $todaySalesCount,
            'todayVisitorsCount' => $todayVisitorsCount,
            'totalAllTimeIncome' => $totalAllTimeIncome,
        ];
    }
    
    /**
     * محصولات برتر بر اساس بیشترین فروش (تعداد سفارش یا مجموع مبلغ)
     */
    private function getTopProducts($limit = 10)
    {
        // این کوئری محصولات را بر اساس تعداد فروششان در سفارشات موفق، رتبه‌بندی می‌کند.
        $topProducts = Product::query()
            ->select([
                'products.id',
                'products.title',
                'products.price',
                'products.amount',
                'products.image',
                // شمارش تعداد آیتم‌های سفارش مرتبط با هر محصول
                DB::raw('COUNT(order_items.id) as sales_count'),
                // جمع کل مبلغ آیتم‌های سفارش (دقیق‌تر از paid در تراکنش)
                DB::raw('SUM(order_items.price * order_items.quantity) as total_income')
            ])
            // از طریق OrderItem به Order و سپس به Transaction وصل می‌شویم
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('transactions', 'orders.basket_id', '=', 'transactions.basket_id') // فرض بر اینکه basket_id کلید اتصال است
            // شرط اصلی: فقط تراکنش‌های موفق
            ->where('transactions.status', Transaction::STATUS_SUCCESS)
            ->groupBy('products.id', 'products.title', 'products.price', 'products.amount', 'products.image')
            ->orderByDesc('sales_count')
            ->limit($limit)
            ->get();

        // تبدیل داده به فرمت مورد نیاز جدول در فرانت‌اند
        return $topProducts->map(function($product) {
            return [
                'img' => $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/50', // افزودن آدرس صحیح و یک placeholder
                'name' => $product->title,
                'code' => 'P-' . $product->id, // یک کد خواناتر
                'auction' => $product->sales_count, // "حراجی" در واقع تعداد فروش است
                'income' => number_format($product->total_income) . ' تومان',
                'stock' => $product->amount,
                'progress' => $product->amount > 0 ? min(100, round(($product->amount / 100) * 100)) : 0, // فرض: 1000 حداکثر موجودی
                'progressClass' => $product->amount > 500 ? 'bg-success' : ($product->amount > 200 ? 'bg-warning' : 'bg-danger'),
            ];
        });
    }

    private function getNewUsersData($limit = 5)
    {
        // تابع کمکی برای فرمت کردن داده‌های کاربر
        $formatUser = function (User $user) {
            return [
                // برای تصویر پروفایل، از یک سرویس آواتار جنریک مثل ui-avatars.com استفاده می‌کنیم
                // که بر اساس نام کاربر، یک تصویر می‌سازد.
                'img' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff',
                'name' => $user->name,
                // اولین نقشی که کاربر دارد را به عنوان role نمایش می‌دهیم
                'role' => $user->roles->first()->name ?? 'کاربر عادی',
            ];
        };

        // ۱. دریافت کاربرانی که امروز ثبت‌نام کرده‌اند
        $todayUsers = User::query()
            ->whereDate('created_at', today())
            ->latest() // جدیدترین‌ها در ابتدا
            ->limit($limit)
            ->with('roles') // برای جلوگیری از N+1 query problem
            ->get()
            ->map($formatUser);

        // ۲. دریافت کاربرانی که در ماه شمسی جاری ثبت‌نام کرده‌اند
        $startOfMonth = Verta::now()->startMonth()->toCarbon();
        $endOfMonth = Verta::now()->endMonth()->toCarbon();
        
        $monthUsers = User::query()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->latest()
            ->limit($limit)
            ->with('roles')
            ->get()
            ->map($formatUser);
            
        return [
            'today' => $todayUsers,
            'month' => $monthUsers,
        ];
    }

    public function getNotificationsData($limit = 5)
    {
        // دریافت 5 فعالیت آخر از نوع‌هایی که برای ما مهم هستند
        $activities = Activity::query()
            ->whereIn('log_name', ['new_order', 'new_user', 'new_comment'])
            ->latest() // جدیدترین‌ها در ابتدا
            ->limit($limit)
            ->get();
            
        // تبدیل داده‌ها به فرمت مورد نیاز فرانت‌اند
        return $activities->map(function (Activity $activity) {
            // تعیین آیکون و تصویر بر اساس نوع نوتیفیکیشن
            $icon = 'fa-bell'; // پیش‌فرض
            $img = 'https://ui-avatars.com/api/?name=N&background=random&color=fff'; // پیش‌فرض

            if ($activity->log_name === 'new_order') {
                $icon = 'fa-shopping-cart text-success';
                if ($activity->causer) {
                    $img = 'https://ui-avatars.com/api/?name=' . urlencode($activity->causer->name) . '&background=4e73df&color=fff';
                }
            } elseif ($activity->log_name === 'new_user') {
                $icon = 'fa-user-plus text-info';
                if ($activity->subject) {
                    $img = 'https://ui-avatars.com/api/?name=' . urlencode($activity->subject->name) . '&background=1cc88a&color=fff';
                }
            } elseif ($activity->log_name === 'new_comment') {
                $icon = 'fa-comment text-warning';
                if ($activity->causer) {
                    $img = 'https://ui-avatars.com/api/?name=' . urlencode($activity->causer->name) . '&background=f6c23e&color=fff';
                }
            }

            return [
                'id' => $activity->id,
                'icon' => $icon,
                'img' => $img,
                'text' => $activity->description,
                'time' => $activity->created_at->diffForHumans(), // مثلا "۵ دقیقه پیش"
            ];
        });
    }

    public function getChatData()
    {
        $adminUserId = auth()->id();

        // ۱. تمام پیام‌های اخیر را واکشی می‌کنیم
        $allMessages = ChatMessage::query()
            ->with('user', 'recipient')
            ->latest()
            ->limit(100) // تعداد بیشتری پیام می‌گیریم تا مکالمات بیشتری را پوشش دهیم
            ->get();

        // ۲. پیام‌ها را بر اساس شناسه کاربر (غیر ادمین) گروه‌بندی می‌کنیم
        $conversations = $allMessages->groupBy(function ($message) use ($adminUserId) {
            // شناسه مکالمه، همیشه ID کاربری است که ادمین نیست.
            return $message->user_id === $adminUserId ? $message->recipient_id : $message->user_id;
        });

        // ۳. هر گروه (مکالمه) را به فرمت مورد نیاز فرانت‌اند تبدیل می‌کنیم
        $formattedConversations = $conversations->map(function ($messages, $userId) use ($adminUserId) {
            if (!$userId) return null; // نادیده گرفتن پیام‌های بدون کاربر

            $user = $messages->first(fn($m) => $m->user_id == $userId)->user ?? null;
            if (!$user) return null;

            return [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff'
                ],
                'last_message' => $messages->first()->message,
                'last_message_time' => $messages->first()->created_at->diffForHumans(),
                // **افزودن وضعیت خوانده نشده**
                'unread_count' => $messages->whereNull('read_at')->where('user_id', '!=', $adminUserId)->count(),
                'messages' => $messages->map(function ($message) use ($adminUserId) {
                    return [
                        'id' => $message->id,
                        'text' => $message->message,
                        'is_sender' => $message->user_id === $adminUserId,
                        'user' => [
                            'id' => $message->user->id,
                            'name' => $message->user->name,
                            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) . '&background=random&color=fff'
                        ]
                    ];
                })->reverse()->values() // پیام‌ها را برای نمایش مرتب می‌کنیم
            ];
        })->filter()->sortByDesc(function ($convo) {
            // مکالمات را بر اساس زمان آخرین پیام مرتب می‌کنیم
            return $convo['messages']->last()->id ?? 0;
        })->values();

        return $formattedConversations;
    }
}