@extends('layouts.app')
@section('title', 'دسترسی غیرمجاز')
@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 text-danger">403</h1>
    @if(auth()->check() && !auth()->user()->hasVerifiedEmail())
        <h2>{{ __("auth.verify_email_first") }}</h2>
        <p class="mt-3">برای ادامه استفاده از امکانات سایت، لطفاً ایمیل خود را تایید کنید.</p>
        <a href="{{ route('verification.notice') }}" class="btn btn-primary mt-3">صفحه تایید ایمیل</a>
    @else
        <h2>شما مجوز دسترسی به این بخش را ندارید.</h2>
        <a href="{{ url('/') }}" class="btn btn-secondary mt-3">بازگشت به صفحه اصلی</a>
    @endif
</div>
@endsection 