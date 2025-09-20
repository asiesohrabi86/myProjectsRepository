@extends('layouts.app')
@section('title','ورود به سیستم')
@section('script')
<script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{route('login')}}"]');
    const inputs = form.querySelectorAll('input[type="email"], input[type="password"]');

    function validateInput(input) {
        let pattern = null;
        switch(input.name) {
            case 'email':
                pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                break;
            case 'password':
                pattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
                break;
            default:
                pattern = /.*/;
        }
        if(pattern && !pattern.test(input.value)) {
            input.nextElementSibling.classList.remove('d-none');
            input.nextElementSibling.classList.add('d-block');
            input.classList.add('is-invalid');
            return false;
        } else {
            input.nextElementSibling.classList.remove('d-block');
            input.nextElementSibling.classList.add('d-none');
            input.classList.remove('is-invalid');
            return true;
        }
    }

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            validateInput(input);
        });
    });

    form.addEventListener('submit', function(e) {
        let valid = true;
        inputs.forEach(function(input) {
            if(!validateInput(input)) {
                valid = false;
            }
        });
        if(!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
@section('content')

<div class="card">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="xs-d-none mb-50-xs break-320-576-none">
                    <img src="admin/img/bg-img/1.png" alt="">
                </div>
            </div>

            <div class="col-md-6">
                <!-- Logo -->
                <h4 class="font-18 mb-30">ورود به پنل کاربری</h4>

                <form action="{{route('login')}}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="form-group">
                        <label class="float-left" for="emailaddress">پست الکترونیکی</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <span class="invalid-feedback d-none">ایمیل وارد شده معتبر نیست.</span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                         @enderror
                    </div>

                    <div class="form-group">
                        <a href="forget-password.html" class="text-dark float-right"></a>
                        <label class="float-left" for="password">رمز عبور</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <span class="invalid-feedback d-none">رمز عبور باید حداقل ۸ کاراکتر و شامل حروف و عدد باشد.</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @recaptcha

                    <div class="form-group d-flex justify-content-between align-items-center mb-3">
                        <div class="checkbox d-inline mb-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="checkbox-8" class="cr mb-0">مرا به خاطر بسپار</label>
                        </div>

                        @if (Route::has('password.request'))
                        <span class="font-13 text-primary"><a href="{{ route('password.request') }}">رمز عبور خود را فراموش کرده اید؟</a></span>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block" type="submit">ورود </button>
                    </div>

                    <div class="row mt-20">
                        <div class="col-6">
                            <a href="{{route('auth.google')}}" class="btn btn-googleplus waves-effect waves-light mb-2 btn-block"><i class="fa fa-google mr-2"></i><span class="text-center">google</span></a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-facebook waves-effect waves-light mb-2 btn-block"><i class="fa fa-facebook mr-2"></i><span class="text-center">facebook</span></a>
                        </div>
                    </div>

                    @if (Route::has('register'))
                        <div class="text-center mt-15"><span class="mr-2 font-13 font-weight-bold">اگر ثبت نام نکرده اید؟ </span><a class="font-13 font-weight-bold" href="{{route('register')}}">ثبت نا م کنید</a></div> 
                    @endif

                </form>
            </div> <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
</div>
@endsection