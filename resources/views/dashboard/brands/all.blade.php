@extends('dashboard.layouts.master')
@section('title','مدیریت برند')
@section('content')
<div class="main-content">
    <div class="data-table-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 box-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title mb-2">لیست برندها</h4>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <a href="{{route('brands.create')}}" class="btn btn-success mb-1">افزودن برند جدید</a>
                                    
                                </div>
                                <div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group"> <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" type="button"><span>کپی</span></button> <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="datatable-buttons" type="button"><span>پرینت</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="datatable-buttons_filter" class="dataTables_filter"><label>جستجو:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="datatable-buttons"></label></div></div></div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped dt-responsive text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-nowrap">آیدی برند</th>
                                            <th class="text-nowrap">نام برند</th>
                                            <th class="text-nowrap">عکس برند</th>
                                            <th class="text-nowrap">عملیات</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($brands as $brand)
                                        <tr>
                                            <td class="align-middle text-nowrap">{{$brand->id}}</td>
                                            <td class="align-middle text-nowrap">{{$brand->name}}</td>
                                            <td class="align-middle text-nowrap">
                                                <img src="{{asset($brand->image)}}" alt="{{$brand->name}}" style="width: 100px; height: 100px;">
                                            </td>

                                            <td class="align-middle text-nowrap">
                                                <a href="{{route('brands.edit',$brand->id)}}" class="btn btn-success">ویرایش</a> 
                                            <form action="{{route('brands.destroy',$brand->id)}}" class="d-inline" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('آیا از حذف برند مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                            </td>
                                        </tr>  
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

 
        </div>
    </div>
</div>
@endsection