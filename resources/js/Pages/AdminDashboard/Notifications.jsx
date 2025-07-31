import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import WidgetSkeleton from '@/Components/WidgetSkeleton';

const Notifications = ({ notificationsDataProp }) => {
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
            <div className="card full-height">
                <div className="card-header"><h5 className="card-title">اطلاعیه</h5></div>
                <div className="card-body text-center text-muted">
                    <p>اطلاعیه جدیدی برای نمایش وجود ندارد.</p>
                </div>
            </div>
        );
    }
    
    return (
        <div className="card full-height d-flex flex-column">
            <div className="card-header bg-transparent">
                <h5 className="card-title mb-0">اطلاعیه</h5>
            </div>
            <div className="card-body" style={{ flex: '1 1 auto', overflowY: 'auto', minHeight: '300px' }}>
                <div className="row">
                    {data.map((notification) => (
                        <div className="col-12" key={notification.id}>
                            <div className="single-widget-timeline mb-3">
                                <div className="media">
                                    <div className="mr-3">
                                        <i className={`fa ${notification.icon} font-20 mr-2`}></i>
                                        <a href="#!"><img className="rounded-circle" style={{ width: 40, height: 40 }} src={notification.img} alt="آواتار" /></a>
                                    </div>
                                    <div className="media-body">
                                        <h6 className="d-inline-block">{notification.text}</h6>
                                        <p className="mb-0 text-muted">{notification.time}</p>
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