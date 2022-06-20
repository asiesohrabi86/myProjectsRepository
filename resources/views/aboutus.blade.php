@extends('layouts.app')

@section('content')

   <div class="col-lg-12 content">
      <br>
        <div class=" offset-lg-3 col-lg-6 offset-lg-3 banner">
                <p>تاریخچه</p>
        </div>
        <br>
        <div class=" offset-lg-3 col-lg-6 offset-lg-3 history">
            <p>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
              </p>
        </div>
        <div class=" offset-lg-3 col-lg-6 offset-lg-3 banner">
            <p>حوزه های فعالیت</p>
        </div>
         <div class=" offset-lg-3 col-lg-6 offset-lg-3 feilds ">
            <img src="images/aboutus.png" height="300px" class="d-block w-100" >
            <ul class="text-center mt-2">
                @foreach (App\Models\Course::all() as $course)
                    <li class="dropdown-item">
                        <a href="{{route('singlecourse',$course->id)}}"><h5>دوره ی {{$course->course}}</h5></a>
                    </li> 
                    
                @endforeach
                
            </ul>
            
         </div>
      
  </div>   
  @endsection 
