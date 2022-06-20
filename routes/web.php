<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Block\Element\IndentedCode;

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

Route::get('/',[App\Http\Controllers\IndexController::class,'index'])->name('index');

Route::get('/single-course/{course}',[IndexController::class,'singlecourse'])->name('singlecourse');
Route::get('/single-master/{master}',[IndexController::class,'singlemaster'])->name('singlemaster');

Route::get('/calendar',[IndexController::class,'showCalendar'])->name('show.calendar');
Route::get('/aboutus',[IndexController::class,'showAboutus'])->name('show.aboutus');
Route::get('/contactus',[IndexController::class,'showContactus'])->name('show.contactus');
Route::get('/search',[IndexController::class,'search'])->name('search');
Route::post('/contactus/postForm',[IndexController::class,'postForm'])->name('postForm');



Auth::routes(['verify'=> true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('/panel')->middleware('checkuser')->group(function(){

    Route::get('', [AdminController::class , 'index'])->name('panel');
    Route::resource('/users' , UserController::class);
    Route::resource('/courses' , CourseController::class);
    Route::resource('/sliders',SliderController::class);
    Route::resource('/masters',MasterController::class);
    Route::resource('/calendars',CalendarController::class);

});



