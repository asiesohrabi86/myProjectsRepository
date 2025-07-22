<!-- Sidemenu Area -->
<div class="ecaps-sidemenu-area">
<!-- Desktop Logo -->
<div class="ecaps-logo">
    <a href="index.html"><img class="desktop-logo" src="/admin/img/core-img/logo.png" alt="لوگوی دسک تاپ"> <img class="small-logo" src="/admin/img/core-img/small-logo.png" alt="آرم موبایل"></a>
</div>

<!-- Side Nav -->
<div class="ecaps-sidenav" id="ecapsSideNav">
    <!-- Side Menu Area -->
    <div class="side-menu-area">
        <!-- Sidebar Menu -->
        <nav>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="{{request()->is('dashboard') ? 'active' : ''}}"><a href="{{url('dashboard')}}"><i class="zmdi zmdi-view-dashboard"></i><span>داشبورد</span></a></li>
                @can('users')
                <li class="treeview @php if(request()->is('dashboard/users') || request()->is('dashboard/users/create')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت کاربران</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('users.index')}}" style="{{request()->is('dashboard/users') ? 'color:blue' : ''}}">لیست کاربران</a></li>
                        <li><a href="{{route('users.create')}}" style="{{request()->is('dashboard/users/create') ? 'color:blue' : ''}}">افزودن کاربر</a></li>
                    </ul>
                </li> 
                @endcan
                
                <li class="treeview @php if(request()->is('dashboard/products') || request()->is('dashboard/products/create')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت محصولات</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('products.index')}}" style="{{request()->is('dashboard/products') ? 'color:blue' : ''}}">لیست محصولات</a></li>
                        <li><a href="{{route('products.create')}}" style="{{request()->is('dashboard/products/create') ? 'color:blue' : ''}}">افزودن محصول</a></li>
                    </ul>
                </li>
                <li class="treeview @php if(request()->is('dashboard/categories') || request()->is('dashboard/categories/create')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت دسته بندی</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('categories.index')}}" style="{{request()->is('dashboard/categories') ? 'color:blue' : ''}}">لیست دسته بندی</a></li>
                        <li><a href="{{route('categories.create')}}" style="{{request()->is('dashboard/categories/create') ? 'color:blue' : ''}}">افزودن دسته بندی</a></li>
                    </ul>
                </li>
                <li class="treeview @php if(request()->is('dashboard/brands') || request()->is('dashboard/brands/create')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت برندها</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('brands.index')}}" style="{{request()->is('dashboard/brands') ? 'color:blue' : ''}}">لیست برندها</a></li>
                        <li><a href="{{route('brands.create')}}" style="{{request()->is('dashboard/brands/create') ? 'color:blue' : ''}}">افزودن برند</a></li>
                    </ul>
                </li>
                @can('comments')
                    <li class="treeview @php if(request()->is('dashboard/comments') || request()->is('dashboard/comments-unapproved')) {echo 'active';} @endphp ">
                        <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت نظرات</span> <i class="fa fa-angle-left"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('comments.index')}}" style="{{request()->is('dashboard/comments') ? 'color:blue' : ''}}">لیست نظرات</a></li>
                            <li><a href="{{route('unapproved.get')}}" style="{{request()->is('dashboard/comments-unapproved') ? 'color:blue' : ''}}">نظرات تاییدنشده</a></li>
                        </ul>
                    </li>
                @endcan


                @can('orders-all')
                    <li class="treeview @php if(request()->is('dashboard/orders')) {echo 'active';} @endphp ">
                        <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت سفارشات</span> <i class="fa fa-angle-left"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="{{route('orders.index')}}" style="{{request()->is('dashboard/orders') ? 'color:blue' : ''}}">لیست سفارشات</a></li>
                            
                        </ul>
                    </li>
                @endcan
                
                <li class="treeview @php if(request()->is('dashboard/attributes') || request()->is('dashboard/attributes/create')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>مدیریت ویژگی ها</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('attributes.index')}}" style="{{request()->is('dashboard/attributes') ? 'color:blue' : ''}}">لیست ویژگی ها</a></li>
                        <li><a href="{{route('unapproved.get')}}" style="{{request()->is('dashboard/attributes-unapproved') ? 'color:blue' : ''}}">ویژگی ها تاییدنشده</a></li>
                    </ul>
                </li> 
               
                @can('permissions')
                <li class="treeview @php if(request()->is('dashboard/permissions') || request()->is('dashboard/roles')) {echo 'active';} @endphp ">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-account"></i> <span>سطوح دسترسی</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('permissions.index')}}" style="{{request()->is('dashboard/permissions') ? 'color:blue' : ''}}">همه دسترسی ها</a></li>
                        <li><a href="{{route('roles.index')}}" style="{{request()->is('dashboard/roles') ? 'color:blue' : ''}}">همه نقش ها</a></li>
                        
                    </ul>
                </li>
                @endcan
                <li class="treeview">
                    <a href="javascript:void(0)"><i class="zmdi zmdi-email"></i> <span>پست الکترونیک</span> <i class="fa fa-angle-left"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="mail-inbox.html">صندوق ورودی</a></li>
                        <li><a href="mail-view.html">مشاهده ایمیل</a></li>
                        <li><a href="compose-mail.html">ارسال نامه ایمیل</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
</div>