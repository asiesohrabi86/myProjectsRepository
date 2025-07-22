@extends('layouts.master')
@section('title', $product->title)
@section('content')
    <!-- main -->
    <main class="single-product default">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success text-center my-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="breadcrumb">
                        <li><a href="#"><span>فروشگاه</span></a></li>
                        @foreach($product->categories as $category)
                            <li><a href="#"><span>{{ $category->name }}</span></a></li>
                        @endforeach
                        <li><span>{{ $product->title }}</span></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <article class="product">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="product-gallery default">
                                <img class="zoom-img" id="img-product-zoom" src="/{{ $product->image }}" data-zoom-image="/{{ $product->image }}" width="411" />

                                <!-- <div class="mb-1" id="gallery_01f" style="width:500px;float:left;">
                                    <ul class="gallery-items">
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/{{ $product->image }}" data-zoom-image="/{{ $product->image }}">
                                                <img src="/{{ $product->image }}" width="400px" /></a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                            <ul class="gallery-options">
                                <li>
                                    <button class="add-favorites"><i class="fa fa-heart"></i></button>
                                    <span class="tooltip-option">افزودن به علاقمندی</span>
                                </li>
                                <li>
                                    <button data-toggle="modal" data-target="#myModal"><i class="fa fa-share-alt"></i></button>
                                    <span class="tooltip-option">اشتراک گذاری</span>
                                </li>
                            </ul>
                            <!-- Modal Core -->
                            <div class="modal-share modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">اشتراک گذاری</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-share">
                                                <div class="form-share-title">اشتراک گذاری در شبکه های اجتماعی</div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="btn-group-share">
                                                            <li><a href="#" class="btn-share btn-share-twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                                            <li><a href="#" class="btn-share btn-share-facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                                            <li><a href="#" class="btn-share btn-share-google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="form-share-title">ارسال به ایمیل</div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="ui-input ui-input-send-to-email">
                                                            <input class="ui-input-field" type="email" placeholder="آدرس ایمیل را وارد نمایید.">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn-primary">ارسال</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <form class="form-share-url default">
                                                <div class="form-share-url-title">آدرس صفحه</div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="ui-url">
                                                            <input class="ui-url-field" value="https://www.digikala.com">
                                                        </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Core -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="product-title default">
                                <h1>{{ $product->title }}</h1>
                            </div>
                            <div class="product-directory default">
                                <ul>
                                    <li>
                                        <span>برند</span> :
                                        <span class="product-brand-title">{{ $product->brand ? $product->brand->name : '---' }}</span>
                                    </li>
                                    <li>
                                        <span>دسته‌بندی</span> :
                                        @foreach($product->categories as $category)
                                            <a href="#" class="btn-link-border">{{ $category->name }}</a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            @php
                                $basePrice = $product->price;
                            @endphp
                            <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                <input type="hidden" name="final_price" id="final-price-input" value="{{ $basePrice }}">
                                <input type="hidden" name="color_id" id="color-id-input" value="">
                                <input type="hidden" name="guarantee_id" id="guarantee-id-input" value="">
                                <div class="product-variants default">
                                    @if($product->colors->count())
                                        <span>انتخاب رنگ: </span>
                                        <div class="d-flex flex-wrap" id="color-select-group">
                                            @foreach($product->colors as $color)
                                                <label class="color-circle" data-color-id="{{$color->id}}" data-price-increase="{{$color->price_increase ?? 0}}" style="background:{{$color->color}}; margin-left:10px; margin-bottom:8px; cursor:pointer;"></label>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="color_id" id="selected-color-id">
                                    @endif
                                </div>
                                <div class="product-guarantee default">
                                    @if($product->guarantees->count())
                                        <span>انتخاب گارانتی: </span>
                                        @foreach($product->guarantees as $guarantee)
                                            <div class="custom-radio-guarantee">
                                                <input type="radio" name="guarantee_id" id="guarantee_{{$guarantee->id}}" value="{{$guarantee->id}}" data-price-increase="{{$guarantee->price_increase ?? 0}}">
                                                <span class="radio-dot"></span>
                                                <label for="guarantee_{{$guarantee->id}}" class="guarantee-label">{{ $guarantee->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="price-product defualt">
                                    <div class="price-value">
                                        <span id="final-price">{{ number_format($basePrice) }}</span>
                                        <span class="price-currency">تومان</span>
                                    </div>
                                </div>
                                <div class="product-add default">
                                    <div class="parent-btn">
                                        <div class="form-group" style="display:inline-block; margin-left:10px;">
                                            <label for="quantity">تعداد</label>
                                            <input type="number" name="quantity" class="form-control" value="1" min="1" style="width:80px; display:inline-block;">
                                        </div>
                                        <button type="submit" class="dk-btn dk-btn-info" style="vertical-align:middle;">
                                            <i class="now-ui-icons shopping_cart-simple" style="margin-left:5px;"></i>
                                            افزودن به سبد خرید
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 col-sm-12 center-breakpoint">
                            <div class="product-guaranteed default">
                                بیش از ۱۸۰ نفر از خریداران این محصول را پیشنهاد داده‌اند
                            </div>
                            @if($product->attributes->count())
                                <div class="product-params default">
                                    <ul data-title="ویژگی‌های محصول">
                                        @foreach($product->attributes as $attribute)
                                            <li>
                                                <span>{{ $attribute->name }}: </span>
                                                <span>
                                                    @php
                                                        $valueId = $attribute->pivot->value_id ?? null;
                                                        $attrValue = $attribute->values->where('id', $valueId)->first();
                                                    @endphp
                                                    {{ $attrValue ? $attrValue->value : '' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="container mt-2">
                <div class="col-12 default no-padding">
                    <div class="product-tabs default">
                        <div class="box-tabs default">
                            <ul class="nav" role="tablist">
                                <li class="box-tabs-tab">
                                    <a class="active" data-toggle="tab" href="#desc" role="tab" aria-expanded="true">
                                        <i class="now-ui-icons objects_umbrella-13"></i> نقد و بررسی
                                    </a>
                                </li>
                                <li class="box-tabs-tab">
                                    <a data-toggle="tab" href="#params" role="tab" aria-expanded="false">
                                        <i class="now-ui-icons shopping_cart-simple"></i> مشخصات
                                    </a>
                                </li>
                                <li class="box-tabs-tab">
                                    <a data-toggle="tab" href="#comments" role="tab" aria-expanded="false">
                                        <i class="now-ui-icons shopping_shop"></i> نظرات کاربران
                                    </a>
                                </li>
                                <li class="box-tabs-tab">
                                    <a data-toggle="tab" href="#questions" role="tab" aria-expanded="false">
                                        <i class="now-ui-icons ui-2_settings-90"></i> پرسش و پاسخ
                                    </a>
                                </li>
                            </ul>
                            <div class="card-body default">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="desc" role="tabpanel" aria-expanded="true">
                                        <article>
                                            <h2 class="param-title">
                                                نقد و بررسی تخصصی
                                                <span>{{ $product->title }}</span>
                                            </h2>
                                            <div class="parent-expert default">
                                                <div class="content-expert">
                                                    <p>
                                                        {!! $product->text !!}
                                                    </p>
                                                </div>
                                                <div class="sum-more">
                                                    <span class="show-more btn-link-border">
                                                        نمایش بیشتر
                                                    </span>
                                                    <span class="show-less btn-link-border">
                                                        بستن
                                                    </span>
                                                </div>
                                                <div class="shadow-box"></div>
                                            </div>

                                            <div class="accordion default" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                Face ID (کسی به‌غیراز تو را نمی‌شناسم)
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <img src="assets/img/single-product/1406986.jpg" alt="">
                                                            <p>
                                                                در فناوری تشخیص چهره‌ی اپل، یک دوربین و
                                                                فرستنده‌ی مادون‌قرمز در بالای نمایشگر قرار داده
                                                                ‌شده‌ است؛ هنگامی‌که آیفون
                                                                می‌خواهد چهره‌ی شما را تشخیص دهد، فرستنده‌ی نوری
                                                                نامرئی را به ‌صورت شما می‌تاباند. دوربین
                                                                مادون‌قرمز، این نور را تشخیص
                                                                داده و با الگویی که قبلا از صورت شما ثبت کرده،
                                                                مطابقت می‌دهد و در صورت یکی‌بودن، قفل گوشی را
                                                                باز می‌کند. اپل ادعا کرده،
                                                                الگوی صورت را با استفاده از سی هزار نقطه ذخیره
                                                                می‌کند که دورزدن آن اصلا کار ساده‌ای نیست.
                                                                استفاده از ماسک، عکس یا موارد
                                                                مشابه نمی‌تواند امنیت اطلاعات شما را به خطر
                                                                اندازد؛ اما اگر برادر یا خواهر دوقلو دارید، باید
                                                                برای امنیت اطلاعاتتان نگران
                                                                باشید.
                                                            </p>
                                                            <img src="assets/img/single-product/1431842.jpg" alt="">
                                                            <p>
                                                                فقط یک نکته‌ی مثبت در مورد Face ID وجود ندارد؛
                                                                بلکه موارد زیادی هستند که دانستن آن‌ها ضروری به
                                                                نظر می‌رسد. آیفون 10 فقط
                                                                چهره‌ی یک نفر را می‌شناسد و نمی‌توانید مثل
                                                                اثرانگشت، چند چهره را به آیفون معرفی کنید تا از
                                                                آن‌ها برای بازکردنش استفاده
                                                                کنید. اگر آیفون در تلاش اول، صورت شما را نشناسد،
                                                                باید نمایشگر را برای شناختن مجدد خاموش و روشن
                                                                کنید یا اینکه آن را پایین
                                                                ببرید و دوباره روبه‌روی صورتتان قرار دهید. این
                                                                تمام ماجرا نیست؛ اگر آیفون 10 بین افراد زیادی که
                                                                چهره‌شان را نمی‌شناسد
                                                                دست‌به‌دست شود، دیگر به شناخت چهره عکس‌العمل
                                                                نشان نمی‌دهد و حتما باید از پین یا پسوورد برای
                                                                بازکردن آن استفاده کنید تا
                                                                دوباره صورتتان را بشناسد.
                                                            </p>
                                                            <img src="assets/img/single-product/1439653.jpg" alt="">
                                                            <p>
                                                                اپل سعی کرده نهایت استفاده را از این فناوری جدید
                                                                بکند؛ استفاده از آن برای ثبت تصاویر پرتره با
                                                                دوربین سلفی، استفاده برای
                                                                ساختن شکلک‌های بامزه که آن‌ها را Animoji نامیده
                                                                است و همچنین استفاده برای روشن نگه‌داشتن گوشی
                                                                زمانی که کاربر به آن نگاه
                                                                می‌کند، مواردی هستند که iPhone X به کمک حسگر
                                                                اینفرارد، بدون نقص آن‌ها را انجام می‌دهد.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                نمایش‌گر (رنگی‌تر از همیشه)
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <img src="assets/img/single-product/1429172.jpg" alt="">
                                                            <p>
                                                                اولین تجربه‌ی استفاده از پنل‌های اولد سامسونگ
                                                                روی گوشی‌های اپل، نتیجه‌ای جذاب برای همه به
                                                                همراه آورده است. مهندسی
                                                                افزوده‌ی اپل روی این پنل‌ها باعث شده تا غلظت
                                                                رنگ‌ها کاملا متعادل باشد، نه مثل آیفون 8 کم باشد
                                                                و نه مثل گلکسی S8 اشباع
                                                                باشد تا از حد تعادل خارج شود. اپل این نمایشگر را
                                                                Super Retina نامیده تا ثابت کند، بهترین نمایشگر
                                                                موجود در دنیا را طراحی
                                                                کرده و از آن روی iPhone X استفاده کرده است.
                                                            </p>
                                                            <img src="assets/img/single-product/1436228.jpg" alt="">
                                                            <p>
                                                                این نمایشگر در مقایسه با پنل‌های معمولی، مصرف
                                                                انرژی کمتری دارد و این به خاطر استفاده از
                                                                پنل‌های اولد است؛ اما این مشخصه
                                                                باعث نشده تا نور نمایشگر مثل محصولات دیگری که
                                                                پنل اولد دارند کم باشد؛ بلکه این پنل در هر
                                                                شرایطی بهترین بازده‌ی ممکن را
                                                                دارد. استفاده زیر نور شدید خورشید یا تاریکی مطلق
                                                                فرقی ندارد، آیفون 10 خود را با شرایط تطبیق
                                                                می‌دهد. این تمام ماجرا نیست.
                                                                در نمایشگر آیفون 10 نقطه‌ی حساس به تراز سفیدی
                                                                نور محیط قرار داده ‌شده‌اند تا آیفون 10 را با
                                                                شرایط نوری محیطی که از آن
                                                                استفاده می‌کنید، هماهنگ کند و تراز سفیدی نمایشگر
                                                                را به‌صورت خودکار تغییر دهد. این فناوری که با
                                                                نام True-Tone نام‌گذاری
                                                                شده، کمک می‌کند رنگ‌های نمایشگر در هر نوری
                                                                نزدیک‌ترین غلظت و تراز سفیدی ممکن را به رنگ‌های
                                                                طبیعی داشته باشد.
                                                            </p>
                                                            <img src="assets/img/single-product/1406339.jpg" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                طراحی و ساخت (قربانی کردن سنت برای امروزی شدن)
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <img src="assets/img/single-product/1398679.jpg" alt="">
                                                            <p>
                                                                اپل پا جای پای سامسونگ گذاشته و برای داشتن ظاهری
                                                                امروزی و استفاده از جدیدترین فناوری‌های روز، سنت
                                                                ده‌ساله‌ی طراحی
                                                                گوشی‌هایش را شکسته است. دیگر کلید خانه‌ای وجود
                                                                ندارد و تمام قاب جلویی را نمایشگر پر کرده است.
                                                                حتی نمایشگر هم برای
                                                                استفاده از فناوری تشخیص چهره قربانی شده و قسمت
                                                                بالایی آن بریده ‌شده است و لبه‌ی بالایی آن در
                                                                مقایسه با هر گوشی دیگری که
                                                                تا به امروز دیده بودیم، حالت متفاوتی دارد. ابعاد
                                                                iPhone X کمی بزرگ‌تر از ابعاد آیفون 6 است؛ اما
                                                                نمایشگرش حدود یک اینچ
                                                                بزرگ‌تر از آیفون 6 است. این نشان می‌دهد، فاصله‌ی
                                                                لبه‌ها تا نمایشگر تا جای ممکن از طراحی جدیدترین
                                                                آیفون اپل حذف‌ شده‌
                                                                است.
                                                            </p>
                                                            <img src="assets/img/single-product/1441226.jpg" alt="">
                                                            <p>
                                                                زبان طراحی جدید، آیفون 10 را به‌طور عجیبی به سمت
                                                                تبدیل‌شدنش به یک کالای لوکس پیش برده است. نگاه
                                                                کلی به طراحی این گوشی
                                                                نشان می‌دهد، اپل سنت‌شکنی کرده و کالایی تولید
                                                                کرده تا از هر نظر با نسخه‌های قبلی آیفون متفاوت
                                                                باشد. استفاده از شیشه برای
                                                                قاب پشتی، فلزی براق برای قاب اصلی، حذف کلید خانه
                                                                و در انتها استفاده از نمایشگری بزرگ مواردی هستند
                                                                که نشان‌دهنده‌ی تفاوت
                                                                iPhone X با نسخه‌های قبلی آیفون است. تمام سطوح
                                                                آیفون براق و صیقلی طراحی ‌شده‌اند و تنها برآمدگی
                                                                آیفون جدید مربوط به
                                                                مجموعه‌ی دوربین آن می‌شود که حدود یک میلی‌متری
                                                                از قاب پشتی بیرون زده است. برخلاف آیفون 8پلاس،
                                                                دوربین‌های روی قاب پشتی به
                                                                حالت عمودی روی قاب پشتی قرار گرفته‌اند.
                                                            </p>
                                                            <img src="assets/img/single-product/1418947.jpg" alt="">
                                                            <p>
                                                                آیفون جدید در دو رنگ خاکستری و نقره‌ای راهی
                                                                بازار شده که در هر دو مدل قاب جلویی به رنگ مشکی
                                                                است و این بابت استفاده از
                                                                سنسورهای متعدد در بخش بالایی نمایشگر است. برخلاف
                                                                تمام آیفون‌های فلزی که تا امروز ساخته‌ شده‌اند،
                                                                قاب اصلی از فلزی براق
                                                                ساخته ‌شده تا زیر نور خودنمایی کند.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </article>
                                    </div>
                                    <div class="tab-pane params" id="params" role="tabpanel" aria-expanded="false">
                                        <article>
                                            <h2 class="param-title">
                                                مشخصات فنی
                                                <span>{{ $product->title }}</span>
                                            </h2>
                                            <section>
                                                <h3 class="params-title">مشخصات محصول</h3>
                                                <ul class="params-list">
                                                    @foreach($product->attributes as $attribute)
                                                        <li>
                                                            <div class="params-list-key">
                                                                <span class="block">{{ $attribute->name }}</span>
                                                            </div>
                                                            <div class="params-list-value">
                                                                <span class="block">
                                                                    @php
                                                                        $valueId = $attribute->pivot->value_id ?? null;
                                                                        $attrValue = $attribute->values->where('id', $valueId)->first();
                                                                    @endphp
                                                                    {{ $attrValue ? $attrValue->value : '' }}
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </section>
                                        </article>
                                    </div>
                                    <div class="tab-pane" id="comments" role="tabpanel" aria-expanded="false">
                                        <article>
                                            <h2 class="param-title">
                                                نظرات کاربران
                                                <span>{{ $comments->count() }} نظر</span>
                                            </h2>
                                            <div class="comments-area default">
                                                <ol class="comment-list">
                                                    @foreach ($comments->where('parent_id', 0) as $comment)
                                                        @include('components.comment-item', ['comment' => $comment, 'product' => $product, 'level' => 0])
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="tab-pane form-comment" id="questions" role="tabpanel" aria-expanded="false">
                                        <article>
                                            <h2 class="param-title">
                                                افزودن نظر
                                                <span>نظر خود را در مورد محصول مطرح نمایید</span>
                                            </h2>
                                            <form action="{{route('send.comment')}}" class="comment" method="POST">
                                                @csrf
                                                <input type="hidden" name="commentable_id" value="{{$product->id}}">
                                                <input type="hidden" name="commentable_type" value="{{get_class($product)}}">
                                                <input type="hidden" name="parent_id" value="0">
                                                <textarea class="form-control" placeholder="نظر" rows="5" name="text"></textarea>
                                                <button class="btn btn-default" type="submit">ارسال نظر</button>
                                            </form>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- main -->
<style>
    .color-circle {
        display: inline-block;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #ccc;
        vertical-align: middle;
        margin-left: 5px;
        transition: border 0.2s;
    }
</style>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const basePrice = {{ $basePrice }};
            let colorIncrease = 0;
            let guaranteeIncrease = 0;
            function updatePrice() {
                const finalPrice = basePrice + Number(colorIncrease) + Number(guaranteeIncrease);
                document.getElementById('final-price').innerText = finalPrice.toLocaleString();
                document.getElementById('final-price-input').value = finalPrice;
            }
            // انتخاب رنگ با لیبل و input hidden
            document.querySelectorAll('#color-select-group .color-circle').forEach(function(label) {
                label.addEventListener('click', function() {
                    document.querySelectorAll('#color-select-group .color-circle').forEach(function(l) {
                        l.style.border = '2px solid #ccc';
                    });
                    this.style.border = '2px solid #007bff';
                    document.getElementById('selected-color-id').value = this.getAttribute('data-color-id');
                    document.getElementById('color-id-input').value = this.getAttribute('data-color-id');
                    colorIncrease = this.getAttribute('data-price-increase') || 0;
                    updatePrice();
                });
            });
            // اگر قبلاً رنگی انتخاب شده بود (مثلاً با old)، آن را فعال کن
            @if(old('color_id'))
                var selected = document.querySelector('#color-select-group .color-circle[data-color-id="{{ old('color_id') }}"]');
                if(selected) {
                    selected.style.border = '2px solid #007bff';
                    document.getElementById('selected-color-id').value = selected.getAttribute('data-color-id');
                    document.getElementById('color-id-input').value = selected.getAttribute('data-color-id');
                    colorIncrease = selected.getAttribute('data-price-increase') || 0;
                    updatePrice();
                }
            @endif
            // گارانتی (استایل پیش‌فرض)
            document.querySelectorAll('input[name="guarantee_id"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    guaranteeIncrease = this.dataset.priceIncrease || 0;
                    document.getElementById('guarantee-id-input').value = this.value;
                    updatePrice();
                });
            });
            // اگر گارانتی انتخاب شده بود، قیمت را آپدیت کن
            const checkedGuarantee = document.querySelector('input[name="guarantee_id"]:checked');
            if(checkedGuarantee) {
                guaranteeIncrease = checkedGuarantee.dataset.priceIncrease || 0;
                updatePrice();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var addToCartForm = document.getElementById('add-to-cart-form');
            if(addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(addToCartForm);
                    axios.post(addToCartForm.action, formData)
                        .then(function(response) {
                            swal('موفقیت', 'محصول با موفقیت به سبد خرید شما اضافه شد', 'success');
                            // بروزرسانی سبد خرید کوچک هدر فقط با route جدید
                            axios.get('/cart-header-partial').then(function(res){
                                var cartDropdown = document.querySelector('.cart.dropdown .dropdown-menu');
                                if(cartDropdown) {
                                    cartDropdown.innerHTML = res.data;
                                }
                            });
                        })
                        .catch(function(error) {
                            swal('خطا', 'خطا در افزودن محصول به سبد خرید', 'error');
                        });
                });
            }
        });
    </script>
@endsection