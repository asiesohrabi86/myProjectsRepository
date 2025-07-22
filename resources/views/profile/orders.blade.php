@extends('layouts.profile-master')
@section('title','سفارشات من')
    
@section('content')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-12">
                            <h1 class="title-tab-content">همه سفارش ها</h1>
                        </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- <div class="content-section default"> -->
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
                                    @if($order->basket && $order->items->count())
                                        <ul class="list-group">
                                            @foreach($order->items as $orderItem)
                                                <li class="list-group-item d-flex align-items-center" style="overflow-x: auto;">
                                                    <img src="{{ asset($orderItem->product->image) }}" alt="" style="width:60px;height:60px;object-fit:cover;margin-left:10px;">
                                                    <div class="d-flex">
                                                        <div class="mr-3 ml-3 text-nowrap"><strong>{{ $orderItem->product->title }}</strong></div>
                                                        <div class="mr-3 ml-3 text-nowrap">تعداد: {{ $orderItem->quantity }}</div>
                                                        <div class="mr-3 ml-5 text-nowrap">قیمت: {{ number_format($orderItem->price) }} تومان</div>
                        </div>
                                                    <a href="/product/{{ $orderItem->product->id }}" class="btn btn-link ml-auto">مشاهده محصول</a>
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
            <!-- </div> -->
        </div>
    </div>
@endsection