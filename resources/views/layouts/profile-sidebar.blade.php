<div class="profile-box-username">
    {{ auth()->check() ? auth()->user()->name : 'کاربر مهمان' }}
</div>
<div class="profile-box-tabs d-flex justify-content-between">
    <a href="{{ route('profile.change-password') }}" class="profile-box-tab d-flex align-items-center profile-box-tab-access">
        <i class="now-ui-icons ui-1_lock-circle-open"></i>
        تغییر رمز
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link">خروج از حساب</button>
    </form>
</div>
</div>
<div class="responsive-profile-menu show-md">
<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-navicon"></i>
        حساب کاربری شما
    </button>
    <div class="dropdown-menu dropdown-menu-right text-right">
        <a href="profile.html" class="dropdown-item active-menu">
        <i class="now-ui-icons users_single-02"></i>
        پروفایل
        </a>
        <a href="{{route('profile.orders')}}" class="dropdown-item">
        <i class="now-ui-icons shopping_basket"></i>
        همه سفارش ها
        </a>
        <a href="profile-orders-return.html" class="dropdown-item">
        <i class="now-ui-icons files_single-copy-04"></i>
        درخواست مرجوعی
        </a>
        <a href="profile-favorites.html" class="dropdown-item">
        <i class="now-ui-icons ui-2_favourite-28"></i>
        لیست علاقمندی ها
        </a>
        <a href="profile-personal-info.html" class="dropdown-item">
        <i class="now-ui-icons business_badge"></i>
        اطلاعات شخصی
        </a>
    </div>
</div>
</div>
<div class="profile-menu hidden-md">
<div class="profile-menu-header">حساب کاربری شما</div>
<ul class="profile-menu-items">
    <li>
        <a href="{{route('profile')}}" {{request()->is('profile') ? 'class=active' : ''}}>
            <i class="now-ui-icons users_single-02"></i>
            پروفایل
        </a>
    </li>
    <li>
        <a href="{{route('profile.orders')}}">
            <i class="now-ui-icons shopping_basket"></i>
            همه سفارش ها
        </a>
    </li>
    <li>
        <a href="profile-orders-return.html">
            <i class="now-ui-icons files_single-copy-04"></i>
            درخواست مرجوعی
        </a>
    </li>
    <li>
        <a href="profile-favorites.html">
            <i class="now-ui-icons ui-2_favourite-28"></i>
            لیست علاقمندی ها
        </a>
    </li>
    <li>
        <a href="profile-personal-info.html">
            <i class="now-ui-icons business_badge"></i>
            اطلاعات شخصی
        </a>
    </li>
    <li>
        <a href="{{url('/profile/twofactor')}}" {{request()->is('profile/twofactor') ? 'class=active' : '' }}>
            <i class="now-ui-icons business_badge"></i>
            احراز هویت دومرحله ای
        </a>
    </li>
</ul>
</div>
