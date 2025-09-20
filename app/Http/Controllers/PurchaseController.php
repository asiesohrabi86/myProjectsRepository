<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Exception;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use SoapFault;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Basket $basket)
    {
        
        $user = auth()->user();
        
        // اطمینان از اینکه سبد خرید متعلق به کاربر است و فعال است
        if ($basket->user_id !== $user->id || !$basket->isActive) {
            abort(403);
        }
        // سبد خرید پرداخت شده در جدول سفارشات قرار می گیرد،پس اگر در جدول سفارشات باشد یعنی پرداخت شده و باید ارور بدهد
        $orderExist = Order::where('user_id',Auth::id())->where('basket_id',$basket->id)->first();
        if($orderExist)
        {
            return "این سبد قبلا پرداخت شده است";
        }

        // ۱. ابتدا نیاز کل به هر محصول را در سبد خرید محاسبه و تجمیع می‌کنیم.
        $productQuantitiesNeeded = $basket->carts()
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->get()
            ->pluck('total_quantity', 'product_id'); // نتیجه: [product_id => total_quantity]

        // اگر سبد خالی بود، اجازه ادامه نده
        if ($productQuantitiesNeeded->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['payment' => 'سبد خرید شما خالی است.']);
        }


        try{
             // **شروع تراکنش دیتابیس**
            return DB::transaction(function () use ($basket, $user, $productQuantitiesNeeded) {
                
                // ۱. چک کردن مجدد موجودی تمام محصولات با قفل‌گذاری
                foreach ($productQuantitiesNeeded as $productId => $neededQuantity) {
                    $product = Product::lockForUpdate()->find($productId);

                    if ($product->amount < $neededQuantity) {
                        // اگر موجودی کافی نبود، تراکنش را rollBack کن و خطا بده
                        throw new \Exception("متاسفانه موجودی محصول \"{$product->title}\" کافی نیست. موجودی فعلی: {$product->amount} عدد.");
                    }
                }

                // ۲. اگر همه محصولات موجود بودند، موجودی را کم کن
                foreach ($productQuantitiesNeeded as $productId => $neededQuantity) {
                    $product = Product::find($productId);
                    $product->decrement('amount', $neededQuantity);
                    if($product->amount < 5){
                        try {
                            $admins = User::where('is_admin', true)->get();
                            if ($admins->isNotEmpty()) {
                                $productTitle = $product->title;
                                
                                $notificationData = [
                                    'text' => "موجودی محصول " . $productTitle . "کمتر از 5 شده است" ,
                                    'icon' => 'fa-coins text-warning',
                                    'url'  => route('products.update', $product->id) 
                                ];

                                // **استفاده از حلقه برای جلوگیری از خطای Duplicate ID**
                                foreach ($admins as $admin) {
                                    $admin->notify(new GeneralNotification($notificationData));
                                }
                            }
                        } catch (\Exception $e) {
                            \Log::error('Failed to send new comment notification: ' . $e->getMessage());
                        }
                    }
                }
                // 3-
                $invoice = new Invoice();
                $invoice->amount($basket->price);
                $invoice->detail('موبایل کاربر:',$user->phone_number);
                $paymentId = md5(uniqid());

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'basket_id' => $basket->id,
                    'paid' => $invoice->getAmount(),
                    'invoice_details' => $invoice,
                    'payment_id' => $paymentId,
                
                ]);
            
                $callbackUrl = route('payment.product.result',[$basket->id,'payment_id'=>$paymentId]);

                $payment = Payment::callbackUrl($callbackUrl);
                $payment->config('description' , $user->name);

                $payment->purchase($invoice,function($driver,$transactionId) use($transaction){
                    $transaction->transaction_id = $transactionId;
                    $transaction->save(); 
                });

                return $payment->pay()->render();
            });

        }catch(Exception|PurchaseFailedException|SoapFault $e){
            // اگر در هر مرحله از تراکنش خطایی رخ دهد (چه موجودی و چه پرداخت)
            // به کاربر یک پیام واضح نمایش می‌دهیم.
            return redirect()->route('cart.index')->withErrors(['payment' => $e->getMessage()]);
        }
            
    }

    public function result(Request $request, $id)
    {
        $basket = Basket::findOrFail($id);
        if($request->missing('payment_id')){
            return "خطایی در پرداخت بوجود آمد";
        }

        $transaction = Transaction::where('payment_id',$request->payment_id)->first();
        if(empty($transaction)){
            return "خطایی در پرداخت بوجود آمد";
        }

        if($transaction->user_id !== Auth::id()){
            return "خطایی در پرداخت بوجود آمد";
        }

        if($transaction->basket_id !== $basket->id){
            return "خطایی در پرداخت بوجود آمد";
        }

        if($transaction->status !== Transaction::STATUS_PENDING){
            return "خطایی در پرداخت بوجود آمد";
        }

        try{
            $receipt = Payment::amount($transaction->paid)->transactionId($transaction->transaction_id)->verify();
            $transaction->transaction_result = $receipt;
            $transaction->status = Transaction::STATUS_SUCCESS;
            $transaction->save();
            $user = Auth::user();
            $order = Order::create([
                'user_id' => $user->id,
                'basket_id' => $basket->id,
                'price' => $basket->price,
                'status' => 'paid',
            ]);

            foreach ($basket->carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'color_id' => $cart->color_id,
                    'guarantee_id' => $cart->guarantee_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->price,
                ]);
            }

            $basket->update([
                'isActive'=>0
            ]);
            // حذف آیتم‌های سبد خرید مربوط به این سبد
            $basket->carts()->delete();
            // ریدایرکت به لیست سفارش‌ها با پیام موفقیت
            $orders = Order::where(['user_id' => auth()->user()->id, 'isActive' => 1])->get();
            // برای ارسال نوتیف به همه ادمین ها
            $admins = User::where('is_admin', true)->get();
            $notificationData = [
                'text' => "سفارش جدیدی به مبلغ " . number_format($transaction->paid) . " تومان ثبت شد.",
                'icon' => 'fa-user-plus text-info',
                'url' => route('users.show', $user->id) // یک لینک به پروفایل کاربر
            ];
            Notification::send($admins, new GeneralNotification($notificationData));
            return redirect()->route('profile.orders', compact('orders'))->with('success', 'پرداخت با موفقیت انجام شد و سفارش شما ثبت شد.');
        }catch(Exception|InvalidPaymentException $e){
            if($e->getCode()<0){
                $transaction->status = Transaction::STATUS_FAILED;
                $transaction->transaction_result = [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ];
                $transaction->save();
            }
            return "خطایی در پرداخت بوجود آمد";
        }
    }
}
