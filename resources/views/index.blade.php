@extends('layouts.master')
@section('title','فروشگاه')
@section('content')
<main class="main default">
<div class="container">
    <!-- banner -->
    <div class="row banner-ads">
       <div class="col-12">
          <section class="banner">
               <a href="#">
                   <img src="front/assets/img/banner/banner.jpg" alt="">
               </a>
          </section>
       </div>
   </div>
    <!-- banner -->
    <div class="row">
        <aside class="sidebar col-12 col-lg-3 order-2 order-lg-1">
            <div class="sidebar-inner default">
                <div class="widget-banner widget card">
                    <a href="#" target="_top">
                        <img class="img-fluid" src="front/assets/img/banner/1455.jpg" alt="">
                    </a>
                </div>
                <div class="widget-services widget card">
                    <div class="row">
                        <div class="feature-item col-12">
                            <a href="#" target="_blank">
                                <img src="front/assets/img/svg/return-policy.svg">
                            </a>
                            <p>ضمانت برگشت</p>
                        </div>
                        <div class="feature-item col-6">
                            <a href="#" target="_blank">
                                <img src="front/assets/img/svg/payment-terms.svg">
                            </a>
                            <p>پرداخت درمحل</p>
                        </div>
                        <div class="feature-item col-6">
                            <a href="#" target="_blank">
                                <img src="front/assets/img/svg/delivery.svg">
                            </a>
                            <p>تحویل اکسپرس</p>
                        </div>
                        <div class="feature-item col-6">
                            <a href="#" target="_blank">
                                <img src="front/assets/img/svg/origin-guarantee.svg">
                            </a>
                            <p>تضمین بهترین قیمت</p>
                        </div>
                        <div class="feature-item col-6">
                            <a href="#" target="_blank">
                                <img src="front/assets/img/svg/contact-us.svg">
                            </a>
                            <p>پشتیبانی 24 ساعته</p>
                        </div>
                    </div>
                </div>
                <div class="widget-suggestion widget card">
                    <header class="card-header">
                        <h3 class="card-title">پیشنهاد لحظه ای</h3>
                    </header>
                    <div id="progressBar">
                        <div class="slide-progress"></div>
                    </div>
                    <div id="suggestion-slider" class="owl-carousel owl-theme">
                        @foreach($products as $product)
                        <div class="item">
                            <a href="/products/{{$product->id}}">
                                <img src="{{$product->image}}" class="w-100" alt="{{$product->title}}">
                            </a>
                            <h3 class="product-title">
                                <a href="/products/{{$product->id}}">{{$product->title}}</a>
                            </h3>
                            <div class="price">
                                <span class="amount">{{number_format($product->price)}}<span>تومان</span></span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_blank">
                        <img class="img-fluid" src="front/assets/img/banner/1000001422.jpg" alt="">
                    </a>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_blank">
                        <img class="img-fluid" src="front/assets/img/banner/side-banner-01.jpeg" alt="">
                    </a>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_top">
                        <img class="img-fluid" src="front/assets/img/banner/1000001322.jpg" alt="">
                    </a>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_blank">
                        <img class="img-fluid" src="front/assets/img/banner/1000001442.jpg" alt="">
                    </a>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_blank">
                        <img class="img-fluid"
                            src="front/assets/img/banner/8d546388-29d7-4733-871f-2d84a3012cc227_21_1_6.jpeg"
                            alt="">
                    </a>
                </div>
                <div class="widget-banner widget card">
                    <a href="#" target="_blank">
                        <img class="img-fluid" src="front/assets/img/banner/1000001422.jpg" alt="">
                    </a>
                </div>
            </div>
        </aside>
        <div class="col-12 col-lg-9 order-1 order-lg-2">
            <section id="main-slider" class="carousel slide carousel-fade card" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#main-slider" data-slide-to="1"></li>
                    <li data-target="#main-slider" data-slide-to="2"></li>
                    <li data-target="#main-slider" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <a class="d-block" href="#">
                            <img src="front/assets/img/slider/22f48d8e-6a8f-431c-985d-76ab0e1e59405_21_1_1.jpg"
                                class="d-block w-100" alt="">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a class="d-block" href="#">
                            <img src="front/assets/img/slider/a264d696-9c12-4dd9-bdc1-12c13a3632b329_21_1_1.jpg"
                                class="d-block w-100" alt="">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a class="d-block" href="#">
                            <img src="front/assets/img/slider/c0a50594-df40-412b-84f8-c7d6872fb83620_21_1_1.jpg"
                                class="d-block w-100" alt="">
                        </a>
                    </div>
                    <div class="carousel-item">
                        <a class="d-block" href="#">
                            <img src="front/assets/img/slider/d1844e92-e5a9-4aef-8ea7-49be936422ca6_21_1_1.jpg"
                                class="d-block w-100" alt="">
                        </a>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#main-slider" role="button" data-slide="prev">
                    <i class="now-ui-icons arrows-1_minimal-right"></i>
                </a>
                <a class="carousel-control-next" href="#main-slider" data-slide="next">
                    <i class="now-ui-icons arrows-1_minimal-left"></i>
                </a>
            </section>
            <section id="amazing-slider" class="carousel slide carousel-fade card" data-ride="carousel">
                <div class="row m-0">
                    <ol class="carousel-indicators pr-0 d-flex flex-column col-lg-3">
                        <li class="active" data-target="#amazing-slider" data-slide-to="0">
                            <span>لپ تاپ INSPIRON</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="1" class="">
                            <span>دل مدل 5471</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="2" class="">
                            <span>لپ تاپ ۱۵ اینچی</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="3" class="">
                            <span>۱۵ اینچی دل</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="4" class="">
                            <span>لنوو مدل 310</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="5" class="">
                            <span>لپ تاپ لنوو</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="6">
                            <span>لپ تاپ ۱۵ اینچی</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="7">
                            <span>لپ تاپ ایسوس</span>
                        </li>
                        <li data-target="#amazing-slider" data-slide-to="8">
                            <span>ایسوس مدل A540UP - F</span>
                        </li>
                        <li class="view-all">
                            <a href="#" class="btn btn-primary btn-block hvr-sweep-to-left">
                                <i class="fa fa-arrow-left"></i>مشاهده همه شگفت انگیزها
                            </a>
                        </li>
                    </ol>
                    <div class="carousel-inner p-0 col-12 col-lg-9">
                        <img class="amazing-title" src="front/assets/img/amazing-slider/amazing-title-01.png"
                            alt="">
                        @foreach($products as $product)
                        <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                            <div class="row m-0">
                                <div class="right-col col-5 d-flex align-items-center">
                                    <a class="w-100 text-center" href="/products/{{$product->id}}">
                                        <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                    </a>
                                </div>
                                <div class="left-col col-7">
                                    <div class="price">
                                        <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                    </div>
                                    <h2 class="product-title">
                                        <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                    </h2>
                                    <ul class="list-group">
                                        <li class="list-group-item">{{$product->description}}</li>
                                    </ul>
                                    <hr>
                                    <div class="countdown-timer" countdown data-date="05 02 2019 20:20:22">
                                        <span data-days>0</span>:
                                        <span data-hours>0</span>:
                                        <span data-minutes>0</span>:
                                        <span data-seconds>0</span>
                                    </div>
                                    <div class="timer-title">زمان باقی مانده تا پایان سفارش</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <div class="row" id="amazing-slider-responsive">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <img src="front/assets/img/amazing-slider/amazing-title-01.png" width="150px" alt="">
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($products as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row banner-ads">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <div class="widget-banner card">
                                <a href="#" target="_blank">
                                    <img class="img-fluid" src="front/assets/img/banner/banner-1.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="widget-banner card">
                                <a href="#" target="_top">
                                    <img class="img-fluid" src="front/assets/img/banner/banner-2.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="widget-banner card">
                                <a href="#" target="_top">
                                    <img class="img-fluid" src="front/assets/img/banner/banner-3.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="widget-banner card">
                                <a href="#" target="_top">
                                    <img class="img-fluid" src="front/assets/img/banner/banner-4.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>آخرین محصولات</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($latestProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>پربازدیدترین محصولات</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($mostViewedProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->old_price)
                                    <del><span>{{number_format($product->old_price)}}<span>تومان</span></span></del>
                                    @endif
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>دسته بندی موبایل</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($mobileCategoryProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->old_price)
                                    <del><span>{{number_format($product->old_price)}}<span>تومان</span></span></del>
                                    @endif
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>دسته بندی لپ تاپ</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($laptopCategoryProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->old_price)
                                    <del><span>{{number_format($product->old_price)}}<span>تومان</span></span></del>
                                    @endif
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>دسته بندی دوربین</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($cameraCategoryProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->old_price)
                                    <del><span>{{number_format($product->old_price)}}<span>تومان</span></span></del>
                                    @endif
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row banner-ads">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="widget widget-banner card">
                                <a href="#" target="_blank">
                                    <img class="img-fluid" src="front/assets/img/banner/banner-11.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget widget-product card">
                        <header class="card-header">
                            <h3 class="card-title">
                                <span>دسته بندی لوازم جانبی</span>
                            </h3>
                            <a href="#" class="view-all">مشاهده همه</a>
                        </header>
                        <div class="product-carousel owl-carousel owl-theme">
                            @foreach($accessoriesCategoryProducts as $product)
                            <div class="item">
                                <a href="/products/{{$product->id}}">
                                    <img src="{{$product->image}}" class="img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="/products/{{$product->id}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->old_price)
                                    <del><span>{{number_format($product->old_price)}}<span>تومان</span></span></del>
                                    @endif
                                    <ins><span>{{number_format($product->price)}}<span>تومان</span></span></ins>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="brand-slider card">
                <header class="card-header">
                    <h3 class="card-title"><span>برندهای ویژه</span></h3>
                </header>
                <div class="owl-carousel">
                    @foreach($brands as $brand)
                        <div class="item">
                            <a href="#">
                                <img src="{{asset($brand->image)}}" alt="{{asset($brand->name)}}" height="150px" width="150px">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@endsection