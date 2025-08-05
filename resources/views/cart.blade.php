@extends('layouts.master')
@section('content')
    <!-- main -->
    <main class="cart-page default">
        <div class="container">
            @if ($errors->has('payment'))
                <div class="alert alert-danger alert-dismissible fade show text-center my-3" role="alert">
                    <strong>خطا در فرآیند پرداخت:</strong>
                    <p class="mb-0">{{ $errors->first('payment') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="cart-page-content col-xl-9 col-lg-8 col-md-12 order-1">
                    <div class="cart-page-title">
                        <h1>سبد خرید</h1>
                    </div>
                    <div class="table-responsive checkout-content default">
                        <table class="table">
                            <tbody id="cart-table-body">
                                @php
                                    $total = 0;
                                    $payable = 0;
                                    $isStockAvailable = true; // یک پرچم برای بررسی موجودی
                                @endphp
                                @if(count($carts) === 0)
                                    <tr><td colspan="5" style="text-align:center; color:#888; padding:40px 0;">سبد خرید شما خالی است</td></tr>
                                @else
                                    @php
                                        foreach($carts as $cart) {
                                            $total += $cart->price * ($cart->quantity ?? 1);
                                        }
                                        $payable = $total; // اگر تخفیف یا هزینه ارسال دارید اینجا اعمال کنید
                                    @endphp
                                    @foreach ($carts as $cart)
                                        @php
                                            $basket = App\Models\Basket::where('id',$cart->basket_id)->where('isActive',1)->first();
                                        @endphp
                                        @if(isset($basket))
                                        @php
                                            // **بررسی موجودی برای هر آیتم**
                                            $hasEnoughStock = $cart->product->amount >= $cart->quantity;
                                            if (!$hasEnoughStock) {
                                                $isStockAvailable = false; // اگر حتی یک محصول موجودی نداشت، پرچم را false کن
                                            }
                                        @endphp
                                        <tr class="checkout-item" data-id="{{ $cart->id }}">
                                            @php
                                                $product = DB::table('products')->where('id',$cart->product_id)->first();    
                                            @endphp
                                            <td>
                                                <img src="{{$product->image}}" alt="" class="cart-item-image">
                                                <form action="{{route('cart.destroy',$cart->id)}}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="checkout-btn-remove cart-remove-ajax" data-id="{{ $cart->id }}"></button>
                                                </form>
                                            </td>
                                            <td>
                                                <h3 class="checkout-title">{{ $product->title }}</h3>
                                                {{-- **نمایش هشدار در صورت عدم وجود موجودی کافی** --}}
                                                @if (!$hasEnoughStock)
                                                    <div class="alert alert-warning mt-2 p-2" style="font-size: 12px;">
                                                        موجودی فعلی این محصول <strong>{{ $product->amount }}</strong> عدد است. لطفاً تعداد را اصلاح یا محصول را حذف کنید.
                                                    </div>
                                                @endif
                                               
                                                @if($cart->color_id)
                                                    @php $color = DB::table('product_colors')->where('id', $cart->color_id)->first(); @endphp
                                                    <div>رنگ: <span style="display:inline-block;width:16px;height:16px;background:{{$color->color}};border-radius:50%;vertical-align:middle;"></span> {{$color->color_name ?? ''}}</div>
                                                @endif
                                                @if($cart->guarantee_id)
                                                    @php $guarantee = DB::table('guarantees')->where('id', $cart->guarantee_id)->first(); @endphp
                                                    <div>گارانتی: {{$guarantee->name ?? ''}}</div>
                                                @endif
                                            </td>
                                            <td>{{$cart->quantity}}عدد</td>
                                            <td>{{ number_format($cart->price * ($cart->quantity ?? 1)) }} تومان</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <aside class="cart-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-2">
                    <div class="checkout-aside">
                        <div class="checkout-summary">
                            <div class="checkout-summary-main">
                                <ul class="checkout-summary-summary">
                                    <li><span>مبلغ کل ( کالا)</span><span>{{number_format($total)}} تومان</span></li>
                                    <li>
                                        <span>هزینه ارسال</span>
                                        <span>وابسته به آدرس<span class="wiki wiki-holder"><span
                                                    class="wiki-sign"></span>
                                                <div class="wiki-container js-dk-wiki is-right">
                                                    <div class="wiki-arrow"></div>
                                                    <p class="wiki-text">
                                                        هزینه ارسال مرسولات می‌تواند وابسته به شهر و آدرس گیرنده
                                                        متفاوت باشد. در
                                                        صورتی که هر
                                                        یک از مرسولات حداقل ارزشی برابر با ۱۰۰هزار تومان داشته باشد،
                                                        آن مرسوله
                                                        بصورت رایگان
                                                        ارسال می‌شود.<br>
                                                        "حداقل ارزش هر مرسوله برای ارسال رایگان، می تواند متغیر
                                                        باشد."
                                                    </p>
                                                </div>
                                            </span></span>
                                    </li>
                                </ul>
                                <div class="checkout-summary-devider">
                                    <div></div>
                                </div>
                                <div class="checkout-summary-content">
                                    <div class="checkout-summary-price-title">مبلغ قابل پرداخت:</div>
                                    <div class="checkout-summary-price-value">
                                        
                                        <span class="checkout-summary-price-value-amount">
                                          {{number_format($payable)}}    
                                        </span>تومان
                                    </div>
                                    @php
                                        use Illuminate\Support\Facades\DB;
                                        $basket = DB::table('baskets')->where('user_id',auth()->user()->id)->where('isActive',1)->first();
                                    @endphp
                                        @if (isset($basket))
                                            {{-- **شرطی کردن نمایش دکمه پرداخت** --}}
                                            
                                            @if (isset($basket) && count($carts) > 0)
                                            {{-- **شروع اصلاحیه ۲: اصلاح دکمه پرداخت** --}}
                                                @if($isStockAvailable)
                                                    <a href="{{ route('payment.product', $basket->id) }}" class="selenium-next-step-shipping">
                                                        <button class="dk-btn dk-btn-info w-100">پرداخت سفارش</button>
                                                    </a>
                                                @else
                                                    <button class="dk-btn dk-btn-info w-100" disabled>پرداخت سفارش</button>
                                                    <p class="text-danger mt-2" style="font-size:12px;">برای ادامه، لطفاً موجودی سبد خرید خود را اصلاح کنید.</p>
                                                @endif
                                            @endif
                                        @endif
                                      
                                    <div>
                                        <span>
                                            کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی
                                            را تکمیل
                                            کنید.
                                        </span>
                                        <span class="wiki wiki-holder"><span class="wiki-sign"></span>
                                            <div class="wiki-container is-right">
                                                <div class="wiki-arrow"></div>
                                                <p class="wiki-text">
                                                    محصولات موجود در سبد خرید شما تنها در صورت ثبت و پرداخت سفارش
                                                    برای شما رزرو
                                                    می‌شوند. در
                                                    صورت عدم ثبت سفارش، تاپ کالا هیچگونه مسئولیتی در قبال تغییر
                                                    قیمت یا موجودی
                                                    این کالاها
                                                    ندارد.
                                                </p>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout-feature-aside">
                            <ul>
                                <li class="checkout-feature-aside-item checkout-feature-aside-item-guarantee">
                                    هفت روز
                                    ضمانت تعویض
                                </li>
                                <li class="checkout-feature-aside-item checkout-feature-aside-item-cash">
                                    پرداخت در محل با
                                    کارت بانکی
                                </li>
                                <li class="checkout-feature-aside-item checkout-feature-aside-item-express">
                                    تحویل اکسپرس
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
    <!-- main -->
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cart-remove-ajax').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var cartId = this.getAttribute('data-id');
            if(!cartId) return;
            if(!confirm('آیا از حذف این آیتم مطمئن هستید؟')) return;
            var row = this.closest('tr');
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/cart/' + cartId, {
                _method: 'DELETE',
            })
            .then(function(response) {
                row.remove();
                // بروزرسانی مبلغ کل
                if(response.data && response.data.total !== undefined) {
                    var totalElem = document.querySelector('.checkout-summary-summary li span:last-child');
                    var payElem = document.querySelector('.checkout-summary-price-value-amount');
                    if(totalElem) totalElem.textContent = response.data.total + ' تومان';
                    if(payElem) payElem.textContent = response.data.total;
                }
                // اگر جدول خالی شد پیام نمایش بده
                if(document.querySelectorAll('#cart-table-body tr').length === 0) {
                    document.querySelector('#cart-table-body').innerHTML = '<tr><td colspan="5" style="text-align:center; color:#888; padding:40px 0;">سبد خرید شما خالی است</td></tr>';
                }
                // بروزرسانی کل سبد خرید کوچک هدر
                axios.get('/cart-header-partial').then(function(res){
                    var cartDropdown = document.querySelector('.cart.dropdown .dropdown-menu');
                    if(cartDropdown) {
                        cartDropdown.innerHTML = res.data;
                    }
                });
                swal('موفقیت', 'محصول با موفقیت از سبد خرید حذف شد', 'success');
            })
            .catch(function(error) {
                swal('خطا', 'خطا در حذف آیتم!', 'error');
            });
        });
    });
});
</script>
@endsection
