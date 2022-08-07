@extends('dashboard.layouts.master')
@section('title','ویرایش کاربر')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ویرایش کاربر</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('users.update',$user->id)}}" method="POST">
                            @csrf
                            @method('patch')
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail111">نام</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" name="name" placeholder="نام" value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail12">آدرس ایمیل</label>
                                <input type="email" class="form-control" id="exampleInputEmail12" name="email" placeholder="ایمیل" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword11">کلمه عبور</label>
                                <input type="password" class="form-control" id="exampleInputPassword11" name="password" placeholder="رمز عبور">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword12">تکرار کلمه عبور</label>
                                <input type="password" class="form-control" id="exampleInputPassword12" name="password_confirmation" placeholder="تکرار رمز عبور">
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ویرایش کاربر</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection