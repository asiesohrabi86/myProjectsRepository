<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
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

class PurchaseController extends Controller
{
    public function purchase(Basket $basket)
    {
        $user = Auth::user();
        // سبد خرید پرداخت شده در جدول سفارشات قرار می گیرد،پس اگر در جدول سفارشات باشد یعنی پرداخت شده و باید ارور بدهد
        $orderExist = Order::where('user_id',Auth::id())->where('basket_id',$basket->id)->first();
        if($orderExist)
        {
            return "این سبد قبلا پرداخت شده است";
        }

        try{
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

            }catch(Exception|PurchaseFailedException|SoapFault $e){
                // برای دیباگ، پیام خطا را نمایش بده
                return $e->getMessage() . ' | ' . $e->getCode();
                // کد قبلی:
                // $transaction = $basket->transactions()->first();
                // $transaction->transaction_result = [
                //     'message' => $e->getMessage(),
                //     'code' => $e->getCode(),
                // ];
                // $transaction->status = Transaction::STATUS_FAILED;
                // $transaction->save();
                // return "خطایی در پرداخت به وجود آمد";
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
