@extends('dashboard.layouts.master')
@section('title','ایجاد دسترسی برای کاربر')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="col-xl-6 box-margin height-card">
            <div class="card card-body">
                <h4 class="card-title">ایجاد دسترسی برای کاربر
                    {{$user->name}}
                </h4>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <form action="{{route('users.role.update',$user->id)}}" method="POST">
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
                                <label for="">نقش ها</label>
                                <select name="roles[]" id="" multiple class="form-control">
                                    @foreach ($roles as $role)
                                       <option value="{{$role->id}}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{$role->name}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">مجوز ها</label>
                                <select name="permissions[]" id="" multiple class="form-control">
                                    @foreach ($permissions as $permission)
                                       <option value="{{$permission->id}}" {{ $user->permissions->contains($permission->id) ? 'selected' : '' }}>{{$permission->name}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mr-2">ایجاد دسترسی</button>
                            <button type="submit" class="btn btn-default">لغو</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection