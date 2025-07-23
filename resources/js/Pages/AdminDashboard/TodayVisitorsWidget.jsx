import React from "react";

const TodayVisitorsWidget = ({ visitorsCount }) => (
  <div className="card">
    <div className="card-body py-4">
      <div className="media align-items-center">
        <div className="d-inline-block mr-3">
          <i className="fa fa-users font-30 text-warning"></i> {/* آیکون را به کاربران تغییر دادم */}
        </div>
        <div className="media-body mr-3">
          <h3 className="mb-2 font-24">{visitorsCount.toLocaleString('fa-IR')}</h3>
          <div className="mb-0 font-14 font-weight-bold">بازدید کنندگان امروز</div>
        </div>
      </div>
    </div>
  </div>
);

export default TodayVisitorsWidget;