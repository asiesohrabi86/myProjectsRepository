<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Title -->
    <title>@yield('title','page-title')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('admin/img/core-img/favicon.png')}}">

    <link rel="stylesheet" href="{{asset('admin/style.css')}}">
    <script src="{{asset('js/app.js')}}"></script>

</head>

<body class="login-area">

    <!-- Preloader -->
    <div id="preloader">
        <div id="ctn-preloader" class="ont-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
               <div class="txt-loading">
                    <span data-text-preloader="موتریلا" class="letters-loading">
                        موتریلا
                     </span>
                </div>
                <p class="text-center">درحال اجرا</p>
            </div>

            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader -->


    <!-- ======================================
    ******* Page Wrapper Area Start **********
    ======================================= -->
    <div class="main-content- h-100vh">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12">
                    <!-- Middle Box -->
                    <div class="middle-box">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================
    ********* Page Wrapper Area End ***********
    ======================================= -->

    <!-- Must needed plugins to the run this Template -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/popper.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    <!-- <script src="{{asset('admin/js/bundle.js')}}"></script> -->

    {{-- Google Recaptcha --}}
    @yield('script')
    @stack('script')

    <!-- Active JS -->
    <script src="{{asset('admin/js/default-assets/active.js')}}"></script>
    @include('sweet::alert')
</body>

</html>