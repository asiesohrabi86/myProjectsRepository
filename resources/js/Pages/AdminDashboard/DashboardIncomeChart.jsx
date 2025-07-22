import React from 'react';
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer } from 'recharts';

const data = [
  { name: 'Mon', value: 120 },
  { name: 'Tue', value: 100 },
  { name: 'Wed', value: 110 },
  { name: 'Thu', value: 130 },
  { name: 'Fri', value: 115 },
  { name: 'Sat', value: 125 },
  { name: 'Sun', value: 150 },
];

const DashboardIncomeChart = () => (
  <div className="card bg-c-blue">
    <div className="card-body">
      <h5 className="card-title">درآمد کل</h5>
      <div className="earning-text mb-4">
        <h3 className="mb-3">۲۹۵.۳۶ تومان <i className="feather icon-arrow-up teal accent-3"></i></h3>
        <span className="text-uppercase d-block">درآمد</span>
      </div>
      <div style={{ width: '100%', height: 200 }}>
        <ResponsiveContainer width="100%" height="100%">
          <LineChart data={data} margin={{ top: 10, right: 10, left: 0, bottom: 0 }}>
            <XAxis dataKey="name" tick={{ fontFamily: 'inherit' }} />
            <YAxis hide />
            <Tooltip />
            <Line type="monotone" dataKey="value" stroke="#4e73df" strokeWidth={2} dot={false} />
          </LineChart>
        </ResponsiveContainer>
      </div>
    </div>
  </div>
);

export default DashboardIncomeChart; 