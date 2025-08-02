import React, { useEffect, useState } from 'react';
import { usePage } from '@inertiajs/react';

// توابع کمکی تاریخ و ساعت (بدون تغییر)
function toPersianDigits(str) {
    if (!str) return '';
    return str.toString().replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
}

function getJalaliDate() {
    const d = new Date();
    const weekday = d.toLocaleDateString('fa-IR', { weekday: 'long' });
    const day = d.toLocaleDateString('fa-IR', { day: 'numeric' });
    const month = d.toLocaleDateString('fa-IR', { month: 'long' });
    const year = d.toLocaleDateString('fa-IR', { year: 'numeric' });
    return `${weekday} ${day} ${month} ${year}`;
}

const DashboardHeader = () => {
    // **این کامپوننت دیگر نیازی به دریافت پراپ‌های چت و نوتیفیکیشن ندارد**
    // چون آنها در کامپوننت Layout اصلی استفاده خواهند شد.
    // این کامپوننت فقط مسئول نمایش بخش خوش‌آمدگویی و ساعت است.
    
    const [time, setTime] = useState('');
    const [date, setDate] = useState('');

    useEffect(() => {
        const interval = setInterval(() => {
            const now = new Date();
            const h = now.getHours().toString().padStart(2, '0');
            const m = now.getMinutes().toString().padStart(2, '0');
            const s = now.getSeconds().toString().padStart(2, '0');
            setTime(`${toPersianDigits(h)}:${toPersianDigits(m)}:${toPersianDigits(s)}`);
            setDate(getJalaliDate());
        }, 1000);
        return () => clearInterval(interval);
    }, []);

    return (
        <div className="dashboard-header-area">
            <div className="row align-items-center">
                <div className="col-6">
                    <div className="dashboard-header-title">
                        <h5 className="font-weight-bold">داشبورد</h5>
                        <p className="font-weight-bold">به پنل مدیریت خوش آمدید.</p>
                    </div>
                </div>
                <div className="col-6">
                    <div className="dashboard-infor-mation d-flex flex-wrap align-items-center justify-content-end">
                        <div className="dashboard-clock ltr text-right">
                             {/* در css شما text-align: left بود که من به right تغییر دادم */}
                            <span>{date}</span><br />
                            <span className="dashboard-clock-time" style={{fontWeight:700, color:'#1a237e', fontSize: '1.2rem'}}>{time}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DashboardHeader;









