<!DOCTYPE html>
<html lang="fa">

@include('layouts.header')

<body class="index-page sidebar-collapse">

    <!-- responsive-header -->
    @include('layouts.navbar')
    <!-- responsive-header -->

    <div class="wrapper default">

        <!-- header -->
        @include('layouts.main-header')
        <!-- header -->


        
           
           @yield('content') 
        


       @include('layouts.footer')

    </div>
    @include('sweet::alert')
    @yield('script')

    @auth
        {{-- ویجت چت را فقط برای کاربرانی نمایش بده که ادمین نیستند --}}
        @if(!auth()->user()->isAdmin())
            <div id="chat-widget-container" 
                data-user-id="{{ auth()->id() }}">
                {{-- data-is-admin دیگر لازم نیست --}}
            </div>
            <script src="{{ mix('js/chat.js') }}"></script>
        @endif
    @endauth
   
</body>

</html>