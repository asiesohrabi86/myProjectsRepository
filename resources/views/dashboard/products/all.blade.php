@extends('dashboard.layouts.master')
@section('title','مدیریت محصولات')
@section('content')
<div class="main-content">
    <div class="data-table-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 box-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title mb-2">لیست محصولات</h4>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{route('products.create')}}" class="btn btn-success offset-lg-9 mb-1">افزودن محصول</a>
                                    
                                </div>
                                <div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group"> <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" type="button"><span>کپی</span></button> <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="datatable-buttons" type="button"><span>پرینت</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="datatable-buttons_filter" class="dataTables_filter"><label>جستجو:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="datatable-buttons"></label></div></div></div>
                            </div>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>آیدی محصول</th>
                                        <th>نام محصول</th>
                                        <th>توضیحات</th>
                                        <th>قیمت محصول</th>
                                        <th>موجودی</th>
                                        <th>تعداد بازدید</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->title}}</td>
                                        <td>{!!$product->text!!}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->amount}}</td> 
                                        <td>{{$product->view}}</td>

                                        <td class="row">
                                          <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary btn-sm">ویرایش</a> 
                                          
                                          <form action="{{route('products.destroy',$product->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('آیا از حذف محصول مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
                                            </form>
                                        </td>
                                    </tr>  
                                    @endforeach
                                    
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

 
        </div>
    </div>
</div>
@endsection