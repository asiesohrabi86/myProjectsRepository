@extends('dashboard.layouts.master')
@section('title','ویرایش نقش')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-4 col-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ویرایش نقش</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{route('roles.update',$role->id)}}" method="POST">
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
                                    <label for="exampleInputEmail111">نام نقش</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{$role->name}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail111">توضیح نقش</label>
                                    <input type="text" class="form-control" id="exampleInputEmail111" value="{{$role->description}}" name="description">
                                </div>
                                <div class="form-group">
                                    <label for="permissions">مجوزها</label>
                                    <select name="permissions[]" id="permissions" class="form-control select2" multiple>
                                        @foreach ($permissions as $permission)
                                           <option value="{{$permission->id}}" {{$role->permissions->contains('id',$permission->id) ? 'selected' : ''}}>{{$permission->name}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">ویرایش نقش</button>
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