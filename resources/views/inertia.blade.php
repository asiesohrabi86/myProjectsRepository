<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- فقط فایل CSS کامپایل شده اصلی شما --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    
    {{-- شما می‌توانید استایل‌های عمومی قالب ادمین را اینجا هم اضافه کنید --}}
    <link href="/front/assets/css/bootstrap.min.css" rel="stylesheet" />
     <link href="/admin/css/animate.css" rel="stylesheet" />
     <link rel="stylesheet" href="/front/assets/fonts/font-awesome/css/font-awesome.min.css" />
     <!-- <link href="/front/assets/css/now-ui-kit.css" rel="stylesheet" /> -->
    <link href="/front/assets/css/plugins/owl.carousel.css" rel="stylesheet" />
    <link href="/front/assets/css/plugins/owl.theme.default.min.css" rel="stylesheet" />
    <!-- <link href="/front/assets/css/main.css" rel="stylesheet" /> -->
    
     <link rel="stylesheet" href="/admin/css/default-assets/notification.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="custom-fix.css">

    {{-- آیکون‌ها --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/material-design-iconic-font@2.2.0/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    @routes

    {{-- فراخوانی فایل JS صحیح برای اینرشیا --}}
    <script src="{{ mix('js/inertia.js') }}" defer></script>
    
    @inertiaHead
</head>
<body>
    @inertia
    <script src="/admin/js/jquery.min.js"></script>
    <script src="/admin/js/popper.min.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
</body>
</html>