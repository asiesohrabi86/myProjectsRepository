<!doctype html>
<html lang="en">

@include('dashboard.layouts.header')

<body>
    <!-- Preloader -->
  @include('dashboard.layouts.preloader')


    <!-- ======================================
    ******* Page Wrapper Area Start **********
    ======================================= -->
    <div class="ecaps-page-wrapper">
        @include('dashboard.layouts.sidebar')

        <!-- Page Content -->
        <div class="ecaps-page-content">
          @include('dashboard.layouts.topnav')

            @yield('content')
        </div>
    </div>

    <!-- ======================================
    ********* Page Wrapper Area End ***********
    ======================================= -->

    @include('dashboard.layouts.footer')
    @include('vendor.roksta.toastr')
</body>
</html>
