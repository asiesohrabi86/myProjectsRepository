<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{asset('css/bootstrap-rtl.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet">
</head>
<body>
    <div id="app">
       @include('layouts.navbar')

        <main>
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/all.min.js')}}"></script>
   
</html>
