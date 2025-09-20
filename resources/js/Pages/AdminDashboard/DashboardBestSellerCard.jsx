import React, { useState, useEffect } from 'react';
import { router, Link } from '@inertiajs/react';
import WidgetSkeleton from '@/Components/WidgetSkeleton';

const DashboardBestSellerCard = ({ bestSellerDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (bestSellerDataProp) {
            setData(bestSellerDataProp);
            return;
        }

        setLoading(true);
        setError(null);

        router.reload({
            only: ['bestSellerData'],
            onSuccess: (page) => {
                setData(page.props.bestSellerData);
            },
            onError: (errors) => {
                console.error("Error fetching best seller data:", errors);
                setError('خطا در بارگذاری اطلاعات.');
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    }, [bestSellerDataProp]);

    if (loading) {
        return <WidgetSkeleton />;
    }

    if (error) {
        return (
            <div className="card">
                <div className="card-body text-center text-danger">
                    <p>{error}</p>
                    <button className="btn btn-sm btn-secondary" onClick={() => router.reload({ only: ['bestSellerData'] })}>
                        تلاش مجدد
                    </button>
                </div>
            </div>
        );
    }
    
    if (!data) {
        return null; // یا یک کامپوننت "داده‌ای وجود ندارد"
    }

    return (
        <div className="card">
            <div className="card-body">
                <h5 className="font-20 mb-1">تبریک می‌گوییم {data.userName}!</h5>
                <p className="mb-20">پرفروش‌ترین ماه</p>
                <div className="d-flex justify-content-between align-items-center">
                    <div className="dashboard-content-right">
                        <h2 className="text-success font-36 font-weight-bold">{data.monthSalesFormatted}</h2>
                        <p className="font-15 font-weight-bold">
                            شما امروز {data.salesGrowth.percentage}٪ <br /> {data.salesGrowth.directionText} انجام داده‌اید.
                        </p>
                        {/* استفاده از کامپوننت Link اینرشیا برای ناوبری سریع */}
                        <Link href={data.salesPageUrl} className="btn btn-primary mt-15">
                            مشاهده فروش
                        </Link>
                    </div>
                    <div className="dashboard-content-left wow shake" data-wow-delay="0.6s">
                        <img src="/admin/img/bg-img/5.jpg" className="img-fluid" alt="داشبورد" width="180" height="180" />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DashboardBestSellerCard;