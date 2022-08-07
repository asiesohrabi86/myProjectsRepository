@extends('dashboard.layouts.master')
@section('title','ایجاد محصول جدید')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">فرم ایجاد محصول جدید</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('products.store')}}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail111">نام محصول</label>
                                <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('title')}}" name="title">
                            </div>
                            <div class="form-group">
                                <label for="editor-id">متن محصول</label>
                                <textarea class="form-control" id="editor-id" name="text"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword11">قیمت محصول</label>
                                <input type="text" class="form-control" id="exampleInputPassword11" value="{{old('price')}}" name="price">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword12">موجودی محصول</label>
                                <input type="text" class="form-control" id="exampleInputPassword12" value="{{old('amount')}}" name="amount">
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ثبت محصول</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection