import React, { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import Sidebar from './Sidebar';
import Header from './Header';

export default function AdminLayout({ children }) {
    const { props } = usePage();
    const { auth } = props;
    const user = auth?.user;

    // State های مربوط به داده‌های زنده در اینجا مدیریت می‌شوند
    const [notifications, setNotifications] = useState(() => props.headerNotifications || []);
    const [conversations, setConversations] = useState(() => props.headerConversations || []);
    
    const [collapsed, setCollapsed] = useState(false); // برای باریک/پهن بودن سایدبار
    const [hovered, setHovered] = useState(false);    // برای هاور روی سایدبار
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false); // برای موبایل

    // این افکت فقط یک بار اجرا شده و Echo را برای همیشه راه‌اندازی می‌کند
    useEffect(() => {
        if (user && window.Echo) {
            // ۱. گوش دادن به نوتیفیکیشن‌های جدید
            window.Echo.private(`App.Models.User.${user.id}`)
                .notification((notification) => {
                    const newNotification = { /* ... فرمت کردن داده نوتیفیکیشن ... */ };
                    setNotifications(prev => [newNotification, ...prev]);
                });

            // ۲. گوش دادن به پیام‌های جدید
            const adminChannel = window.Echo.private('admin-chat');
            adminChannel.listen('\\App\\Events\\MessageSentToAdmin', (e) => {
                const newMessage = e.formattedMessage;
                // آپدیت کردن لیست مکالمات خوانده نشده
                setConversations(prev => {
                    // اگر مکالمه از قبل وجود داشت، آن را آپدیت کن
                    const existingConvoIndex = prev.findIndex(c => c.user.id === newMessage.user.id);
                    if (existingConvoIndex > -1) {
                        const updatedConvos = [...prev];
                        updatedConvos[existingConvoIndex].last_message = newMessage.text;
                        updatedConvos[existingConvoIndex].unread_count += 1;
                        return updatedConvos;
                    } else { // اگر مکالمه جدید بود، آن را اضافه کن
                        return [{ user: newMessage.user, last_message: newMessage.text, unread_count: 1 }, ...prev];
                    }
                });
            });

            return () => {
                window.Echo.leaveChannel(`App.Models.User.${user.id}`);
                window.Echo.leaveChannel('admin-chat');
            };
        }
    }, [user]); // فقط زمانی اجرا شود که اطلاعات کاربر در دسترس باشد
    
    // تشخیص سایز صفحه برای موبایل/دسکتاپ
    const isMobile = () => {
      return (window.innerWidth || document.documentElement.clientWidth) <= 991;
    };

    // هندل کلیک روی دکمه دسکتاپ
    const handleDesktopMenuToggle = () => {
      setCollapsed(v => !v);
    };

    // هندل کلیک روی دکمه موبایل
    const handleMobileMenuToggle = () => {
      setMobileMenuOpen(v => !v);
    };

    // اطمینان از ریست شدن state هنگام تغییر سایز صفحه
    useEffect(() => {
      const handleResize = () => {
        if (isMobile()) {
          setCollapsed(false);
        } else {
          setMobileMenuOpen(false);
        }
      };
      window.addEventListener('resize', handleResize);
      return () => window.removeEventListener('resize', handleResize);
    }, []);

    let wrapperClass = 'ecaps-page-wrapper';
    if (mobileMenuOpen) wrapperClass += ' mobile-menu-active';
    if (collapsed) wrapperClass += ' menu-collasped-active';
    if (collapsed && hovered) wrapperClass += ' sidemenu-hover-active';
    if (collapsed && !hovered) wrapperClass += ' sidemenu-hover-deactive';

    return (
        <div className={wrapperClass} style={{overflowX: 'hidden'}}>
            <Sidebar onMouseEnter={() => setHovered(true)}
            onMouseLeave={() => setHovered(false)}/>
            <div className="ecaps-page-content">
                {/* داده‌های زنده را به عنوان پراپ به هدر پاس می‌دهیم */}
                <Header 
                    onDesktopMenuToggle={() => setSidebarCollapsed(!isSidebarCollapsed)}
                    notifications={notifications}
                    setNotifications={setNotifications}
                    conversations={conversations}
                />
                <main className="main-content">
                    <div className="dashboard-area">
                      <div className="container-fluid" style={{overflowX: 'hidden'}}>
                        {children}
                      </div>
                    </div>
                </main>
            </div>
        </div>
    );
}

  