@extends('layouts.app')
@section('title','ثبت نام در سایت')
@section('script')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route("register") }}"]');
    const inputs = form.querySelectorAll('input');

    function validateInput(input) {
        let pattern = null;
        switch(input.name) {
            case 'name':
                pattern = /^[\u0600-\u06FFa-zA-Z\s]{3,}$/;
                break;
            case 'email':
                pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                break;
            case 'password':
                pattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
                break;
            case 'password_confirmation':
                // Special case: check equality with password
                const password = form.querySelector('input[name="password"]').value;
                if(input.value !== password || !password) {
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
                        <span class="invalid-feedback d-none">نام و نام خانوادگی باید حداقل ۳ حرف باشد و فقط شامل حروف فارسی یا لاتین باشد.</span>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">پست الکترونیکی</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <span class="invalid-feedback d-none">ایمیل وارد شده معتبر نیست.</span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <span class="invalid-feedback d-none">رمز عبور باید حداقل ۸ کاراکتر و شامل حروف و عدد باشد.</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">تکرار رمز عبور</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <span class="invalid-feedback d-none">تکرار رمز عبور با رمز عبور مطابقت ندارد.</span>
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