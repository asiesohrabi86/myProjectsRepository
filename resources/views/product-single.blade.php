@extends('layouts.master')
@section('title','')
@section('content')
    <!-- main -->
    <main class="single-product default">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#"><span>فروشگاه اینترنتی تاپ کالا</span></a>
                        </li>
                        <li>
                            <a href="#"><span>کالای دیجیتال</span></a>
                        </li>
                        <li>
                            <a href="#"><span>موبایل</span></a>
                        </li>
                        <li>
                            <a href="#"><span>گوشی موبایل</span></a>
                        </li>
                        <li>
                            <span>گوشی موبایل اپل مدل iPhone X ظرفیت 256 گیگابایت</span>
                        </li>
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
                                <img class="zoom-img" id="img-product-zoom" src="assets/img/product/1335154.jpg" data-zoom-image="assets/img/product/13351544.jpg" width="411" />

                                <div id="gallery_01f" style="width:500px;float:left;">
                                    <ul class="gallery-items">
                                        <li>
                                            <a href="#" class="elevatezoom-gallery active" data-update="" data-image="assets/img/product/2114766.jpg" data-zoom-image="assets/img/product/2114766.jpg">
                                                <img src="/img/product/2114766.jpg" width="100" /></a>
                                        </li>
                                        <li>
                                            <a href="#" class="elevatezoom-gallery" data-image="/img/product/3694075.jpg" data-zoom-image="/img/product/3694075.jpg"><img src="/img/product/3694075.jpg" width="100" /></a>
                                        </li>
                                        <li>
                                            <a href="tester" class="elevatezoom-gallery" data-image="assets/img/product/1335154.jpg" data-zoom-image="assets/img/product/1335154.jpg">
                                                <img src="/img/product/1335154.jpg" width="100" />
                                            </a>
                                        </li>
                                        <li>
                                            <a href="tester" class="elevatezoom-gallery" data-image="assets/img/product/110197298.jpg" data-zoom-image="assets/img/product/110197298.jpg" class="slide-content"><img src="/img/product/110197298.jpg" height="68" /></a>
                                        </li>
                                    </ul>
                                </div>
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
                                <h1>
                                 {{$product->title}}
                            </div>
                            <div class="product-directory default">
                                <ul>
                                    <li>
                                        <span>برند</span> :
                                        <span class="product-brand-title">متفرقه</span>
                                    </li>
                                    <li>
                                        <span>دسته‌بندی</span> :
                                        <a href="#" class="btn-link-border">
                                            ساعت هوشمند
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-variants default">
                                <span>انتخاب رنگ: </span>
                                <div class="radio">
                                    <input type="radio" name="radio1" id="radio1" value="option1">
                                    <label for="radio1">
                                        خاکستری
                                    </label>
                                </div>

                                <div class="radio">
                                    <input type="radio" name="radio1" id="radio2" value="option2" checked="">
                                    <label for="radio2">
                                        نقره ای
                                    </label>
                                </div>

                            </div>
                            <div class="product-guarantee default">
                                <i class="fa fa-check-circle"></i>
                                <p class="product-guarantee-text">گارانتی اصالت و سلامت فیزیکی کالا</p>
                            </div>
                            <div class="product-delivery-seller default">
                                <p>
                                    <i class="now-ui-icons shopping_shop"></i>
                                    <span>فروشنده:‌</span>
                                    <a href="#" class="btn-link-border">ناسا</a>
                                </p>
                            </div>
                            <div class="price-product defualt">
                                <div class="price-value">
                                    <span>{{$product->price}}</span>
                                    <span class="price-currency">تومان</span>
                                </div>
                                <div class="price-discount" data-title="تخفیف">
                                    <span>
                                        ۰
                                    </span>
                                    <span>%</span>
                                </div>
                            </div>
                            <div class="product-add default">
                                <div class="parent-btn">
                                    <a href="#" class="dk-btn dk-btn-info">
                                        افزودن به سبد خرید
                                        <i class="now-ui-icons shopping_cart-simple"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 center-breakpoint">
                            <div class="product-guaranteed default">
                                بیش از ۱۸۰ نفر از خریداران این محصول را پیشنهاد داده‌اند
                            </div>
                            <div class="product-params default">
                                <ul data-title="ویژگی‌های محصول">
                                    <li>
                                        <span>حافظه داخلی: </span>
                                        <span> 256 گیگابایت </span>
                                    </li>
                                    <li>
                                        <span>شبکه های ارتباطی: </span>
                                        <span> 2G,3G,4G </span>
                                    </li>
                                    <li>
                                        <span>رزولوشن عکس: </span>
                                        <span> 12.0 مگاپیکسل</span>
                                    </li>
                                    <li>
                                        <span>تعداد سیم کارت: </span>
                                        <span> تک </span>
                                    </li>
                                    <li>
                                        <span>ویژگی‌های خاص: </span>
                                        <span> مقاوم در برابر آب
                                            مناسب عکاسی
                                            مناسب عکاسی سلفی
                                            مناسب بازی
                                            مجهز به حس‌گر تشخیص چهره
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="container">
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
                                                <span>گوشی موبایل اپل مدل iPhone X ظرفیت 256 گیگابایت</span>
                                            </h2>
                                            <div class="parent-expert default">
                                                <div class="content-expert">
                                                    <p>
                                                        {{$product->text}}
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
                                                <span>Apple iPhone X 256GB Mobile Phone</span>
                                            </h2>
                                            <section>
                                                <h3 class="params-title">مشخصات کلی</h3>
                                                <ul class="params-list">
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">ابعاد</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                7.7 × 70.9 × 143.6 میلی‌متر
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">توضیحات سیم کارت</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                سایز نانو (8.8 × 12.3 میلی‌متر)
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">وزن</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                174 گرم
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">ویژگی‌های خاص</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                مقاوم در برابر آب , مناسب عکاسی , مناسب عکاسی
                                                                سلفی , مناسب بازی , مجهز به حس‌گر تشخیص چهره
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">تعداد سیم کارت</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                تک سیم کارت
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </section>
                                            <section>
                                                <h3 class="params-title">پردازنده</h3>
                                                <ul class="params-list">
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">تراشه</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                Apple A11 Bionic Chipset
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="params-list-key">
                                                            <span class="block">نوع پردازنده</span>
                                                        </div>
                                                        <div class="params-list-value">
                                                            <span class="block">
                                                                64 بیت
                                                            </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </section>
                                        </article>
                                    </div>
                                    <div class="tab-pane" id="comments" role="tabpanel" aria-expanded="false">
                                        <article>
                                            <h2 class="param-title">
                                                نظرات کاربران
                                                <span>۱۲۳ نظر</span>
                                            </h2>
                                            <div class="comments-area default">
                                                <ol class="comment-list">
                                                   @foreach ($comments as $comment)
                                                      <!-- #comment-## -->
                                                    <li>
                                                        <div class="comment-body">
                                                            <div class="comment-author">
                                                                <img alt="" src="/assets/img/default-avatar.png" class="avatar"><cite class="fn">{{$comment->user->name}}</cite>
                                                                <span class="says">گفت:</span> </div>

                                                            <div class="commentmetadata">
                                                                    {{$comment->created_at}} </div>

                                                            <p>{{$comment->text}}</p>

                                                            <div class="reply"><a class="comment-reply-link" href="#">پاسخ</a></div>
                                                        </div>
                                                    </li>  
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

@endsection