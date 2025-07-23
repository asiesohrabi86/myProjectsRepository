import React from 'react';

const chats = [
  { left: false, img: 'admin/img/member-img/1.png', text: 'چطور میتوانیم کمک کنیم؟ ما برای شما اینجا هستیم', white: true },
  { left: true, img: 'admin/img/member-img/2.png', text: 'سلام جیکوب ، می توانید به من کمک کنید تا آن را دریابم؟' },
  { left: false, img: 'admin/img/member-img/3.png', text: 'کاملا!', white: true },
  { left: true, img: 'admin/img/member-img/4.png', text: 'من به دنبال بهترین الگوی سرپرست هستم.' },
  { left: false, img: 'admin/img/member-img/5.png', text: 'Crest admin الگوی مدیریت پاسخگو bootstrap 4 است.', white: true },
  { left: true, img: 'admin/img/member-img/6.png', text: 'به نظر می رسد UI تمیز و تازه.' },
  { left: true, img: 'admin/img/member-img/6.png', text: 'این مناسب برای پروژه بعدی من است.' },
];

const ChatBoxWidget = () => (
  <div className="card mb-3">
    <div className="card-content">
      <div className="card-body chat-application">
        <h4 className="card-title">گپ</h4>
        <div className="chats" id="chatBox">
          <div className="chats">
            {chats.map((c, i) => (
              <div className={`chat${c.left ? ' chat-left' : ''}`} key={i}>
                <div className="chat-avatar">
                  <a className="avatar" data-toggle="tooltip" href="#" data-placement={c.left ? 'left' : 'right'} title="" data-original-title="">
                    <img src={c.img} alt="آواتار" />
                  </a>
                </div>
                <div className="chat-body">
                  <div className={`chat-content${c.white ? ' text-white' : ''}`}>{c.text}</div>
                </div>
              </div>
            ))}
          </div>
        </div>
        <form className="chat-app-input mt-1 row">
          <div className="col-12">
            <fieldset>
              <div className="input-group position-relative has-icon-left">
                <input type="text" className="form-control" placeholder="پیام" aria-describedby="button-addon3" />
                <div className="input-group-append">
                  <button className="btn btn-primary" type="button">ارسال</button>
                </div>
              </div>
            </fieldset>
          </div>
        </form>
      </div>
    </div>
  </div>
);

export default ChatBoxWidget;
