import React from 'react';

const TopProductTable = ({ products = [] }) => (
  <div className="card">
    <div className="card-body">
      <h5 className="card-title">محصول برتر</h5>
      <div className="product-table-area">
        <div className="table-responsive" id="dashboardTable" style={{ maxHeight: 370, overflowY: 'auto' }}>
          <table className="table table-hover">
            <thead>
              <tr>
                <th className="text-nowrap">تولید - محصول</th>
                <th className="text-nowrap">کد</th>
                <th className="text-nowrap">حراجی</th>
                <th className="text-nowrap">درآمد</th>
                <th className="text-nowrap" style={{ maxWidth: 70 }}>موجودی</th>
              </tr>
            </thead>
            <tbody>
              {products.map((p, i) => (
                <tr key={i}>
                  <td className="text-nowrap">
                    <div className="media align-items-center">
                      <div className="chat-img mr-2">
                        <img src={p.img} alt="" />
                      </div>
                      <div>
                        <span>{p.name}</span>
                      </div>
                    </div>
                  </td>
                  <td className="text-nowrap">{p.code}</td>
                  <td className="text-nowrap">{p.auction}</td>
                  <td className="text-nowrap">{p.income}</td>
                  <td className="text-nowrap">
                    <div className="d-flex align-items-center">
                      <div className="progress progress-sm" style={{ width: 60 }}>
                        <div className={`progress-bar ${p.progressClass}`} style={{ width: `${p.progress}%` }}></div>
                      </div>
                      <div className="ml-2">
                        {p.stock}
                      </div>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
);

export default TopProductTable; 