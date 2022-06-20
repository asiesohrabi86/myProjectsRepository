@extends('layouts.app')
@section('content')
<div class="col-lg-10 offset-lg-1">
  <div class="box">
    <center>
      <br>
      <img src="{{$master->image}}" width="120px" height="120px" style="border-radius: 10px">
      <p>{{$master->name}}</p>
      <hr>
      <p>{{$master->antecedent}}</p>
      <p>{{$master->field}}</p>
      
  </center>
  </div>
</div>

@endsection