import React from 'react';

const DashboardEarningCard = () => (
  <div className="card bg-primary earning-date">
    <div className="card-body">
      <div className="dashboard-tab-area">
        <h5 className="text-white card-title">درآمد</h5>
        <div className="bd-example bd-example-tabs">
          <div className="tab-content" id="tabContent-pills">
            <div className="tab-pane fade active show" id="earnings-thu" role="tabpanel" aria-labelledby="pills-earnings-thu">
              <div className="d-flex align-items-center justify-content-between">
                <div>
                  <h2 className="text-white mb-3 font-30">
                    ۲۵۶٬۲۳۴ <i className="fa fa-long-arrow-up"></i>
                  </h2>
                  <span className="text-white mb-3 d-block">درآمد کل</span>
                </div>
                <div className="dashboard-tab-thumb">
                  <img src="admin/img/bg-img/6.svg" alt="" />
                </div>
              </div>
            </div>
          </div>
          <ul className="nav nav-pills align-items-center" id="pills-tab" role="tablist">
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-sat" data-toggle="pill" href="#earnings-sat" role="tab" aria-controls="earnings-sat" aria-selected="false">نشسته</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-sun" data-toggle="pill" href="#earnings-sun" role="tab" aria-controls="earnings-sun" aria-selected="false">آفتاب</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-mon" data-toggle="pill" href="#earnings-mon" role="tab" aria-controls="earnings-mon" aria-selected="false">دوشنبه</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-tue" data-toggle="pill" href="#earnings-tue" role="tab" aria-controls="earnings-tue" aria-selected="false">سه شنبه</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-wed" data-toggle="pill" href="#earnings-wed" role="tab" aria-controls="earnings-wed" aria-selected="false">چهارشنبه</a>
            </li>
            <li className="nav-item">
              <a className="nav-link active show" id="pills-earnings-thu" data-toggle="pill" href="#earnings-thu" role="tab" aria-controls="earnings-thu" aria-selected="true">پنجشنبه</a>
            </li>
            <li className="nav-item">
              <a className="nav-link" id="pills-earnings-fri" data-toggle="pill" href="#earnings-fri" role="tab" aria-controls="earnings-fri" aria-selected="false">جمعه</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
);

export default DashboardEarningCard; 