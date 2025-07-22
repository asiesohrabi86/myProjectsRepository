<div class="basket-header">
    <div class="basket-total">
        <span>مبلغ کل خرید:</span>
        <span>
            @php
                $total = 0;
                foreach($carts as $cart) {
                    $total += $cart->price * ($cart->quantity ?? 1);
                }
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
        <a href="{{route('payment.product',$basket->id)}}" class="basket-submit">پرداخت سفارش</a>
    @endif
@endif 