import React, { useState } from 'react';

const todayUsers = [
  { img: 'admin/img/member-img/team-2.jpg', name: 'نام کاربر', role: 'طراح محصول' },
  { img: 'admin/img/member-img/team-3.jpg', name: 'دیسک نیلی', role: 'توسعه دهنده وب' },
  { img: 'admin/img/member-img/team-4.jpg', name: 'ویلتور دلتون', role: 'مدیر پروژه' },
  { img: 'admin/img/member-img/team-5.jpg', name: 'نیک استون', role: 'طراح ویژوال' },
  { img: 'admin/img/member-img/team-7.jpg', name: 'ویلتور دلتون', role: 'مدیر پروژه' },
];
const monthUsers = [
  { img: 'admin/img/member-img/2.png', name: 'ویلتور دلتون', role: 'مدیر پروژه' },
  { img: 'admin/img/member-img/3.png', name: 'نام کاربر', role: 'طراح محصول' },
  { img: 'admin/img/member-img/4.png', name: 'دیسک نیلی', role: 'توسعه دهنده وب' },
  { img: 'admin/img/member-img/1.png', name: 'نظرالاسلام', role: 'طراح ویژوال' },
  { img: 'admin/img/member-img/5.png', name: 'نیک استون', role: 'طراح ویژوال' },
];

const NewUsers = () => {
  const [tab, setTab] = useState('month');
  const users = tab === 'today' ? todayUsers : monthUsers;
  return (
    <div className="card bg-boxshadow full-height mb-3">
      <div className="card-header bg-transparent user-area d-flex align-items-center justify-content-between">
        <h5 className="card-title mb-0">کاربران جدید</h5>
        <ul className="nav total-earnings nav-tabs mb-0" role="tablist">
          <li className="nav-item">
            <button className={`nav-link${tab === 'today' ? ' active' : ''}`} onClick={() => setTab('today')}>امروز</button>
          </li>
          <li className="nav-item">
            <button className={`nav-link${tab === 'month' ? ' active' : ''}`} onClick={() => setTab('month')}>ماه</button>
          </li>
        </ul>
      </div>
      <div className="card-body">
        <ul className="total-earnings-list">
          {users.map((u, i) => (
            <li key={i} className="d-flex align-items-center justify-content-between mb-3">
              <div className="author-info d-flex align-items-center">
                <div className="author-img mr-3">
                  <img src={u.img} alt="" />
                </div>
                <div className="author-text">
                  <h6 className="mb-0">{u.name}</h6>
                  <p className="mb-0">{u.role}</p>
                </div>
              </div>
              <button className="badge badge-primary">دنبال کردن</button>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default NewUsers;
