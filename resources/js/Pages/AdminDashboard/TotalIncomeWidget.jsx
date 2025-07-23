import React from "react";

const TotalIncomeWidget = ({ income }) => (
  <div className="card">
    <div className="card-body py-4">
      <div className="media align-items-center">
        <div className="d-inline-block mr-3">
          <i className="fas fa-money-check-alt font-30 text-info"></i> 
        </div>
        <div className="media-body mr-3">
          <h3 className="mb-2 font-24">{income.toLocaleString('fa-IR')}</h3>
          <div className="mb-0 font-14 font-weight-bold">درآمد کل (تومان)</div>
        </div>
      </div>
    </div>
  </div>
);

export default TotalIncomeWidget;