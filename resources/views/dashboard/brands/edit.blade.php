@extends('dashboard.layouts.master')
@section('title','ایجاد دسته بندی جدید')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ویرایش برند</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('brands.update',$brand->id)}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail111">نام برند</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('name', $brand->name)}}" name="name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword12">تصویر برند</label>
                                <input type="file" class="form-control" id="exampleInputPassword12" name="image">
                                @if($brand->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" style="max-width: 200px; max-height: 200px; border:1px solid #ccc; padding:5px;">
                                    </div>
                                @endif
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ویرایش برند</button>
                            <button type="" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection