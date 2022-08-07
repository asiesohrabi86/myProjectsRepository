@extends('dashboard.layouts.master')
@section('title','ویرایش محصول')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ویرایش محصول</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('products.update',$product->id)}}" method="POST">
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
                                <label for="exampleInputEmail111"> نام محصول</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" name="title" value="{{old('title',$product->title)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail12">متن محصول</label>
                                <textarea class="form-control" id="exampleInputEmail12" name="text">{{old('text',$product->text)}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>دسته بندی محصول</label>
                                <select class="form-control" id="categories" name="categories[]" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{in_array($category->id,$product->categories()->pluck('id')->toArray()) ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword11">قیمت محصول</label>
                                <input type="text" class="form-control" id="exampleInputPassword11" name="price" value="{{old('price',$product->price)}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword12">موجودی محصول</label>
                                <input type="text" class="form-control" id="exampleInputPassword12" name="amount" value="{{old('amount',$product->amount)}}">
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ویرایش محصول</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection