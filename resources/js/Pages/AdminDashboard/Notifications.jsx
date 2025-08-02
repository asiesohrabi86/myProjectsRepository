import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import WidgetSkeleton from '@/Components/WidgetSkeleton';

const Notifications = ({ notificationsDataProp }) => {
    // این بخش منطق واکشی داده است و دست‌نخورده باقی می‌ماند
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (notificationsDataProp) {
            setData(notificationsDataProp);
            return;
        }
        setLoading(true);
        setError(null);
        router.reload({
            only: ['notificationsData'],
            onSuccess: (page) => setData(page.props.notificationsData),
            onError: (errors) => {
                console.error("Error fetching notifications:", errors);
                setError('خطا در بارگذاری اطلاعیه‌ها.');
            },
            onFinish: () => setLoading(false),
        });
    }, [notificationsDataProp]);

    if (loading) {
        return <WidgetSkeleton />;
    }

    if (error) {
        return (
            <div className="card full-height">
                <div className="card-body text-center text-danger">
                    <p>{error}</p>
                </div>
            </div>
        );
    }

    if (!data || data.length === 0) {
        return (
            // برای این حالت هم ارتفاع ثابت را در نظر می‌گیریم تا چیدمان به هم نریزد
            <div className="card full-height" style={{ height: '550px' }}>
                <div className="card-header bg-transparent">
                    <h5 className="card-title mb-0">اطلاعیه</h5>
                </div>
                <div className="card-body d-flex align-items-center justify-content-center text-muted">
                    <p>اطلاعیه جدیدی برای نمایش وجود ندارد.</p>
                </div>
            </div>
        );
    }
    
    return (
        // ۱. به کارت اصلی ارتفاع ثابت و کلاس‌های Flexbox می‌دهیم
        <div className="card full-height d-flex flex-column" style={{ height: '550px' }}>
            <div className="card-header bg-transparent">
                <h5 className="card-title mb-0">اطلاعیه</h5>
            </div>
            {/* ۲. به card-body می‌گوییم فضای باقی‌مانده را پر کند و در صورت نیاز اسکرول بخورد */}
            <div className="card-body" style={{ flex: '1 1 auto', overflowY: 'auto' }}>
                <div className="row">
                    {data.map((notification) => (
                        <div className="col-12" key={notification.id}>
                            <div className="single-widget-timeline mb-3">
                                <div className="media">
                                    <div className="mr-3 d-flex align-items-center"> {/* برای تراز عمودی بهتر */}
                                        <i className={`fa ${notification.icon} font-20 text-muted`}></i>
                                        <a href="#!" className="ml-3">
                                            <img className="rounded-circle" style={{ width: 40, height: 40 }} src={notification.img} alt="آواتار" />
                                        </a>
                                    </div>
                                    <div className="media-body">
                                        <h6 className="d-inline-block" style={{ fontSize: '14px', marginBottom: '4px' }}>{notification.text}</h6>
                                        <p className="mb-0 text-muted" style={{ fontSize: '12px' }}>{notification.time}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default Notifications;