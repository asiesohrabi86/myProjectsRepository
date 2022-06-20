@extends('layouts.app')
@section('content')
<div class="col-lg-10 offset-lg-1 mb-2">
  <div class="col-lg-12 bg-info mt-3 p-3 text-center" style="border-radius: 5px"> 
    <h3> دوره {{$course->course}}</h3>
  </div>
  <div class="bg-light mt-2 shadow" style="border-radius: 10px;">
    <center>
      <br>
      <img src="{{$course->image}}" width="120px" height="120px" style="border-radius: 10px">
      <hr>
      <p>{!!$course->description!!}</p>
      <a href="#" class="btn btn-success mb-2" >ثبت نام</a>
  </center>
  </div>
</div>

@endsection