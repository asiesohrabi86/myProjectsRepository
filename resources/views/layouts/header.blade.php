<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="front/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="front/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <title>لاراول لرن-@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     @routes
    {!! SEO::generate(true) !!}
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="/front/assets/fonts/font-awesome/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="/front/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/front/assets/css/now-ui-kit.css" rel="stylesheet" />
    <link href="/front/assets/css/plugins/owl.carousel.css" rel="stylesheet" />
    <link href="/front/assets/css/plugins/owl.theme.default.min.css" rel="stylesheet" />
    <link href="/front/assets/css/main.css" rel="stylesheet" />
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
</head>