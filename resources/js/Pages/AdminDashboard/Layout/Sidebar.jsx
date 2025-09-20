import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

// کامپوننت فرزند حالا "گنگ" (Dumb) است و state را از والد می‌گیرد
const MenuItem = ({ item, openMenu, setOpenMenu }) => {
    const { url } = usePage();

    // بررسی اینکه آیا آیتم فعال است
    const isActive = (activeRoutes) => {
        if (!activeRoutes) return false;
        const routes = Array.isArray(activeRoutes) ? activeRoutes : [activeRoutes];
        return routes.some(routeName => route().current(routeName));
    };

    // بررسی اینکه آیا این زیرمنو در حال حاضر باز است
    const isOpen = openMenu === item.title;

    // اگر آیتم فرزند داشت
    if (item.children) {
        // بررسی اینکه آیا یکی از فرزندان فعال است تا والد هم active شود
        const isChildActive = item.children.some(child => isActive(child.active));
        
        return (
            <li className={`treeview ${isOpen || isChildActive ? 'active' : ''}`}>
                <a href="#" onClick={(e) => {
                    e.preventDefault();
                    // اگر این منو باز بود، آن را ببند. در غیر اینصورت، آن را باز کن.
                    setOpenMenu(isOpen ? null : item.title);
                }}>
                    <i className={item.icon}></i>
                    <span>{item.title}</span>
                    <i 
                        className="fa fa-angle-left" 
                        style={{ 
                            transform: isOpen ? 'rotate(-90deg)' : 'rotate(0deg)',
                            transition: 'transform 0.3s ease' ,
                            transformOrigin: 'center'
                        }}
                    ></i>
                </a>
                <ul className="treeview-menu" style={{ display: isOpen || isChildActive ? 'block' : 'none' }}>
                    {item.children.map((child, index) => (
                        <MenuItem key={index} item={child} openMenu={openMenu} setOpenMenu={setOpenMenu} />
                    ))}
                </ul>
            </li>
        );
    }

    // اگر آیتم تکی بود
    return (
        <li className={isActive(item.active) ? 'active' : ''}>
            <a href={item.url}>
                {item.icon && <i className={item.icon}></i>}
                <span>{item.title}</span>
            </a>
        </li>
    );
};


const Sidebar = ({ onMouseEnter, onMouseLeave }) => {
    const { sidebarMenu = [] } = usePage().props;
    
    // State برای مدیریت منوی باز در سطح والد
    const [openMenu, setOpenMenu] = useState(null);

    // بررسی می‌کنیم که آیا در بارگذاری اولیه صفحه، باید زیرمنویی باز باشد یا نه
    useEffect(() => {
        const activeParent = sidebarMenu.find(item => 
            item.children && item.children.some(child => route().current(child.active))
        );
        if (activeParent) {
            setOpenMenu(activeParent.title);
        }
    }, [usePage().url]); // این افکت با هر تغییر URL دوباره اجرا می‌شود


    return (
        <div className="ecaps-sidemenu-area" onMouseEnter={onMouseEnter} onMouseLeave={onMouseLeave}>
            <div className="ecaps-logo">
                <Link href={route('dashboard.index')}>
                    <img className="desktop-logo" src="/admin/img/core-img/logo.png" alt="لوگوی دسک تاپ" />
                    <img className="small-logo" src="/admin/img/core-img/small-logo.png" alt="آرم موبایل" />
                </Link>
            </div>

            <div className="slimScrollDiv" style={{ position: 'relative', overflow: 'hidden', width: 'auto', height: '100%' }}>
                <div className="ecaps-sidenav" id="ecapsSideNav" style={{ overflow: 'hidden', width: 'auto', height: '100%' }}>
                    <div className="side-menu-area">
                        <nav>
                            <ul className="sidebar-menu">
                                {sidebarMenu.map((item, index) => (
                                    <MenuItem key={index} item={item} openMenu={openMenu} setOpenMenu={setOpenMenu} />
                                ))}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Sidebar;