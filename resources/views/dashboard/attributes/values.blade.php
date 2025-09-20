@extends('dashboard.layouts.master')
@section('title','افزودن مقدار برای ویژگی')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-6 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">افزودن مقدار برای ویژگی {{$attribute->name}}</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{route('attribute.post.values',$attribute->id)}}" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                {{-- اگر در روت پست، آیدی اتریبیوت را نفرستیم اینپوت زیر را درنظر میگیریم --}}
                                {{-- <input type="hidden" value="{{$attribute->id}}"> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail111">نام مقدار</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('value')}}" name="value">
                                </div>
                                
                                
                                <button type="submit" class="btn btn-primary mr-2">ثبت مقدار</button>
                                <button type="submit" class="btn btn-default">لغو</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">لیست مقادیر برای ویژگی {{$attribute->name}}</h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>آیدی مقدار</th>
                                    <th>نام مقدار</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($values as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->value}}</td>

                                    <td class="row">
                                        <form action="{{route('attribute.destroy.values',$value->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('آیا از حذف مقدار مطمئن هستید؟')" class="btn btn-danger btn-sm" style="margin-left: 5px">حذف</button>
                                        </form>
                                        <a href="{{route('attribute.edit.values',$value->id)}}" class="btn btn-primary btn-sm" style="margin-left: 5px">ویرایش</a> 
                                      
                                    </td>
                                </tr>  
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection