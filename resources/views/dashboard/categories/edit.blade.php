@extends('dashboard.layouts.master')
@section('title','ایجاد دسته بندی جدید')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ویرایش دسته بندی</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('categories.update', $category->id)}}" method="POST">
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
                                <label for="exampleInputEmail111">نام دسته بندی</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('name', $category->name)}}" name="name">
                            </div>
                            <div class="form-group">
                                <label for="parent_id">دسته پدر</label>
                                <select name="parent_id" id="parent_id">
                                    <option value="{{old('name', $category->parent_id)}}">ندارد</option>
                                    @foreach ($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{$parent->id === $category->parent_id ? 'selected' : ''}}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ثبت دسته بندی</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection