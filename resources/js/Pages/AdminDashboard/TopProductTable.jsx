import React from 'react';

const products = [
  {
    img: 'admin/img/shop-img/best-4.png',
    name: 'تلفن تلفن',
    code: '2864',
    auction: 81,
    income: '1،912.00 تومان',
    stock: 824,
    progress: 82,
    progressClass: 'bg-success',
  },
  {
    img: 'admin/img/shop-img/best-3.png',
    name: 'ساعت مچی',
    code: '3664',
    auction: 26,
    income: '1،377.00 تومان',
    stock: 161,
    progress: 61,
    progressClass: 'bg-success',
  },
  {
    img: 'admin/img/shop-img/best-2.png',
    name: 'عينك آفتابي',
    code: '2364',
    auction: 71,
    income: '9،212.00 تومان',
    stock: 123,
    progress: 23,
    progressClass: 'bg-danger',
  },
  {
    img: 'admin/img/shop-img/best-3.png',
    name: 'ساعت مچی',
    code: '25664',
    auction: 79,
    income: '1،298.00 تومان',
    stock: 254,
    progress: 54,
    progressClass: 'bg-warning',
  },
  {
    img: 'admin/img/shop-img/best-4.png',
    name: 'تلفن تلفن',
    code: '9564',
    auction: 26,
    income: '1،377.00 تومان',
    stock: 61,
    progress: 61,
    progressClass: 'bg-success',
  },
  {
    img: 'admin/img/shop-img/best-3.png',
    name: 'ساعت مچی',
    code: '7864',
    auction: 71,
    income: '9،212.00 تومان',
    stock: 145,
    progress: 23,
    progressClass: 'bg-danger',
  },
  {
    img: 'admin/img/shop-img/best-2.png',
    name: 'عينك آفتابي',
    code: '1564',
    auction: 60,
    income: '7،376.00 تومان',
    stock: 176,
    progress: 76,
    progressClass: 'bg-success',
  },
];

const TopProductTable = () => (
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