<div class="basket-header">
    <div class="basket-total">
        <span>مبلغ کل خرید:</span>
        <span>
            @php
                $total = 0;
                foreach($carts as $cart) {
                    $total += $cart->price * ($cart->quantity ?? 1);
                }
                $isStockAvailable = true; // یک پرچم برای بررسی موجودی
            @endphp
            {{ number_format($total) }}
        </span>
        <span> تومان</span>
    </div>
    <a href="{{route('cart.index')}}" class="basket-link">
        <span>مشاهده سبد خرید</span>
        <div class="basket-arrow"></div>
    </a>
</div>
<ul class="basket-list">
    @if(count($carts) === 0)
        <li style="text-align:center; color:#888; padding:20px 0;">سبد خرید شما خالی است</li>
    @else
        @foreach($carts as $cart)
            @php
                $product = \App\Models\Product::find($cart->product_id);
                $color = $cart->color_id ? DB::table('product_colors')->where('id', $cart->color_id)->first() : null;
                // **بررسی موجودی برای هر آیتم**
                $hasEnoughStock = $product->amount >= $cart->quantity;
                if (!$hasEnoughStock) {
                    $isStockAvailable = false; // اگر حتی یک محصول موجودی نداشت، پرچم را false کن
                }
            @endphp
            <li data-id="{{ $cart->id }}">
                <div class="basket-item">
                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('delete')
                        <button type="button" class="basket-item-remove basket-item-remove-ajax" data-id="{{ $cart->id }}"></button>
                    </form>
                    <div class="basket-item-content">
                        <div class="basket-item-image">
                            <img alt="" src="{{ $product->image }}">
                        </div>
                        <div class="basket-item-details">
                            <div class="basket-item-title">{{ $product->title }}</div>
                            <div class="basket-item-params">
                                <div class="basket-item-props">
                                    <span>{{ $cart->quantity }} عدد</span>
                                    @if($color)
                                        <span>رنگ {{ $color->color_name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    @endif
</ul>
@if(count($carts) > 0)
    @php
        $basket = DB::table('baskets')->where('user_id',auth()->user()->id)->where('isActive',1)->first();
    @endphp
    @if($basket)
        {{-- **شرطی کردن نمایش دکمه پرداخت** --}}                                     
        @if (isset($basket) && count($carts) > 0)
            @if($isStockAvailable)
                <a href="{{ route('payment.product', $basket->id) }}" class="selenium-next-step-shipping">
                    <button class="dk-btn dk-btn-info w-100 basket-submit">پرداخت سفارش</button>
                </a>
            @else
                <button class="dk-btn dk-btn-info w-100 basket-submit" disabled>پرداخت سفارش</button>
                <p class="text-danger text-right p-2 mt-2" style="font-size:12px;">برای ادامه، لطفاً موجودی سبد خرید خود را اصلاح کنید.</p>
            @endif
        @endif
    @endif
@endif 