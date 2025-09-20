@extends('dashboard.layouts.master')
@section('title','ایجاد ویژگی جدید')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ایجاد ویژگی جدید</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('attributes.store')}}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail111">نام ویژگی</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('name')}}" name="name">
                            </div>
                            
                            
                            <button type="submit" class="btn btn-primary mr-2">ثبت ویژگی</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection