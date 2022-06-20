@extends('admin.layouts.main')

@section('main')
   
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--state overview start-->
        <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol terques">
                        <i class="icon-user"></i>
                    </div>
                    <div class="value">
                        <h1>{{$user_count}}</h1>
                        <p>کاربر جدید</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red">
                        <i class="icon-tags"></i>
                    </div>
                    <div class="value">
                        <h1>{{$master_count}}</h1>
                        <p>اساتید</p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol yellow">
                        <i class="icon-shopping-cart"></i>
                    </div>
                    <div class="value">
                        <h1>345</h1>
                        <p>دانشجویان </p>
                    </div>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol blue">
                        <i class="icon-bar-chart"></i>
                    </div>
                    <div class="value">
                        <h1>{{$course_count}}</h1>
                        <p>دوره ها </p>
                    </div>
                </section>
            </div>
        </div>
        <!--state overview end-->

   <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">
                  لیست رمز

              </header>
              <table class="table table-striped border-top" id="sample_1">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>رمز عبور</th>
                          <th>عملیات</th>
                      </tr>
                  </thead>
                  <tbody>

                     

                  </tbody>

              </table>
          </section>
      </div>
  </div>
@endsection
      
       


   