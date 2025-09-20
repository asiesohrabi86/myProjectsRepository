import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import TodaySalesWidget from './TodaySalesWidget';
import TodayVisitorsWidget from './TodayVisitorsWidget';
import TotalIncomeWidget from './TotalIncomeWidget';

// یک کامپوننت کوچک برای نمایش اسکلت لودینگ
const WidgetCardSkeleton = () => (
    <div className="card" aria-hidden="true">
        <div className="card-body py-4 placeholder-glow">
            <div className="media align-items-center">
                <div className="d-inline-block mr-3">
                    <span className="placeholder rounded-circle" style={{ width: '40px', height: '40px' }}></span>
                </div>
                <div className="media-body mr-3">
                    <h3 className="mb-2 placeholder col-6"></h3>
                    <div className="mb-0 placeholder col-8"></div>
                </div>
            </div>
        </div>
    </div>
);

const Widgets = ({ widgetsDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (widgetsDataProp) {
            setData(widgetsDataProp);
            return;
        }
        setLoading(true);
        setError(null);
        router.reload({
            only: ['widgetsData'],
            onSuccess: (page) => setData(page.props.widgetsData),
            onError: (errors) => {
                console.error("Error fetching widgets data:", errors);
                setError('خطا در بارگذاری اطلاعات ویجت‌ها.');
            },
            onFinish: () => setLoading(false),
        });
    }, [widgetsDataProp]);
    
    // اگر در حال لودینگ هستیم، سه اسکلت نمایش بده
    if (loading) {
        return (
            <section className="dashboard-widgets">
                <div className="row">
                    {[1, 2, 3].map(i => (
                        <div key={i} className="col-12 col-sm-6 col-xl-4 height-card box-margin">
                            <WidgetCardSkeleton />
                        </div>
                    ))}
                </div>
            </section>
        );
    }
    
    // اگر خطا رخ داده، یک پیام خطا نمایش بده
    if (error) {
         return <div className="alert alert-danger">{error}</div>;
    }

    // اگر داده‌ای وجود ندارد، چیزی نمایش نده
    if (!data) return null;

    // اگر همه چیز موفق بود، کامپوننت‌ها را با داده‌های واقعی رندر کن
    return (
        <section className="dashboard-widgets">
            <div className="row">
                <div className="col-12 col-sm-6 col-xl-4 height-card box-margin">
                    <TodaySalesWidget salesCount={data.todaySalesCount} />
                </div>
                <div className="col-12 col-sm-6 col-xl-4 height-card box-margin">
                    <TodayVisitorsWidget visitorsCount={data.todayVisitorsCount} />
                </div>
                <div className="col-12 col-sm-6 col-xl-4 height-card box-margin">
                    <TotalIncomeWidget income={data.totalAllTimeIncome} />
                </div>
            </div>
        </section>
    );
};

export default Widgets;