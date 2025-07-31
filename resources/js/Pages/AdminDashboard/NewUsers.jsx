import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import WidgetSkeleton from '@/Components/WidgetSkeleton'; // استفاده از اسکلت عمومی

const NewUsers = ({ newUsersDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [activeTab, setActiveTab] = useState('month'); // تب پیش‌فرض "ماه"

    useEffect(() => {
        if (newUsersDataProp) {
            setData(newUsersDataProp);
            return;
        }
        setLoading(true);
        setError(null);
        router.reload({
            only: ['newUsersData'],
            onSuccess: (page) => setData(page.props.newUsersData),
            onError: (errors) => {
                console.error("Error fetching new users data:", errors);
                setError('خطا در بارگذاری کاربران.');
            },
            onFinish: () => setLoading(false),
        });
    }, [newUsersDataProp]);

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
    
    if (!data) return null;

    const usersToShow = data[activeTab] || [];

    return (
        <div className="card bg-boxshadow full-height d-flex flex-column">
            <div className="card-header bg-transparent user-area d-flex align-items-center justify-content-between">
                <h5 className="card-title mb-0">کاربران جدید</h5>
                <ul className="nav total-earnings nav-tabs mb-0" role="tablist">
                    <li className="nav-item">
                        <button className={`nav-link${activeTab === 'today' ? ' active' : ''}`} onClick={() => setActiveTab('today')}>امروز</button>
                    </li>
                    <li className="nav-item">
                        <button className={`nav-link${activeTab === 'month' ? ' active' : ''}`} onClick={() => setActiveTab('month')}>ماه</button>
                    </li>
                </ul>
            </div>
            {/* *** شروع بخش استایل‌دهی و اسکرول *** */}
            <div className="card-body" style={{ flex: '1 1 auto', overflowY: 'auto', minHeight: '300px' }}>
                {usersToShow.length > 0 ? (
                    <ul className="list-unstyled mb-0">
                        {usersToShow.map((user, index) => (
                            <li key={index} className="d-flex align-items-center justify-content-between mb-3">
                                <div className="author-info d-flex align-items-center">
                                    <div className="author-img mr-3">
                                        <img src={user.img} alt={user.name} className="rounded-circle" width="40" height="40" />
                                    </div>
                                    <div className="author-text">
                                        <h6 className="mb-0">{user.name}</h6>
                                        <p className="mb-0 text-muted">{user.role}</p>
                                    </div>
                                </div>
                                <a href="#" className="badge badge-primary">دنبال کردن</a>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <div className="text-center text-muted mt-4">
                        <p>کاربر جدیدی برای نمایش در این بازه زمانی وجود ندارد.</p>
                    </div>
                )}
            </div>
            {/* *** پایان بخش استایل‌دهی و اسکرول *** */}
        </div>
    );
};

export default NewUsers;