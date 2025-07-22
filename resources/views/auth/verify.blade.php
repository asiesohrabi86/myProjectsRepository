@extends('layouts.app')

@section('content')
<style>
    .btn.btn-link.p-0.m-0.align-baseline:is(:hover, :focus) {
        color: #0a58ca;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تایید ایمیل</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            لینک تایید جدید به ایمیل شما ارسال شد.
                        </div>
                    @endif

                    <p>برای ادامه، لطفاً ایمیل خود را بررسی و روی لینک تایید کلیک کنید.</p>
                    <p>اگر ایمیلی دریافت نکرده‌اید،</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">برای ارسال مجدد اینجا کلیک کنید</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
