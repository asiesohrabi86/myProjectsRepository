@extends('layouts.profile-master')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <h1 class="title-tab-content"> کد فعالسازی</h1>
            </div>
            <div class="content-section default">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div style="color:red;text-align:center;">{{$error}}</div>
                    @endforeach
                @endif
                @if(session('status'))
                    <div class="alert alert-success text-center">{{ session('status') }}</div>
                @endif
                <form class="form-account" action="{{route('auth.token')}}" method="post">
                    @csrf  
                        
                    {{-- @if($errors->any())
                    @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                    @endforeach
                    @endif --}}
                
                    <div class="row">
                        
                        <div class="col-sm-12 col-md-6">
                            <div class="form-account-title">کد تاییدیه</div>
                            <div class="form-account-row">
                                <input class="input-field @error('token') is-invalid @enderror" type="text" name="token">

                                @error('token')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{$message}}</strong>
                                    </span>
                                @enderror
                                @if(session('show_resend'))
                                    <div class="mt-2">
                                        <a href="{{ route('resend.activation.code') }}" class="btn btn-link">دریافت مجدد کد تاییدیه</a>
                                    </div>
                                @endif
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
