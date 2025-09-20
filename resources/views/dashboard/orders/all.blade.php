@extends('dashboard.layouts.master')
@section('title','مدیریت سفارشات')
@section('content')
<div class="main-content">
    <div class="data-table-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 box-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title mb-2">لیست سفارشات</h4>
                                </div>
                                <div class="col-lg-6">
                                    
                                </div>
                                <div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group"> <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" type="button"><span>کپی</span></button> <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="datatable-buttons" type="button"><span>پرینت</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="datatable-buttons_filter" class="dataTables_filter"><label>جستجو:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="datatable-buttons"></label></div></div></div>
                            </div>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>آیدی سفارش</th>
                                        <th>نام کاربر</th>
                                        <th>وضعیت پرداخت</th>
                                        <th>وضعیت ارسال</th>
                                        <th>مبلغ سفارش</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ number_format($order->id) }}</td>
                                        <td>{{$order->user->name}}</td>
                                        <td>
                                          @switch($order->status)
                                              @case('paid')
                                                  <span class="badge badge-success">پرداخت شده</span>
                                                  @break
                                              @case('unpaid')
                                                  <span class="badge badge-danger">پرداخت نشده</span>
                                                  @break
                                              @default
                                                    <span class="badge badge-warning">درحال پردازش</span>   
                                          @endswitch  
                                        </td>

                                        <td>
                                            @switch($order->delivery)
                                                @case(1)
                                                    <span class="badge badge-success">تحویل شده</span>
                                                    @break
                                                @default
                                                      <span class="badge badge-warning">درحال پردازش</span>   
                                            @endswitch  
                                          </td>
                                        <td>{{ number_format($order->price) }}</td>

                                        <td class="row">
                                          <a href="{{route('invoice.index',$order->id)}}" class="btn btn-primary btn-sm">نمایش فاکتور</a> 
                                          
                                          <form action="{{route('orders.destroy',$order->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('آیا از حذف سفارش موردنظر مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                        </td>
                                    </tr>  
                                    @endforeach
                                    
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

 
        </div>
    </div>
</div>
@if(session('delivery_status_changed'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'وضعیت ارسال با موفقیت تغییر کرد',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
@endif
@endsection