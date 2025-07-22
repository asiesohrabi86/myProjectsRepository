@extends('layouts.profile-master')
@section('content')
    <div class="row mb-3">
        <div class="col-12 text-left">
            <a href="/" class="btn btn-primary">بازگشت به صفحه اصلی سایت</a>
        </div>
    </div>
            @if(session('status'))
                <div class="alert alert-success mt-3">{{ session('status') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            <div class="row">
        <div class="col-xl-6 col-12">
                        <div class="col-12">
                            <h1 class="title-tab-content">اطلاعات شخصی</h1>
                        </div>
                        <div class="content-section default">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">نام و نام خانوادگی :</span>
                                        <span>{{ $user->name }}</span>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">پست الکترونیک :</span>
                                        <span>{{ $user->email }}</span>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">شماره تلفن همراه:</span>
                                        <span>{{ $user->phone_number ?? '-' }}</span>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">کد ملی :</span>
                                        <span>-</span>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">دریافت خبرنامه :</span>
                                        <span>بله</span>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>
                                        <span class="title">شماره کارت :</span>
                                        <span>-</span>
                                    </p>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="profile-additional-info.html" class="btn-link-border form-account-link">
                                        ویرایش اطلاعات شخصی
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
        <div class="col-xl-6 col-12">
                        <div class="col-12">
                            <h1 class="title-tab-content">لیست آخرین علاقمندی ها</h1>
                        </div>
                        <div class="content-section default">
                            <div class="row">
                                <div class="col-12">
                                    <div class="profile-recent-fav-row">
                                        <a href="#" class="profile-recent-fav-col profile-recent-fav-col-thumb">
                                            <img src="/front/assets/img/cart/4560621.jpg"></a>
                                        <div class="profile-recent-fav-col profile-recent-fav-col-title">
                                            <a href="#">
                                                <h4 class="profile-recent-fav-name">
                                                    گوشی موبایل اپل مدل iPhone XR دو سیم کارت ظرفیت 256 گیگابایت
                                                </h4>
                                            </a>
                                            <div class="profile-recent-fav-price">ناموجود</div>
                                        </div>
                                        <div class="profile-recent-fav-col profile-recent-fav-col-actions">
                                            <button class="btn-action btn-action-remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="profile-recent-fav-row">
                                        <a href="#" class="profile-recent-fav-col profile-recent-fav-col-thumb">
                                            <img src="/front/assets/img/cart/3794614.jpg"></a>
                                        <div class="profile-recent-fav-col profile-recent-fav-col-title">
                                            <a href="#">
                                                <h4 class="profile-recent-fav-name">
                                                    گوشی موبایل اپل مدل iPhone XR دو سیم کارت ظرفیت 256 گیگابایت
                                                </h4>
                                            </a>
                                            <div class="profile-recent-fav-price">ناموجود</div>
                                        </div>
                                        <div class="profile-recent-fav-col profile-recent-fav-col-actions">
                                            <button class="btn-action btn-action-remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="#" class="btn-link-border form-account-link">
                                        مشاهده و ویرایش لیست مورد علاقه
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h1 class="title-tab-content">آخرین سفارش ها</h1>
                    </div>
        <div class="col-12">
            <div class="content-section default">
                <div class="row">
                    @forelse ($orders as $order)
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>کد سفارش: {{ $order->id }}</span>
                                    <span>وضعیت: 
                                        @switch($order->status)
                                            @case('paid')
                                                <span class="badge badge-success">پرداخت شده</span>
                                                @break
                                            @case('unpaid')
                                                <span class="badge badge-warning">در انتظار پرداخت</span>
                                                @break
                                            @case('canceled')
                                                <span class="badge badge-danger">لغو شده</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">نامشخص</span>
                                        @endswitch
                                    </span>
                                    <span>مبلغ کل: {{ number_format($order->price) }} تومان</span>
                            </div>
                                <div class="card-body">
                                    @if($order->items && $order->items->count())
                                        <ul class="list-group">
                                            @foreach($order->items as $item)
                                                <li class="list-group-item d-flex align-items-center">
                                                    <img src="/{{ $item->product->image }}" alt="" style="width:60px;height:60px;object-fit:cover;margin-left:10px;">
                                                    <div>
                                                        <div><strong>{{ $item->product->title }}</strong></div>
                                                        <div>تعداد: {{ $item->quantity }}</div>
                                                        <div>قیمت: {{ number_format($item->price) }} تومان</div>
                        </div>
                                                    <a href="/product/{{ $item->product->id }}" class="btn btn-link ml-auto">مشاهده محصول</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-muted">محصولی برای این سفارش ثبت نشده است.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">شما هنوز سفارشی ثبت نکرده‌اید.</div>
                        </div>
                    @endforelse
                    </div>
            </div>
        </div>
    </div>
@endsection