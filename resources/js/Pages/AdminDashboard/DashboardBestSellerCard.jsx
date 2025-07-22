import React from 'react';

const DashboardBestSellerCard = () => (
  <div className="card">
    <div className="card-body">
      <h5 className="font-20 mb-1">تبریک می‌گوییم هیملا!</h5>
      <p className="mb-20">پرفروش‌ترین ماه</p>
      <div className="d-flex justify-content-between align-items-center">
        <div className="dashboard-content-right">
          <h2 className="text-success font-36 font-weight-bold">۵۹k تومان</h2>
          <p className="font-15 font-weight-bold">
            شما امروز ۶۵.۶٪ <br /> فروش بیشتر انجام داده‌اید .
          </p>
          <button type="button" className="btn btn-primary mt-15">مشاهده فروش</button>
        </div>
        <div className="dashboard-content-left wow shake" data-wow-delay="0.6s">
          <img src="admin/img/bg-img/5.jpg" className="img-fluid" alt="داشبورد" width="180" height="180" />
        </div>
      </div>
    </div>
  </div>
);

export default DashboardBestSellerCard; 