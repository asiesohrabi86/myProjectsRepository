import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer, Legend } from 'recharts';
import WidgetSkeleton from '@/Components/WidgetSkeleton';

// یک کامپوننت سفارشی برای Tooltip تا اعداد فارسی و خوانا باشند
const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-white p-2 border rounded shadow-sm" style={{ direction: 'rtl' }}>
        <p className="font-weight-bold mb-1">{`ماه: ${label}`}</p>
        <p className="mb-0" style={{ color: payload[0].stroke }}>
          {`مجموع فروش: ${payload[0].value.toLocaleString('fa-IR')} تومان`}
        </p>
        <p className="mb-0" style={{ color: payload[1].stroke }}>
          {`تعداد سفارشات: ${payload[1].value.toLocaleString('fa-IR')}`}
        </p>
      </div>
    );
  }
  return null;
};

const DashboardOrderSummaryChart = ({ orderSummaryDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (orderSummaryDataProp) {
            setData(orderSummaryDataProp);
            return;
        }

        setLoading(true);
        setError(null);

        router.reload({
            only: ['orderSummaryData'],
            onSuccess: (page) => {
                setData(page.props.orderSummaryData);
            },
            onError: (errors) => {
                console.error("Error fetching order summary data:", errors);
                setError('خطا در بارگذاری اطلاعات نمودار.');
            },
            onFinish: () => {
                setLoading(false);
            },
        });
    }, [orderSummaryDataProp]);

    if (loading) {
        return <WidgetSkeleton />;
    }

    if (error) {
        return (
            <div className="card">
                <div className="card-body text-center text-danger">
                    <p>{error}</p>
                    <button className="btn btn-sm btn-secondary" onClick={() => router.reload({ only: ['orderSummaryData'] })}>
                        تلاش مجدد
                    </button>
                </div>
            </div>
        );
    }
    
    if (!data || data.length === 0) {
        return (
            <div className="card">
                <div className="card-body text-center">
                    <p>داده‌ای برای نمایش نمودار وجود ندارد.</p>
                </div>
            </div>
        );
    }

    return (
        <div className="card">
            <div className="card-body">
                <h5 className="card-title">خلاصه سفارشات (۱۲ ماه گذشته)</h5>
                <div style={{ width: '100%', height: 250 }}>
                    <ResponsiveContainer width="100%" height="100%">
                        <LineChart data={data} margin={{ top: 5, right: 30, left: 20, bottom: 5 }}>
                            <XAxis dataKey="name" tick={{ fontFamily: 'inherit', fontSize: 12 }} />
                            <YAxis yAxisId="left" tickFormatter={(value) => value.toLocaleString('fa-IR')} tick={{ fontFamily: 'inherit', fontSize: 12 }} />
                            <YAxis yAxisId="right" orientation="right" tick={{ fontFamily: 'inherit', fontSize: 12 }} />
                            <Tooltip content={<CustomTooltip />} />
                            <Legend wrapperStyle={{ fontFamily: 'inherit', fontSize: 14 }} />
                            <Line yAxisId="left" name="مجموع فروش (تومان)" type="monotone" dataKey="totalSales" stroke="#4e73df" strokeWidth={3} activeDot={{ r: 8 }} />
                            <Line yAxisId="right" name="تعداد سفارشات" type="monotone" dataKey="orderCount" stroke="#a084e8" strokeWidth={3} activeDot={{ r: 8 }} />
                        </LineChart>
                    </ResponsiveContainer>
                </div>
            </div>
        </div>
    );
};

export default DashboardOrderSummaryChart;