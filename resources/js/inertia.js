// resources/js/inertia.js

/**
 * ابتدا، تمام وابستگی‌های جاوااسکریپت مشترک مانند axios و Echo را
 * از طریق فایل bootstrap.js وارد می‌کنیم.
 */
import './bootstrap';

/**
 * در ادامه، اپلیکیشن اینرشیا/ری‌اکت را برای پنل ادمین راه‌اندازی می‌کنیم.
 */
import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`), // مطمئن شوید مسیر Pages صحیح است
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
});