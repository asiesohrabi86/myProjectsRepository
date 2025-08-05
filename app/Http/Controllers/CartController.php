<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::where('user_id',auth()->user()->id)->get();
        return view('cart',compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $requestedQuantity = $request->quantity ?? 1;

        // ** بررسی جامع موجودی**
        
        // ۱. تعداد این محصول که از قبل در سبد خرید کاربر است را پیدا کن
        $quantityInCart = Cart::where('user_id', auth()->id())
                              ->where('product_id', $product->id)
                              ->sum('quantity');
        
        // ۲. مجموع تعداد درخواستی و تعداد موجود در سبد را محاسبه کن
        $totalQuantityNeeded = $quantityInCart + $requestedQuantity;

        // ۳. با موجودی انبار مقایسه کن
        if ($totalQuantityNeeded > $product->amount) {
            $availableToAdd = $product->amount - $quantityInCart;
            $message = $availableToAdd > 0
                ? "شما فقط می‌توانید {$availableToAdd} عدد دیگر از این محصول را به سبد خرید اضافه کنید."
                : "موجودی این محصول به اتمام رسیده یا تعداد در سبد خرید شما به حداکثر رسیده است.";
            
            // برای درخواست‌های AJAX، یک پاسخ خطای JSON برمی‌گردانیم
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422); // 422 Unprocessable Entity
            }

            // برای درخواست‌های عادی، با یک پیام خطا به عقب برمی‌گردیم
            return back()->withErrors(['quantity' => $message]);
        }
        
        $isCart = DB::table('carts')->where('user_id',auth()->user()->id)->first(); 
        $basket = DB::table('baskets')->where('user_id',auth()->user()->id)->where('isActive',1)->first();
        $finalPrice = $request->final_price;
        if(! is_null($basket))
        {
            DB::table('baskets')->where('user_id',auth()->user()->id)->where('isActive',1)->update([
                'price' => $request->quantity==null ? $basket->price + $finalPrice : $basket->price + $request->quantity*$finalPrice,
            ]);
        }else{
            $basket = Basket::create([
                'user_id' => auth()->user()->id,
                'price' => $request->quantity==null ? $finalPrice :$request->quantity*$finalPrice, 
            ]);
        }
        
        Cart::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'basket_id' => $basket->id,
            'price' => $finalPrice,
            'color_id' => $request->color_id,
            'guarantee_id' => $request->guarantee_id,
        ]);
        if($request->expectsJson()) {
            // رندر کردن html سبد خرید کوچک هدر
            $carts = \App\Models\Cart::where('user_id', auth()->user()->id)->get();
            $headerHtml = view('layouts.partials.header-cart', compact('carts'))->render();
            return response()->json(['success' => true, 'headerHtml' => $headerHtml]);
        }
        alert()->success('محصول به سبد خرید شما اضافه شد');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $basket = $cart->basket;
        $cart->delete();

        // محاسبه مجموع قیمت آیتم‌های باقی‌مانده
        $total = Cart::where('basket_id', $basket->id)
            ->sum(\DB::raw('price * quantity'));

        // آپدیت قیمت سبد خرید
        if ($basket) {
            $basket->update([
                'price' => $total,
            ]);
        }

        return response()->json(['success' => true, 'total' => $total]);
    }

    public function headerPartial()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        return view('layouts.partials.header-cart', compact('carts'))->render();
    }
}
