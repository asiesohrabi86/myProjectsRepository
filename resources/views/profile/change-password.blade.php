<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('front/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('front/assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <title>Topkala | تغییر رمز عبور</title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="{{ asset('front/assets/fonts/font-awesome/css/font-awesome.min.css') }}" />
    <!-- CSS Files -->
    <link href="{{ asset('front/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/assets/css/now-ui-kit.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/assets/css/plugins/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/assets/css/plugins/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="wrapper default">
    <div class="container">
            <div class="row">
                <div class="main-content col-12 col-md-7 col-lg-5 mx-auto">
                    <div class="account-box">
                        <a href="#" class="logo">
                            <img src="{{ asset('front/assets/img/logo.png') }}" alt="">
                        </a>
                        <div class="account-box-title">تغییر رمز عبور</div>
                        <div class="account-box-content">
                            <form class="form-account" method="POST" action="{{ route('profile.change-password') }}">
                        @csrf
                                <div class="form-account-title">رمز عبور قبلی</div>
                                <div class="form-account-row">
                                    <label class="input-label"><i class="now-ui-icons ui-1_lock-circle-open"></i></label>
                                    <input class="input-field" type="password" name="current_password" placeholder="رمز عبور قبلی خود را وارد نمایید" required>
                                    <span class="invalid-feedback d-none">رمز عبور قبلی را وارد کنید.</span>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                                <div class="form-account-title">رمز عبور جدید</div>
                                <div class="form-account-row">
                                    <label class="input-label"><i class="now-ui-icons ui-1_lock-circle-open"></i></label>
                                    <input class="input-field" type="password" name="password" placeholder="رمز عبور جدید خود را وارد نمایید" required>
                                    <span class="invalid-feedback d-none">رمز عبور باید حداقل ۸ کاراکتر و شامل حروف و عدد باشد.</span>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                                <div class="form-account-title">تکرار رمز عبور جدید</div>
                                <div class="form-account-row">
                                    <label class="input-label"><i class="now-ui-icons ui-1_lock-circle-open"></i></label>
                                    <input class="input-field" type="password" name="password_confirmation" placeholder="رمز عبور جدید خود را مجددا وارد نمایید" required>
                                    <span class="invalid-feedback d-none">تکرار رمز عبور با رمز عبور جدید مطابقت ندارد.</span>
                                </div>
                                <div class="form-account-row form-account-submit">
                                    <div class="parent-btn">
                                        <button type="submit" class="dk-btn dk-btn-info">
                                            تغییر رمز عبور
                                            <i class="now-ui-icons arrows-1_refresh-69"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <footer class="mini-footer">
            <nav>
                <div class="container">
                    <ul class="menu">
                        <li><a href="#">درباره تاپ کالا</a></li>
                        <li><a href="#">فرصت‌های شغلی</a></li>
                        <li><a href="#">تماس با ما</a></li>
                        <li><a href="#">همکاری با سازمان‌ها</a></li>
                    </ul>
                </div>
            </nav>
            <div class="copyright-bar">
                <div class="container">
                    <p>
                        استفاده از مطالب فروشگاه اینترنتی تاپ کالا فقط برای مقاصد غیرتجاری و با ذکر منبع بلامانع است.
                        کلیه حقوق این سایت متعلق به شرکت نوآوران فن آوازه (فروشگاه آنلاین تاپ کالا) می‌باشد.
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('front/assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('front/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('front/assets/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('front/assets/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
    <!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="{{ asset('front/assets/js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- Share Library etc -->
    <script src="{{ asset('front/assets/js/plugins/jquery.sharrre.js') }}" type="text/javascript"></script>
    <!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('front/assets/js/now-ui-kit.js') }}" type="text/javascript"></script>
    <!--  CountDown -->
    <script src="{{ asset('front/assets/js/plugins/countdown.min.js') }}" type="text/javascript"></script>
    <!--  Plugin for Sliders -->
    <script src="{{ asset('front/assets/js/plugins/owl.carousel.min.js') }}" type="text/javascript"></script>
    <!--  Jquery easing -->
    <script src="{{ asset('front/assets/js/plugins/jquery.easing.1.3.min.js') }}" type="text/javascript"></script>
    <!-- Main Js -->
    <script src="{{ asset('front/assets/js/main.js') }}" type="text/javascript"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.form-account');
    const inputs = form.querySelectorAll('input[type="password"]');

    function validateInput(input) {
        let pattern = null;
        switch(input.name) {
            case 'current_password':
                pattern = /^.{1,}$/;
                break;
            case 'password':
                pattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
                break;
            case 'password_confirmation':
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
</body>
</html> 