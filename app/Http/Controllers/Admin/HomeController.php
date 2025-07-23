<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

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

        // ویجت ۲: بازدیدکنندگان امروز (شبیه‌سازی شده)
        // TODO: این بخش باید با منطق واقعی شمارش بازدیدکنندگان شما جایگزین شود.
        // برای مثال، اگر از پکیجی استفاده می‌کنید، باید از آن کوئری بگیرید.
        $todayVisitorsCount = rand(1500, 2500);

        // ویجت ۳: مجموع کل درآمد (از ابتدا)
        $totalAllTimeIncome = Transaction::where('status', Transaction::STATUS_SUCCESS)
            ->sum('paid');

        return [
            'todaySalesCount' => $todaySalesCount,
            'todayVisitorsCount' => $todayVisitorsCount,
            'totalAllTimeIncome' => $totalAllTimeIncome,
        ];
    }
    
}