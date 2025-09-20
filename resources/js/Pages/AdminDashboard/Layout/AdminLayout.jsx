import React, { useState, useEffect } from 'react';
import { usePage, router } from '@inertiajs/react';
import Sidebar from './Sidebar';
import Header from './Header';

export default function AdminLayout({ children }) {
    const { props } = usePage();
    const { auth, notifications, conversations } = props;
    const user = auth?.user;
    
    // State های مربوط به UI (بدون تغییر)
    const [collapsed, setCollapsed] = useState(false);
    const [hovered, setHovered] = useState(false);
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

        // **افکت نهایی و کامل برای راه‌اندازی Echo**
    useEffect(() => {
        // این افکت فقط زمانی اجرا می‌شود که آبجکت user وجود داشته باشد
        if (user && window.Echo) {
            
            // --- ۱. راه‌اندازی کانال نوتیفیکیشن‌ها ---
            const userChannel = window.Echo.private(`App.Models.User.${user.id}`);
            
            // **استفاده از نام رویداد پیش‌فرض لاراول برای نوتیفیکیشن‌ها**
            userChannel.listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
                console.log("New Laravel Notification Received:", e);
                router.reload({ 
                    only: ['notifications', 'conversations'],
                    preserveState: true,
                    preserveScroll: true
                });
            });

            // --- ۲. راه‌اندازی کانال چت ادمین ---
            const adminChannel = window.Echo.private('admin-chat');
            adminChannel.listen('\\App\\Events\\MessageSentToAdmin', (e) => {
                console.log("New Chat Message Received:", e);
                router.reload({
                    only: ['notifications', 'conversations'],
                    preserveState: true,
                    preserveScroll: true
                });
            });

            // --- ۳. تابع پاک‌سازی (بسیار مهم) ---
            // این تابع زمانی اجرا می‌شود که کامپوننت unmount شود یا user تغییر کند.
            // این کار از ثبت listener های تکراری و memory leak جلوگیری می‌کند.
            return () => {
                userChannel.stopListening('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated');
                window.Echo.leaveChannel(`App.Models.User.${user.id}`);

                adminChannel.stopListening('\\App\\Events\\MessageSentToAdmin');
                window.Echo.leaveChannel('admin-chat');
            };
        }
    }, [user]); // وابستگی به user تضمین می‌کند که با تغییر کاربر، listener ها دوباره راه‌اندازی شوند.
    
   
    let wrapperClass = 'ecaps-page-wrapper';
    if (mobileMenuOpen) wrapperClass += ' mobile-menu-active';
    if (collapsed) wrapperClass += ' menu-collasped-active';
    if (collapsed && hovered) wrapperClass += ' sidemenu-hover-active';
    if (collapsed && !hovered) wrapperClass += ' sidemenu-hover-deactive';

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

    return (
        <div className={wrapperClass} style={{overflowX: 'hidden'}}>
            <Sidebar onMouseEnter={() => setHovered(true)} onMouseLeave={() => setHovered(false)}/>
            <div className="ecaps-page-content">
                {/* داده‌های زنده را به عنوان پراپ به هدر پاس می‌دهیم */}
                <Header 
                    onDesktopMenuToggle={handleDesktopMenuToggle}
                    onMobileMenuToggle={handleMobileMenuToggle}
                    notifications={notifications}
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