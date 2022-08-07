@extends('layouts.app')
@section('title','ثبت نام در سایت')
@section('script')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="xs-d-none mb-50-xs break-320-576-none">
                    <img src="admin/img/bg-img/2.png" alt="">
                </div>
            </div>

            <div class="col-md-6">
                <h4 class="font-18 mb-30">ثبت نام</h4>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group">
                        <label for="name">نام و نام خانوادگی</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">پست الکترونیکی</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">تکرار رمز عبور</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    </div>

                    @recaptcha

                    <div class="form-group mb-0 mt-15">
                        <button class="btn btn-primary btn-block" type="submit">ثبت نام</button>
                    </div>

                    <div class="text-center mt-15"><span class="mr-2 font-13 font-weight-bold">قبلا ثبت نام کرده اید؟</span><a class="font-13 font-weight-bold" href="{{route('login')}}">ورود</a></div>

                </form>
            </div> <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
</div> 
@endsection  