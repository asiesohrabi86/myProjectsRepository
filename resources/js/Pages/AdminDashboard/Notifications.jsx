import React from 'react';

const notifications = [
  { img: 'admin/img/member-img/1.png', text: 'لورم ایپسوم متن ساختگی', desc: 'لورم ایپسوم به سادگی…' },
  { img: 'admin/img/member-img/team-1.jpg', text: 'لورم ایپسوم متن ساختگی', desc: 'لورم ایپسوم متن ساده ای است ...' },
  { img: 'admin/img/member-img/team-2.jpg', text: 'لورم ایپسوم متن ساختگی', desc: 'لورم ایپسوم متن ساده ای است ...' },
  { img: 'admin/img/member-img/team-1.jpg', text: 'لورم ایپسوم متن ساختگی', desc: 'لورم ایپسوم متن ساده ای است ...' },
  { img: 'admin/img/member-img/team-4.jpg', text: 'لورم ایپسوم متن ساختگی', desc: 'لورم ایپسوم متن ساختگی با تولید سادگی' },
];

const Notifications = () => (
  <div className="card mb-3">
    <div className="card-body">
      <h5 className="card-title">اطلاعیه</h5>
      <div className="row">
        {notifications.map((n, i) => (
          <div className="col-12" key={i}>
            <div className="single-widget-timeline mb-15">
              <div className="media">
                <div className="mr-3">
                  <i className="fa fa-circle text-success font-11 mr-2"></i>
                  <a href="#!"><img className="rounded-circle" style={{ width: 40 }} src={n.img} alt="کاربر چت" /></a>
                </div>
                <div className="media-body">
                  <h6 className="d-inline-block">{n.text}</h6>
                  <p className="mb-0">{n.desc}</p>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  </div>
);

export default Notifications;
