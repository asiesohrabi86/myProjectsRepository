import React, { useEffect, useState } from 'react';

function toPersianDigits(str) {
    return str.replace(/\d/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
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
    const [time, setTime] = useState('');
    const [date, setDate] = useState('');

    useEffect(() => {
        function update() {
            const now = new Date();
            const h = now.getHours().toString().padStart(2, '0');
            const m = now.getMinutes().toString().padStart(2, '0');
            const s = now.getSeconds().toString().padStart(2, '0');
            setTime(`${toPersianDigits(h)}:${toPersianDigits(m)}:${toPersianDigits(s)}`);
            setDate(getJalaliDate());
        }
        update();
        const interval = setInterval(update, 1000);
        return () => clearInterval(interval);
    }, []);

    return (
        <div className="dashboard-header-area box-shadow rounded mb-3 p-3">
            <div className="row align-items-center">
                <div className="col-6">
                    <div className="dashboard-header-title mb-3">
                        <h5 className="mb-0 font-weight-bold">داشبورد</h5>
                        <p className="mb-0 font-weight-bold">به پنل مدیریت خوش آمدید.</p>
                    </div>
                </div>
                <div className="col-6">
                    <div className="dashboard-infor-mation d-flex flex-wrap align-items-center mb-3 justify-content-end">
                        <div className="dashboard-clock ltr text-left">
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