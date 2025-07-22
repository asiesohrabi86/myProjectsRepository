<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Title -->
    <title>پنل مدیریت-@yield('title','page-title')</title>

    <!-- Favicon -->
    <link rel="icon" href="/admin/img/core-img/favicon.png">

    <!-- These plugins only need for the run this page -->
    <link rel="stylesheet" href="/admin/css/default-assets/notification.css">

    <link rel="stylesheet" href="/admin/style.css">
    <script src="/admin/js/jquery.min.js"></script>
    <script src="{{asset('/js/app.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/vendor/file-manager/css/file-manager.css')}}">
    @yield('style')

</head>