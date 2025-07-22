import React from 'react';

function toggleFullScreen() {
    if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.mozFullScreenElement && !document.msFullscreenElement) {
        const docElm = document.documentElement;
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullscreen) {
            docElm.webkitRequestFullscreen();
        } else if (docElm.msRequestFullscreen) {
            docElm.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

const Header = ({ onDesktopMenuToggle, onMobileMenuToggle }) => {
    return (
        <header className="top-header-area d-flex align-items-center justify-content-between">
            <div className="left-side-content-area d-flex align-items-center">
                {/* Mobile Logo */}
                <div className="mobile-logo mr-3 mr-sm-4">
                    <a href="/dashboard"><img src="/admin/img/core-img/small-logo.png" alt="آرم موبایل" /></a>
                </div>
                {/* Triggers */}
                <div className="ecaps-triggers mr-1 mr-sm-3">
                    <div className="menu-collasped" id="menuCollasped" onClick={onDesktopMenuToggle}>
                        <i className="zmdi zmdi-menu"></i>
                    </div>
                    <div className="mobile-menu-open" id="mobileMenuOpen" onClick={onMobileMenuToggle}>
                        <i className="zmdi zmdi-menu"></i>
                    </div>
                </div>
                {/* Left Side Nav */}
                <ul className="left-side-navbar d-flex align-items-center">
                    <li className="hide-phone app-search">
                        <form className="input-group" role="search">
                            <input type="text" className="form-control" placeholder="جستجو ..." aria-label="جستجو" />
                        </form>
                    </li>
                </ul>
            </div>
            <div className="right-side-navbar d-flex align-items-center justify-content-end">
                {/* Mobile Trigger */}
                <div className="right-side-trigger" id="rightSideTrigger">
                    <i className="ti-align-left"></i>
                </div>
                {/* Top Bar Nav */}
                <ul className="right-side-content d-flex align-items-center">
                    {/* Full Screen Mode */}
                    <li className="full-screen-mode ml-1">
                        <a href="#" id="fullScreenMode" onClick={e => { e.preventDefault(); toggleFullScreen(); }}><i className="zmdi zmdi-fullscreen"></i></a>
                    </li>
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle font-15 text-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">انگلیسی<i className="fa fa-angle-down"></i></button>
                        <div className="dropdown-menu language-dropdown dropdown-menu-right text-right" style={{direction: 'rtl'}}>
                            <a href="#" className="dropdown-item">فرانسوی </a>
                            <a href="#" className="dropdown-item">آلمانی </a>
                            <a href="#" className="dropdown-item">هندی</a>
                        </div>
                    </li>
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i className="zmdi zmdi-shopping-basket" aria-hidden="true"></i></button>
                        <div className="dropdown-menu dropdown-menu-right">
                            {/* Top Message Area */}
                            <div className="top-message-area">
                                {/* Heading */}
                                <div className="top-message-heading">
                                    <div className="heading-title">
                                        <h6>پیام ها</h6>
                                    </div>
                                    <span>5 جدید</span>
                                </div>
                                <div className="message-box" id="messageBox" style={{maxHeight: 255, overflowY: 'auto', direction: 'rtl'}}>
                                    <a href="#" className="dropdown-item">
                                        <img src="/admin/img/member-img/1.png" alt="" />
                                        <span className="message-text">
                                            <span>دوره ویدیوی 6 ساعته در Angular </span>
                                            <span>3 دقیقه پیش </span>
                                        </span>
                                    </a>
                                    <a href="#" className="dropdown-item">
                                        <img src="/admin/img/member-img/1.png" alt="" />
                                        <span className="message-text">
                                            <span>دوره ویدیوی 6 ساعته در Angular </span>
                                            <span>3 دقیقه پیش </span>
                                        </span>
                                    </a>
                                    <a href="#" className="dropdown-item">
                                        <img src="/admin/img/member-img/1.png" alt="" />
                                        <span className="message-text">
                                            <span>دوره ویدیوی 6 ساعته در Angular </span>
                                            <span>3 دقیقه پیش </span>
                                        </span>
                                    </a>
                                    <a href="#" className="dropdown-item">
                                        <img src="/admin/img/member-img/1.png" alt="" />
                                        <span className="message-text">
                                            <span>دوره ویدیوی 6 ساعته در Angular </span>
                                            <span>3 دقیقه پیش </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i className="zmdi zmdi-volume-up" aria-hidden="true"></i> <span className="active-status"></span></button>
                        <div className="dropdown-menu dropdown-menu-right">
                            {/* Top Notifications Area */}
                            <div className="top-notifications-area">
                                {/* Heading */}
                                <div className="notifications-heading">
                                    <div className="heading-title">
                                        <h6>اطلاعیه</h6>
                                    </div>
                                    <span>5 جدید</span>
                                </div>
                                <div className="notifications-box" id="notificationsBox" style={{maxHeight: 255, overflowY: 'auto', direction: 'rtl'}}>
                                    <a href="#" className="dropdown-item"><i className="ti-face-smile bg-success"></i><span>ما یک چیزی برای شما داریم!</span></a>
                                    <a href="#" className="dropdown-item"><i className="zmdi zmdi-notifications-active bg-danger"></i><span>نام دامنه در روز سه شنبه منقضی می شود</span></a>
                                    <a href="#" className="dropdown-item"><i className="ti-check"></i><span>کمیسیون های شما ارسال شده است</span></a>
                                    <a href="#" className="dropdown-item"><i className="ti-heart bg-success"></i><span>شما یک مورد را فروختید!</span></a>
                                    <a href="#" className="dropdown-item"><i className="ti-face-smile bg-success"></i><span>ما یک چیزی برای شما داریم!</span></a>
                                    <a href="#" className="dropdown-item"><i className="zmdi zmdi-notifications-active bg-danger"></i><span>نام دامنه در روز سه شنبه منقضی می شود</span></a>
                                    <a href="#" className="dropdown-item"><i className="ti-check"></i><span>کمیسیون های شما ارسال شده است</span></a>
                                    <a href="#" className="dropdown-item"><i className="ti-heart bg-success"></i><span>شما یک مورد را فروختید!</span></a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="/admin/img/member-img/3.png" alt="" /></button>
                        <div className="dropdown-menu dropdown-menu-right">
                            {/* User Profile Area */}
                            <div className="user-profile-area">
                                <div className="user-profile-heading">
                                    {/* Thumb */}
                                    <div className="profile-img">
                                        <img className="chat-img mr-2" src="/admin/img/member-img/3.png" alt="" />
                                    </div>
                                    {/* Profile Text */}
                                    <div className="profile-text">
                                        <h6>نام کاربر</h6>
                                        <span>توسعه دهنده</span>
                                    </div>
                                </div>
                                <a href="#" className="dropdown-item"><i className="zmdi zmdi-account profile-icon bg-primary" aria-hidden="true"></i> پروفایل من</a>
                                <a href="#" className="dropdown-item"><i className="zmdi zmdi-email-open profile-icon bg-success" aria-hidden="true"></i> پیام ها</a>
                                <a href="#" className="dropdown-item"><i className="zmdi zmdi-brightness-7 profile-icon bg-info" aria-hidden="true"></i> تنظیمات حساب</a>
                                <a href="#" className="dropdown-item"><i className="zmdi zmdi-mouse profile-icon bg-danger" aria-hidden="true"></i> وظایف من</a>
                                <a href="#" className="dropdown-item"><i className="zmdi zmdi-wifi-alt profile-icon bg-purple" aria-hidden="true"></i> پشتیبانی</a>
                                <a href="#" className="dropdown-item"><i className="ti-unlink profile-icon bg-warning" aria-hidden="true"></i> خروج از سیستم</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
    );
};

export default Header; 