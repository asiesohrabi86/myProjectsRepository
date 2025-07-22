import React from 'react';
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer } from 'recharts';

const data = [
  { name: 'Jan', uv: 100, pv: 150 },
  { name: 'Feb', uv: 120, pv: 140 },
  { name: 'Mar', uv: 130, pv: 160 },
  { name: 'Apr', uv: 110, pv: 120 },
  { name: 'May', uv: 140, pv: 110 },
  { name: 'Jun', uv: 100, pv: 90 },
  { name: 'Jul', uv: 90, pv: 60 },
  { name: 'Aug', uv: 110, pv: 100 },
  { name: 'Sep', uv: 120, pv: 130 },
  { name: 'Oct', uv: 130, pv: 120 },
  { name: 'Nov', uv: 140, pv: 150 },
  { name: 'Dec', uv: 160, pv: 200 },
];

const DashboardOrderSummaryChart = () => (
  <div className="card">
    <div className="card-body">
      <h5 className="card-title">خلاصه سفارش</h5>
      <div style={{ width: '100%', height: 220 }}>
        <ResponsiveContainer width="100%" height="100%">
          <LineChart data={data} margin={{ top: 10, right: 10, left: 0, bottom: 0 }}>
            <XAxis dataKey="name" tick={{ fontFamily: 'inherit' }} />
            <YAxis />
            <Tooltip />
            <Line type="monotone" dataKey="uv" stroke="#4e73df" strokeWidth={3} dot={{ r: 6 }} activeDot={{ r: 8 }} />
            <Line type="monotone" dataKey="pv" stroke="#a084e8" strokeWidth={3} dot={{ r: 6 }} activeDot={{ r: 8 }} />
          </LineChart>
        </ResponsiveContainer>
      </div>
    </div>
  </div>
);

export default DashboardOrderSummaryChart; 