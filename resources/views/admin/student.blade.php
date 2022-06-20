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
                            <h1>22</h1>
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
                            <h1>140</h1>
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
                              <h1>34,500</h1>
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
                        فرم ثبت دوره جدید
                     
                        </header>
                        <div class="panel-body">
                            <form role="form">
                                <div class="form-group" method ="post" action = "managestudent" enctype="multipart/form-data">
                                    <label for="exampleInputEmail1">نام دانشجو:</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="نام دانشجو را وارد نمایید" name="student-name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">رشته :</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="رشته  را وارد نمایید" name="field">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">نمره :</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="نمره  را وارد نمایید"
                                    name="score">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">آپلود عکس:</label>
                                    <input type="file" id="exampleInputFile" name="image">
                                   
                                </div>
                                
                               
                                <button type="submit" class="btn btn-info" name="addstudent">ثبت</button>
                            </form>

                        </div>
                    </section>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            لیست دانشجویان
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام دانشجو</th>
                                    <th>رشته</th>
                                    <th>نمره</th>
                                    <th>عکس</th>
                                    <th>عملیات</th>
                                </tr>

                                <tr>
                                    
                                    <td>1</td>
                                    <td>mn</td>
                                    <td>html</td>
                                    <td>70</td>
                                    <td><a href="img/avatar1_small.jpg" target="blank"><img src="img/avatar1_small.jpg" width="50px" height="50px"></a>></a></td>
                                    <td>
                                        <button class="btn btn-success">ویرایش</button>
                                        <button class="btn btn-danger">حذف</button>
                                    </td>
                                 </tr>

                                 <tr>
                                    
                                    <td>2</td>
                                    <td>prhm</td>
                                    <td>html</td>
                                    <td>10</td>
                                    <td><a href="img/avatar1_small.jpg" target="blank"><img src="img/avatar1_small.jpg" width="50px" height="50px"></a>></a></td>
                                    <td>
                                        <button class="btn btn-success">ویرایش</button>
                                        <button class="btn btn-danger">حذف</button>
                                    </td>
                                 </tr>

                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            
          </section>
      </section>
      <!--main content end-->
 
@endsection
    