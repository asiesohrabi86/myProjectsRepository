@extends('layouts.profile-master')
@section('title','احراز هویت دومرحله ای')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <h1 class="title-tab-content">احراز هویت دومرحله ای</h1>
            </div>
            <div class="content-section default">
                <form class="form-account" action="{{route('ins.twofactorauth')}}" method="post">
                    @csrf  
                    @if ($errors->any())
                    <div class="col-md-12">
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li> 
                                @endforeach
                            </ul>
                    </div>
                        @endif 
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-account-title">وضعیت</div>
                            <div class="form-account-row">
                                <select class="input-field" name="type" id="2factor">
                                    @foreach (config('twofactor.types') as $key=>$name)
                                        <option value="{{$key}}" {{old('type')==$key || auth()->user()->two_factor_type==$key ? 'selected' : '' }}>{{$name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-account-title">شماره موبایل</div>
                            <div class="form-account-row">
                                <input class="input-field" value="{{old('phone_number') ?? auth()->user()->phone_number}}" type="text" name='phone_number' placeholder="شماره موبایل خود را وارد نمایید">
                                
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
            
@endsection