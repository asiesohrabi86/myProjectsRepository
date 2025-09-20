@extends('dashboard.layouts.master')
@section('title','نمایش فاکتور')
@section('content')
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 box-margin">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive mb-4">
                            <table class="table m-0">
                                
                                <thead>
                                    <tr>
                                        <th class="py-3 text-nowrap">نام محصول</th>
                                        <th class="py-3 text-nowrap">رنگ</th>
                                        <th class="py-3 text-nowrap">گارانتی</th>
                                        <th class="py-3 text-nowrap">قیمت محصول</th>
                                        <th class="py-3 text-nowrap">تعداد</th>
                                        <th class="py-3 text-nowrap">مبلغ کل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $orderItem)
                                    <tr>
                                        <td class="py-3 text-nowrap">{{$orderItem->product->title}}</td>
                                        <td class="py-3 text-nowrap">
                                            @if($orderItem->color)
                                                <span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:{{$orderItem->color->color}};border:1px solid #ccc;vertical-align:middle;"></span>
                                                <span style="margin-right:5px">{{$orderItem->color->color_name}}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-nowrap">
                                            @if($orderItem->guarantee)
                                                {{$orderItem->guarantee->name}}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-nowrap">{{ number_format($orderItem->price) }}</td>
                                        <td class="py-3 text-nowrap">{{ number_format($orderItem->quantity) }}</td>
                                        <td class="py-3 text-nowrap">{{ number_format($orderItem->price * $orderItem->quantity) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <strong>وضعیت ارسال:</strong>
                            <span id="delivery-status">
                                @if($order->delivery == 1)
                                    <span class="badge badge-success">تحویل شده</span>
                                @else
                                    <span class="badge badge-warning">در حال پردازش</span>
                                @endif
                            </span>
                            <form id="delivery-form" action="{{ route('status.invoice', $order->id) }}" method="post" style="display:inline-block;margin-right:10px;">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn @if($order->delivery == 1) btn-danger @else btn-primary @endif btn-sm">
                                    @if($order->delivery == 1)
                                        لغو تحویل
                                    @else
                                        تایید ارسال
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection