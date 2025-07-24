import React from "react";

const TodaySalesWidget = ({ salesCount }) => (
  <div className="card">
    <div className="card-body py-4">
      <div className="media align-items-center">
        <div className="d-inline-block mr-3">
          <i className="fa fa-shopping-cart font-30 text-success"></i>
        </div>
        <div className="media-body mr-3">
          <h3 className="mb-2 font-24">{Number(salesCount).toLocaleString('fa-IR')}</h3>
          <div className="mb-0 font-14 font-weight-bold">فروش امروز</div>
        </div>
      </div>
    </div>
  </div>
);

export default TodaySalesWidget;