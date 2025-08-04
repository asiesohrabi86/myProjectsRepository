import React, { useState, useEffect } from 'react';
import { usePage, router, Link } from '@inertiajs/react'; 
import WidgetSkeleton from '@/Components/WidgetSkeleton';

const Notifications = () => {
    // از usePage برای دسترسی مستقیم به پراپ‌ها استفاده می‌کنیم
    const { props } = usePage();
    // در بارگذاری اولیه، state را با داده‌های دریافتی از سرور پر می‌کنیم
    const [notifications, setNotifications] = useState(() => props.notifications || []);
    const [loading, setLoading] = useState(false); // لودینگ فقط برای reload

    // افکت برای آپدیت کردن state وقتی پراپ‌ها بعد از یک درخواست اینرشیا تغییر می‌کنند
    useEffect(() => {
        setNotifications(props.notifications || []);
    }, [props.notifications]);
    
    // این کامپوننت دیگر نیازی به واکشی اولیه ندارد چون داده‌ها با صفحه لود می‌شوند.
    const refreshNotifications = () => {
        setLoading(true);
        router.reload({ 
            only: ['notifications'],
            onSuccess: (page) => {
                setNotifications(page.props.notifications || []);
            },
            onFinish: () => setLoading(false)
        });
    };

    // اگر در حین بازخوانی بودیم، اسکلت را نشان بده
    if (loading) {
        return <WidgetSkeleton />;
    }

    return (
        // به کارت اصلی ارتفاع ثابت و کلاس‌های Flexbox می‌دهیم
        <div className="card full-height d-flex flex-column" style={{ minHeight: '550px' }}>
            <div className="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 className="card-title mb-0">آخرین اطلاعیه‌ها</h5>
                <button onClick={refreshNotifications} className="btn btn-sm btn-outline-secondary">
                    <i className="fa fa-refresh"></i>
                </button>
            </div>
            {/* به card-body می‌گوییم فضای باقی‌مانده را پر کند و در صورت نیاز اسکرول بخورد */}
            <div className="card-body" style={{ flex: '1 1 auto', overflowY: 'auto' }}>
                <div className="row">
                    {notifications.length > 0 ? (
                        notifications.map((notification) => (
                            <div className="col-12" key={notification.id}>
                                <div className="single-widget-timeline mb-3">
                                    <div className="media">
                                        <div className="mr-3 d-flex align-items-center">
                                            {/* از آیکون ارسال شده از بک‌اند استفاده می‌کنیم */}
                                            <i className={`fa ${notification.icon} font-24`}></i>
                                        </div>
                                        <div className="media-body">
                                            {/* از کامپوننت Link اینرشیا برای لینک‌های داخلی استفاده می‌کنیم */}
                                            <Link href={notification.url} className="d-block text-dark" style={{ textDecoration: 'none' }}>
                                                <h6 className="d-inline-block" style={{ fontSize: '14px', marginBottom: '4px' }}>
                                                    {notification.text}
                                                </h6>
                                            </Link>
                                            <p className="mb-0 text-muted" style={{ fontSize: '12px' }}>
                                                {notification.time}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="col-12 text-center text-muted mt-4">
                            <p>اطلاعیه‌ای برای نمایش وجود ندارد.</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default Notifications;

