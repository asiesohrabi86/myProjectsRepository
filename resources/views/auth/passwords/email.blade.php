@extends('layouts.app')
@section('title','تغییر رمز عبور')
@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="xs-d-none mb-50-xs break-320-576-none">
                    <img src="/admin/img/bg-img/1.png" alt="">
                </div>
            </div>

            <div class="col-md-6">
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                @endif
                <h4 class="font-18 mb-30">فراموشی رمز عبور؟</h4>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group">
                        <label class="lock-text text-dark">ایمیل یا شماره تماس</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @recaptcha

                    <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block" type="submit">ارسال رمز عبور</button>
                    </div>
                    <p class="text-center mt-20">لورم ایپسوم متن ساختگی با تولید سادگی </p>
                    <div class="row mt-15">
                        <div class="col-12">
                            <p class="text-center text-dark font-weight-bold">ورود با</p>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-googleplus waves-effect waves-light mb-2 btn-block"><i class="fa fa-google mr-2"></i><span class="text-center">گوگل</span></a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-facebook waves-effect waves-light mb-2 btn-block"><i class="fa fa-facebook mr-2"></i><span class="text-center">فیسبوک</span></a>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
</div>
@endsection
