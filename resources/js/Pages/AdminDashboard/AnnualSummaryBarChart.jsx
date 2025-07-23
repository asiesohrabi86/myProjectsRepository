import React from 'react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid } from 'recharts';

const data = [
  { name: 'صورتحساب', value: 2569.4 },
  { name: 'سود', value: 3569.6 },
  { name: 'هزینه ها', value: 356.9 },
];

const AnnualSummaryBarChart = () => (
  <div className="card">
    <div className="card-body">
      <h5 className="card-title">خلاصه سالانه</h5>
      <div className="row pb-3">
        <div className="col-md-4 col-6 text-center">
          <h5 className="f-w-300">2569.4 تومان</h5>
          <span>صورتحساب</span>
        </div>
        <div className="col-md-4 col-6 text-center">
          <h5 className="f-w-300">3569.6 تومان</h5>
          <span>سود</span>
        </div>
        <div className="col-md-4 col-12 text-center">
          <h5 className="f-w-300">356.9 تومان</h5>
          <span>هزینه ها</span>
        </div>
      </div>
      <div style={{ width: '100%', height: 300 }}>
        <ResponsiveContainer width="100%" height="100%">
          <BarChart data={data} margin={{ top: 10, right: 10, left: 10, bottom: 0 }}>
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="name" tick={{ fontFamily: 'inherit' }} />
            <YAxis />
            <Tooltip />
            <Bar dataKey="value" fill="#4e73df" radius={[8, 8, 0, 0]} barSize={40} />
          </BarChart>
        </ResponsiveContainer>
      </div>
    </div>
  </div>
);

export default AnnualSummaryBarChart;
