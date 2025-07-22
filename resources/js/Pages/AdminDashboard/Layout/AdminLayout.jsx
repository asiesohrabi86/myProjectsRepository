import React, { useState, useEffect } from 'react';
import Sidebar from './Sidebar';
import Header from './Header';

const AdminLayout = ({ children }) => {
  const [collapsed, setCollapsed] = useState(false); // برای باریک/پهن بودن سایدبار
  const [hovered, setHovered] = useState(false);    // برای هاور روی سایدبار
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false); // برای موبایل

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
    <div className={wrapperClass}>
      <Sidebar
        onMouseEnter={() => setHovered(true)}
        onMouseLeave={() => setHovered(false)}
      />
      <div className="ecaps-page-content">
        <Header
          onDesktopMenuToggle={handleDesktopMenuToggle}
          onMobileMenuToggle={handleMobileMenuToggle}
        />
        <main className="main-content">
          <div className="dashboard-area">
            <div className="container-fluid">
              {children}
            </div>
          </div>
        </main>
      </div>
    </div>
  );
};

export default AdminLayout; 