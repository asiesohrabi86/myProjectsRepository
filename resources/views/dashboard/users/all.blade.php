@extends('dashboard.layouts.master')
@section('title','مدیریت کاربران')
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
                                    <h4 class="card-title mb-2">لیست کاربران</h4>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{route('users.create')}}" class="btn btn-success offset-lg-9 mb-1">افزودن کاربر</a>
                                    
                                </div>
                                
                            </div>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>ایمیل</th>
                                        <th>وضعیت ایمیل</th>
                                        <th>نقش کاربری</th>
                                        <th>شماره تماس</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if ($user->email_verified_at)
                                                <span class="badge badge-success">فعال</span>
                                            @else
                                                <span class="badge badge-danger">غیرفعال</span>
                                            @endif
                                        </td>
                                        <td>
                                           @if ($user->is_admin)
                                               <span>مدیر</span>
                                           @elseif($user->is_operator) 
                                                <span>اپراتور</span>
                                            @else
                                            <span>کاربر عادی</span>
                                            @endif
                                        </td>

                                        <td>{{$user->phone_number}}</td>

                                        <td class="row">
                                          <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm">ویرایش</a> 
                                          
                                          <form action="{{route('users.destroy',$user->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('آیا از حذف کاربر مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
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