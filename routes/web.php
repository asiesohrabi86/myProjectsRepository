<?php

// use App\Http\Controllers\Admin\CommentController as AdminCommentController;

use App\Http\Controllers\Aamin\AttributeController as AaminAttributeController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GuaranteeController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TestRegController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Hekmatinasser\Verta\Verta;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//front shop
Route::get('/',[IndexController::class,'index'] );
// Route::get('/',function(){
//     // $v = new Verta();
//     // return Verta::getJalali(2022,7,5); 
//     // return $v;
//     $v = verta("2022-07-05 13:13:27");
//     return $v->format('Y/n/j H:i:s');
// }
//  );




//Google Acount Login/Register
Route::get('/auth/google/redirect',[GoogleAuthController::class,'redirect'])->name('auth.google');

Route::get('auth/google/callback',[GoogleAuthController::class,'callback']);

//Token Two Authenticated
Route::get('/auth/token',[AuthTokenController::class,'getToken'])->name('auth.token');
Route::post('/auth/token',[AuthTokenController::class,'postToken']);

// اضافه کردن middleware سفارشی برای twofactor
Route::middleware(['twofactor'])->group(function() {
    Route::prefix('/profile')->middleware(['auth', 'verified'])->group(function(){
        Route::get('/',[ProfileController::class,'index'])->name('profile');

        Route::get('/twofactor',[ProfileController::class,'twoFactorAuth'])->name('twofactorauth');

        Route::post('/twofactor',[ProfileController::class,'insTwoFactorAuth'])->name('ins.twofactorauth');

        Route::get('/twofactor/phone-verify',[ProfileController::class,'getPhoneVerify'])->name('phone.verify');

        Route::post('/twofactor/phone-verify',[ProfileController::class,'postPhoneVerify']);

        Route::get('/orders',[ProfileController::class,'orders'])->name('profile.orders');

        Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
        Route::post('/change-password', [ProfileController::class, 'changePassword']);

        Route::get('/test-sms', [ProfileController::class, 'testSms'])->name('test.sms');
    });
});


//admin panel
Route::prefix('/dashboard')->group(function(){
   Route::get('/',[HomeController::class,'index'])->name('dashboard.index');
   Route::resource('/users' , UserController::class);
   Route::resource('/products',ProductController::class);
   Route::resource('/products/guarantees',GuaranteeController::class);
   Route::resource('/products/colors',ProductColorController::class);
   Route::resource('/brands',BrandController::class);
   Route::resource('/comments',AdminCommentController::class);
   Route::get('/comments-unapproved',[AdminCommentController::class,'unapprovedGet'])->name('unapproved.get');

   Route::patch('/comments-unapproved/{comment}',[AdminCommentController::class,'unapprovedPost'])->name('unapproved.post');

   Route::resource('/categories',CategoryController::class);
   Route::resource('/attributes',AttributeController::class);
   Route::get('/attributes/values/{attribute}' , [AttributeController::class , 'getValues'])->name('attribute.get.values');

    // Attributes
   Route::post('/attributes/values/{attribute}' , [AttributeController::class , 'postValues'])->name('attribute.post.values');

   Route::get('/attributes/values/edit/{attributeValue}' ,  [AttributeController::class,'editValues'])->name('attribute.edit.values');

   Route::patch('/attributes/values/edit/{attributeValue}',[AttributeController::class,'updateValues'])->name('attribute.update.values');

   Route::delete('/attributes/values/delete/{attributeValue}',[AttributeController::class,'destroyValues'])->name('attribute.destroy.values');

    // Permissions
    Route::resource('/permissions',PermissionController::class);
    Route::resource('/roles',RoleController::class);
    Route::get('/users/{user}/roles',[UserController::class,'addRole'])->name('users.role');
    Route::patch('/users/{user}/roles',[UserController::class,'updateRole'])->name('users.role.update');

    // orders
    Route::resource('/orders',OrderController::class);
    Route::get('/orders/invoice/{id}',[OrderController::class,'invoice'])->name('invoice.index');
    Route::put('/orders/invoice/{id}',[OrderController::class,'invoiceStatus'])->name('status.invoice');
});


Auth::routes(['verify'=>true]);


// Products Client
Route::get('/products',[ControllersProductController::class,'index']);
Route::get('/product/{product}',[ControllersProductController::class,'singleProduct']);
Route::post('/product/comment',[CommentController::class,'sendComment'])->name('send.comment');
Route::get('/products/{product}',[ControllersProductController::class,'singleProduct']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// افزودن میدلور verified به سبد خرید
// تعریف resource cart بدون میدلور برای افزودن کالا (store)
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
// سایر متدهای cart با میدلور auth و verified
Route::get('/cart', [CartController::class, 'index'])->middleware(['auth','verified'])->name('cart.index');
Route::get('/cart/{cart}', [CartController::class, 'show'])->middleware(['auth','verified'])->name('cart.show');
Route::put('/cart/{cart}', [CartController::class, 'update'])->middleware(['auth','verified'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->middleware(['auth','verified'])->name('cart.destroy');
Route::get('/product/{basket}/purchase',[PurchaseController::class,'purchase'])->middleware(['auth','verified'])->name('payment.product');
Route::get('/product/{id}/purchase/result',[PurchaseController::class,'result'])->middleware(['auth','verified'])->name('payment.product.result');

Route::get('/auth/resend-activation-code',[AuthTokenController::class,'resendActivationCode'])->name('resend.activation.code');

Route::get('/cart-header-partial', [App\Http\Controllers\CartController::class, 'headerPartial'])->middleware('auth');

// Auth::routes();