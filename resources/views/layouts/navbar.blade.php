<div class="col-lg-12 top">
    <div class="row">  
      <div class="col-lg-4 logo">
          <img src="{{asset('images/logo.png')}}" width="60px" height="60px">
          <span> آموزشگاه مجازی</span>
       </div>
       <div class="col-lg-4 date">
           <p>{{\Morilog\Jalali\Jalalian::now()->format('%A, %d %B %y, H:i:s')}} </p>
           {{-- <p>{{jdate()->format('%A, %d %B %y')}}</p> --}}

        </div>
         <div class="col-lg-4 search"> 
             
                <form action="{{route('search')}}" method="get">

                    <input type="text" class="col-lg-6" placeholder="جستجو کنید" name="search" value="{{request('search')}}">
                    <button type="submit" class="btn btn-info col-lg-2">جستجو</button>
                </form>
             
          
          </div>
     </div>
  </div>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="/">صفحه ی اصلی <span class="sr-only">(current)</span></a>
                  </li>
                  
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     لیست دوره ها
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach (App\Models\Course::all() as $course)
                            <a class="dropdown-item" href="{{route('singlecourse',$course->id)}}">{{$course->course}}</a>
                        @endforeach
                      
                    </div>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{'/calendar'}}" >تقویم آموزشی</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{'/aboutus'}}">درباره ی ما</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{'/contactus'}}">تماس با ما</a>
                    </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ورود') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('ثبت نام') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdown">

                            @if (Auth::user()->superuser())
                            <a href="{{route('panel')}}" class="dropdown-item">پنل مدیریت</a>
                            @endif
                        
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('خروج') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>