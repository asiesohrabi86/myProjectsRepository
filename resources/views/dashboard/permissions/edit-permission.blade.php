@extends('dashboard.layouts.master')
@section('title','ویرایش دسترسی')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-4 col-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ویرایش دسترسی</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{route('permissions.update',$permission->id)}}" method="POST">
                                @csrf
                                @method('put')
                                @if ($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputEmail111">نام دسترسی</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{$permission->name}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail111">توضیح دسترسی</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{$permission->description}}" name="description">
                                </div>
                                
                                <button type="submit" class="btn btn-primary mr-2">ویرایش دسترسی</button>
                                <button type="submit" class="btn btn-default">لغو</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection