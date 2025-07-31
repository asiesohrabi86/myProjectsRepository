// webpack.mix.js

const mix = require('laravel-mix');
const path = require('path');

// ۱. فایل JS برای صفحات Blade قدیمی سایت شما (شامل bootstrap.js)
mix.js('resources/js/app.js', 'public/js/app.js');
// فایل ورودی برای پنل ادمین Inertia
mix.js('resources/js/inertia.js', 'public/js/inertia.js').react();

// فایل ورودی برای ویجت چت سایت اصلی
mix.js('resources/js/chat.js', 'public/js/chat.js').react();

// CSS های شما (بدون تغییر)
mix.postCss('resources/css/app.css', 'public/css', [
    //
]);

// تنظیمات دیگر (بدون تغییر)
mix.sourceMaps();
if (mix.inProduction()) {
    mix.version();
}
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        }
    }
});