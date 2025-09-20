import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import axios from 'axios';

function toggleFullScreen() {
    if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
        const docElm = document.documentElement;
        if (docElm.requestFullscreen) docElm.requestFullscreen();
        else if (docElm.mozRequestFullScreen) docElm.mozRequestFullScreen();
        else if (docElm.webkitRequestFullscreen) docElm.webkitRequestFullscreen();
        else if (docElm.msRequestFullscreen) docElm.msRequestFullscreen();
    } else {
        if (document.exitFullscreen) document.exitFullscreen();
        else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
        else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
        else if (document.msExitFullscreen) document.msExitFullscreen();
    }
}

// پراپ setNotifications را هم برای آپدیت خوش‌بینانه دریافت می‌کند
const Header = ({ onDesktopMenuToggle, onMobileMenuToggle, notifications, conversations }) => {
    const { auth } = usePage().props;
    const user = auth?.user;

    const unreadMessagesCount = (conversations || []).reduce((sum, convo) => sum + (convo.unread_count || 0), 0);
    
    const handleNotificationsClick = () => {
        if (notifications.length > 0) {
            axios.post(route('dashboard.notifications.markAsRead'));
            // آپدیت خوش‌بینانه: state را در والد تغییر می‌دهد
            // setNotifications([]);
        }
    };

    return (
        <header className="top-header-area d-flex align-items-center justify-content-between">
           
            <div className="left-side-content-area d-flex align-items-center">
                <div className="mobile-logo mr-3 mr-sm-4">
                    <a href="/dashboard"><img src="/admin/img/core-img/small-logo.png" alt="آرم موبایل" /></a>
                </div>
                <div className="ecaps-triggers mr-1 mr-sm-3">
                    <div className="menu-collasped" onClick={onDesktopMenuToggle}><i className="zmdi zmdi-menu"></i></div>
                    <div className="mobile-menu-open" onClick={onMobileMenuToggle}><i className="zmdi zmdi-menu"></i></div>
                </div>
                <ul className="left-side-navbar d-flex align-items-center">
                    <li className="hide-phone app-search">
                        <form className="input-group" role="search"><input type="text" className="form-control" placeholder="جستجو ..." /></form>
                    </li>
                </ul>
            </div>
            <div className="right-side-navbar d-flex align-items-center justify-content-end">
                <ul className="right-side-content d-flex align-items-center">
                    <li className="full-screen-mode ml-1">
                        <a href="#" onClick={e => { e.preventDefault(); toggleFullScreen(); }}><i className="zmdi zmdi-fullscreen"></i></a>
                    </li>
                    {/* زبان (بدون تغییر) */}
                    <li className="nav-item dropdown"> ... </li>
                    
                    {/* **شروع بخش داینامیک پیام‌ها** */}
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown"><i className="zmdi zmdi-shopping-basket"></i>
                            {unreadMessagesCount > 0 && <span className="active-status"></span>}
                        </button>
                        <div className="dropdown-menu dropdown-menu-right">
                            <div className="top-message-area">
                                <div className="top-message-heading">
                                    <div className="heading-title"><h6>پیام ها</h6></div>
                                    <span>{unreadMessagesCount} جدید</span>
                                </div>
                                <div className="message-box" style={{maxHeight: 255, overflowY: 'auto'}}>
                                    {unreadMessagesCount > 0 ? conversations.map(convo => (
                                        <a href="#" className="dropdown-item" key={`convo-${convo.user.id}`}>
                                            <img src={convo.user.avatar} alt={convo.user.name} />
                                            <span className="message-text">
                                                <span>{convo.user.name}</span>
                                                <span>{convo.last_message}</span>
                                            </span>
                                        </a>
                                    )) : <p className="text-center p-3 text-muted">پیام جدیدی وجود ندارد.</p>}
                                </div>
                            </div>
                        </div>
                    </li>

                    {/* بخش اطلاعیه‌ها */}
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown" onClick={handleNotificationsClick}>
                            <i className="zmdi zmdi-notifications-active"></i>
                            {/* **مستقیماً از پراپ notifications.length استفاده می‌کند** */}
                            {notifications.length > 0 && <span className="active-status"></span>}
                        </button>
                        <div className="dropdown-menu dropdown-menu-right">
                            <div className="top-notifications-area">
                                <div className="notifications-heading"><h6>اطلاعیه</h6></div>
                                <div className="notifications-box" style={{maxHeight: 255, overflowY: 'auto'}}>
                                    {notifications && notifications.length > 0 ? notifications.map(notif => (
                                        <Link href={notif.url} className="dropdown-item" key={notif.id}>
                                            <i className={`fa ${notif.icon}`}></i>
                                            <span>{notif.text} <small className="text-muted d-block">{notif.time}</small></span>
                                        </Link>
                                    )) : <p className="text-center p-3 text-muted">اطلاعیه جدیدی وجود ندارد.</p>}
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    {/* **شروع بخش داینامیک کاربر** */}
                    <li className="nav-item dropdown">
                        <button type="button" className="btn dropdown-toggle" data-toggle="dropdown">
                            {user && <img src={user.avatar} alt={user.name} />}
                        </button>
                        <div className="dropdown-menu dropdown-menu-right">
                            <div className="user-profile-area">
                                <div className="user-profile-heading">
                                    <div className="profile-img">
                                        {user && <img className="chat-img mr-2" src={user.avatar} alt={user.name} />}
                                    </div>
                                    <div className="profile-text">
                                        <h6>{user?.name}</h6>
                                        <span>{user?.email}</span>
                                    </div>
                                </div>
                                <Link href={route('profile')} className="dropdown-item"><i className="zmdi zmdi-account profile-icon bg-primary"></i> پروفایل من</Link>
                                <Link href="#" className="dropdown-item"><i className="zmdi zmdi-email-open profile-icon bg-success"></i> پیام ها</Link>
                                <Link href={route('logout')} method="post" as="button" className="dropdown-item">
                                    <i className="ti-unlink profile-icon bg-warning"></i> خروج از سیستم
                                </Link>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
    );
};

export default Header;

