<?php

// use App\Http\Controllers\Admin\CommentController as AdminCommentController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\Profile\ProfileController;
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

//profile frontend
Route::prefix('/profile')->group(function(){
    Route::get('/',[ProfileController::class,'index'])->name('profile');

    Route::get('/twofactor',[ProfileController::class,'twoFactorAuth'])->name('twofactorauth');

    Route::post('/twofactor',[ProfileController::class,'insTwoFactorAuth'])->name('ins.twofactorauth');

    Route::get('/twofactor/phone-verify',[ProfileController::class,'getPhoneVerify'])->name('phone.verify');

    Route::post('/twofactor/phone-verify',[ProfileController::class,'postPhoneVerify']);
});


//admin panel
Route::prefix('/dashboard')->group(function(){
   Route::get('/',[HomeController::class,'index']);
   Route::resource('/users' , UserController::class);
   Route::resource('/products',ProductController::class);
   Route::resource('/comments',AdminCommentController::class);
   Route::get('/comments-unapproved',[AdminCommentController::class,'unapprovedGet'])->name('unapproved.get');
   Route::patch('/comments-unapproved/{comment}',[AdminCommentController::class,'unapprovedPost'])->name('unapproved.post');
   Route::resource('/categories',CategoryController::class);
});



Auth::routes(['verify'=>true]);

// Products Client
Route::get('/products',[ControllersProductController::class,'index']);
Route::get('/product/{product}',[ControllersProductController::class,'singleProduct']);
Route::post('/product/comment',[CommentController::class,'sendComment'])->name('send.comment');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
