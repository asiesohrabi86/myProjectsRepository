@extends('layouts.master')
@section('content')
<main class="profile-user-page default">
    <div class="container">
        <div class="row">
            <div class="profile-page col-xl-9 col-lg-8 col-md-12 order-2">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <h1 class="title-tab-content"> کد فعالسازی</h1>
                        </div>
                        <div class="content-section default">
                            <form class="form-account" action="{{route('phone.verify')}}" method="post">
                                @csrf  
                                 
                                {{-- @if($errors->any())
                                @foreach ($errors->all() as $error)
                                <div>{{$error}}</div>
                                @endforeach
                                @endif --}}
                            
                                <div class="row">
                                    
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-account-title">کد فعالسازی</div>
                                        <div class="form-account-row">
                                            <input class="input-field @error('token') is-invalid @enderror" type="text" name="token">

                                            @error('token')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong style="color: red">{{$message}}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>   
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary btn-lg" type="submit">ثبت اطلاعات</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-1">
                <div class="profile-box">
                    <div class="profile-box-header">
                        <div class="profile-box-avatar">
                            <img src="/front/assets/img/svg/user.svg" alt="">
                        </div>
                        <button data-toggle="modal" data-target="#myModal" class="profile-box-btn-edit">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <!-- Modal Core -->
                        <div class="modal-share modal-width-custom modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">تغییر نمایه کاربری شما</h4>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="profile-avatars default text-center">
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/user.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-1.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-2.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-3.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-4.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-5.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-6.svg"></img>
                                            </li>
                                            <li>
                                                <img class="profile-avatars-item" src="/front/assets/img/svg/avatar-7.svg"></img>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Core -->
                    </div>
                   
            </div>
        </div>
    </div>
</main>
@endsection
