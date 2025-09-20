@extends('dashboard.layouts.master')
@section('title','همه ی نقش ها')
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-4 col-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ایجاد نقش جدید</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{route('roles.store')}}" method="POST">
                                @csrf
                                @if ($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputEmail111">نام نقش</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('name')}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail111">توضیح نقش</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('description')}}" name="description">
                                </div>
                                <div class="form-group">
                                    <label for="permissions">انتخاب مجوز</label>
                                    <select name="permissions[]" id="permissions" class="form-control select2" multiple>
                                        @foreach ($permissions as $permission)
                                           <option value="{{$permission->id}}">{{$permission->name}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mr-2">ثبت نقش</button>
                                <button type="submit" class="btn btn-default">لغو</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">لیست نقش ها</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">نام نقش</th>
                                        <th class="text-nowrap">توضیح</th>
                                        <th>مجوزها</th>
                                        <th class="text-nowrap">عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-nowrap">{{$role->name}}</td>
                                        <td class="text-nowrap">{{$role->description}}</td>
                                        <td style="max-width: 450px; min-width: 300px;">
                                            <ul class="list-unstyled mb-0" style="max-height: 120px; overflow-y: auto;">
                                                @foreach ($role->permissions as $permission)
                                                    <li style="white-space: normal;">{{$permission->description}}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="d-flex text-nowrap">
                                            <form action="{{route('roles.destroy',$role->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('آیا از حذف نقش مطمئن هستید؟')" class="btn btn-danger btn-sm" style="margin-left: 5px">حذف</button>
                                            </form>
                                            <a href="{{route('roles.edit',$role->id)}}" class="btn btn-primary btn-sm" style="margin-left: 5px">ویرایش</a> 
                                        
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    <style>
        .select2-container--bootstrap4 .select2-selection--multiple {
            max-height: 90px !important;
            overflow-y: auto !important;
            min-height: 38px;
            padding-bottom: 2px;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        });
    </script>
@endsection