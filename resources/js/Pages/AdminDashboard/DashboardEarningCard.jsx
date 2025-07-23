import React, { useState, useEffect, useMemo } from 'react';
import { router } from '@inertiajs/react';
import WidgetSkeleton from '@/Components/WidgetSkeleton'; // <-- ایمپورت کامپوننت اسکلتی جدید

const DashboardEarningCard = ({ earningsDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [activeTabKey, setActiveTabKey] = useState(null);

    useEffect(() => {
        if (earningsDataProp) {
            setData(earningsDataProp);
            if (earningsDataProp.length > 0) {
                setActiveTabKey(earningsDataProp[earningsDataProp.length - 1].dayKey);
            }
            return;
        }

        setLoading(true);
        setError(null);

        router.reload({
            only: ['weeklyEarnings'],
            onSuccess: (page) => {
                const newData = page.props.weeklyEarnings;
                setData(newData);
                if (newData && newData.length > 0) {
                    setActiveTabKey(newData[newData.length - 1].dayKey);
                }
            },
            onError: (errors) => {
                console.error("Error fetching earnings data:", errors);
                setError('خطا در بارگذاری اطلاعات درآمد.');
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    }, [earningsDataProp]);

    const activeDayData = useMemo(() => {
        if (!data || !activeTabKey) return null;
        return data.find(day => day.dayKey === activeTabKey);
    }, [data, activeTabKey]);

    if (loading) {
        // استفاده از کامپوننت اسکلتی جنریک
        return <WidgetSkeleton className="bg-primary" />;
    }

    if (error) {
        return (
            <div className="card bg-danger text-white earning-date">
                <div className="card-body text-center">
                    <p>{error}</p>
                    <button className="btn btn-sm btn-light" onClick={() => router.reload({ only: ['weeklyEarnings'] })}>
                        تلاش مجدد
                    </button>
                </div>
            </div>
        );
    }
    
    if (!data || !activeDayData) {
        return (
             <div className="card bg-secondary text-white earning-date">
                <div className="card-body text-center">
                    <p>داده‌ای برای نمایش درآمد وجود ندارد.</p>
                </div>
            </div>
        );
    }

    return (
        <div className="card bg-primary earning-date">
            <div className="card-body">
                <div className="dashboard-tab-area">
                    <h5 className="text-white card-title">درآمد</h5>
                    <div className="bd-example bd-example-tabs">
                        <div className="tab-content" id="tabContent-pills">
                            <div className="tab-pane fade active show" role="tabpanel">
                                <div className="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h2 className="text-white mb-3 font-30">
                                            {activeDayData.earning.toLocaleString('fa-IR')}
                                            {activeDayData.trend !== 'stable' && (
                                                <i className={`fa ${activeDayData.trend === 'up' ? 'fa-long-arrow-up' : 'fa-long-arrow-down'} mr-2`}></i>
                                            )}
                                        </h2>
                                        <span className="text-white mb-3 d-block">درآمد {activeDayData.dayName}</span>
                                    </div>
                                    <div className="dashboard-tab-thumb">
                                        <img src="/admin/img/bg-img/6.svg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul className="nav nav-pills align-items-center" id="pills-tab" role="tablist">
                            {data.map((day) => (
                                <li className="nav-item" key={day.dayKey}>
                                    <a
                                        className={`nav-link ${activeTabKey === day.dayKey ? 'active' : ''}`}
                                        href="#"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            setActiveTabKey(day.dayKey);
                                        }}
                                    >
                                        {day.dayName}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DashboardEarningCard;