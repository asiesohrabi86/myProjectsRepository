@extends('layouts.app')
@section('content')
<div class="col-lg-10 offset-lg-1">
  <div class="box">
    <center>
      <br>
      <img src="{{$user->image}}" width="120px" height="120px">
      <hr>
      <p>{{$user->description}}</p>
      <a href="#" class="btn btn-success" >ثبت نام</a>
  </center>
  </div>
</div>

@endsection