import React, { useState, useEffect } from 'react';
import { router } from '@inertiajs/react';
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid } from 'recharts';

// یک کامپوننت سفارشی برای Tooltip تا اعداد فارسی و خوانا باشند
const CustomTooltip = ({ active, payload, label }) => {
  if (active && payload && payload.length) {
    return (
      <div className="bg-dark p-2 border border-secondary rounded shadow-sm">
        <p className="mb-0 text-white">{`درآمد: ${payload[0].value.toLocaleString('fa-IR')} تومان`}</p>
      </div>
    );
  }
  return null;
};

const DashboardIncomeChart = ({ totalIncomeDataProp }) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (totalIncomeDataProp) {
            setData(totalIncomeDataProp);
            return;
        }
        setLoading(true);
        setError(null);
        router.reload({
            only: ['totalIncomeData'],
            onSuccess: (page) => setData(page.props.totalIncomeData),
            onError: (errors) => {
                console.error("Error fetching income chart data:", errors);
                setError('خطا در بارگذاری اطلاعات.');
            },
            onFinish: () => setLoading(false),
        });
    }, [totalIncomeDataProp]);

    if (loading) {
        return (
            <div className="card bg-info" aria-hidden="true">
                <div className="card-body placeholder-glow">
                    <h5 className="card-title placeholder col-7"></h5>
                    <div className="earning-text mb-4 mt-4">
                        <h3 className="mb-3 placeholder col-8"></h3>
                        <span className="placeholder col-5"></span>
                    </div>
                    <div className="placeholder col-12" style={{ height: 150 }}></div>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="card bg-danger text-white">
                <div className="card-body text-center">
                    <p>{error}</p>
                    <button className="btn btn-sm btn-light" onClick={() => router.reload({ only: ['totalIncomeData'] })}>
                        تلاش مجدد
                    </button>
                </div>
            </div>
        );
    }
    
    if (!data) return null;

    const trendIconClass = data.trend.direction === 'up' ? 'feather icon-arrow-up' : 'feather icon-arrow-down';
    const trendText = data.trend.direction === 'up' ? 'رشد نسبت به هفته قبل' : 'کاهش نسبت به هفته قبل';

    return (
        <div className="card bg-info text-white">
            <div className="card-body">
                <h5 className="card-title">درآمد این هفته</h5>
                <div className="earning-text my-4">
                    <h3 className="mb-3">
                        {data.thisWeekIncomeFormatted}
                        {data.trend.direction !== 'stable' && <i className={trendIconClass}></i>}
                    </h3>
                    <span className="d-block" style={{ fontSize: '0.8rem' }}>
                        {data.trend.direction !== 'stable' ? `${data.trend.percentage}% ${trendText}` : 'بدون تغییر نسبت به هفته قبل'}
                    </span>
                </div>
                
                <div style={{ width: '100%', height: 150 }}>
                    <ResponsiveContainer width="100%" height="100%">
                        <LineChart data={data.chartData} margin={{ top: 5, right: 10, left: -20, bottom: 0 }}>
                            {/* افزودن گرید برای خوانایی بهتر */}
                            <CartesianGrid strokeDasharray="3 3" stroke="#ffffff" opacity={0.2} />
                            
                            {/* فعال کردن محور افقی (X) */}
                            <XAxis 
                                dataKey="name" 
                                tick={{ fill: '#ffffff', fontFamily: 'inherit', fontSize: 12 }} 
                                axisLine={{ stroke: '#ffffff', opacity: 0.5 }}
                                tickLine={{ stroke: '#ffffff', opacity: 0.5 }}
                            />
                            
                            {/* فعال کردن محور عمودی (Y) */}
                            <YAxis 
                                tickFormatter={(value) => new Intl.NumberFormat('fa-IR', { notation: 'compact' }).format(value)}
                                tick={{ fill: '#ffffff', fontFamily: 'inherit', fontSize: 10 }}
                                axisLine={{ stroke: '#ffffff', opacity: 0.5 }}
                                tickLine={{ stroke: '#ffffff', opacity: 0.5 }}
                            />
                            
                            {/* افزودن Tooltip برای نمایش مقدار دقیق روی هاور */}
                            <Tooltip content={<CustomTooltip />} />
                            
                            <Line type="monotone" dataKey="value" stroke="#ffffff" strokeWidth={3} dot={false} activeDot={{ r: 6, fill: '#fff' }} />
                        </LineChart>
                    </ResponsiveContainer>
                </div>
        
            </div>
        </div>
    );
};

export default DashboardIncomeChart;