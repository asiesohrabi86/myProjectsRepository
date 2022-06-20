@extends('layouts.app')

@section('content')
   
    @include('layouts.slider')

    <div class="col-lg-12 content">
        <br>
       <div class="col-lg-12 boxterm"> 
          <div class="col-lg-12 banner">
            <p> لیست دوره های برتر</p>
          </div>

          <div class="row">
            @foreach ($courses as $course)
            <div class="col-lg-3 ">
              <div class="box">
                <center>
                  <br>
                  <img src="{{$course->image}}" width="120px" height="120px" style="border-radius: 10px">
                  <hr>
                  <p>{!!$course->description!!}</p>
                  <a href="single-course/{{$course->id}}" class="btn btn-success" >مشاهده</a>
              </center>
              </div>
            </div>
            @endforeach
          </div>
       </div>
       <div class="col-lg-12 boxmaster">
        <div class="col-lg-12 banner">
          <p> لیست اساتید برتر</p>
        </div>
        <div class="row">
          @foreach ($masters as $master)
          <div class="col-lg-3 ">
            <div class="box">
              <center>
                <br>
                <img src="{{$master->image}}" width="120px" height="120px" style="border-radius: 10px">
                <hr>
                <p>{{$master->name}}</p>
                <p>{{$master->field}}</p>
                <a class="btn btn-success" href="single-master/{{$master->id}}">مشاهده</a>
            </center>
            </div>
          </div>  
          @endforeach
        
        </div>
         
       </div>
       <div class="col-lg-12 boxstudent">
        <div class="col-lg-12 banner">
          <p> لیست دانشجویان برتر</p>
        </div>
        <div class="row">
          @foreach ($users as $user)
          <div class="col-lg-3 ">
            <div class="box">
              <center>
                <br>
                <img src="images/user5.jpg" width="120px" height="120px" style="border-radius: 10px">
                <hr>
                <p>{{$user->name}}</p>
                <a href="single-user/{{$user->id}}" class="btn btn-success">مشاهده</a>
            </center>
            </div>
          </div>  
          @endforeach


        </div>
      </div>
    </div>

@endsection