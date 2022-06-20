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
                        تقویم آموزشی
                     
                        </header>
                        <div class="panel-body">
                            <form role="form" method="post" action="managecalendar.php"  enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">نام دوره :</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder=" نام دوره را وارد نمایید " name="course-name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">نام استاد:</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="نام استاد را وارد نمایید"  name="teacher-name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">مدت :</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder=" مدت دوره را وارد نمایید"  name="time">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">ظرفیت :</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ظرفیت را وارد نمایید"  name="capacity">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">مبلغ :</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="مبلغ را وارد نمایید"  name="tuition">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">تاریخ شروع:</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="تاریخ شروع را وارد نمایید"  name="start-time">
                                </div>
                               
                                <button type="submit" class="btn btn-info" name="add-course">ثبت</button>
                            </form>

                        </div>
                    </section>

                    

                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           تقویم آموزشی
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام دوره</th>
                                    <th>نام استاد</th>
                                    <th>مدت</th>
                                    <th>ظرفیت</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ شروع</th>
                                </tr>
                                </thead>
                                <tbody>
                               

                           <tr>
        
                           <td><?php echo $row["id"]; ?></td>
                           <td><?php echo $row["coursename"]; ?></td>
                           <td><?php echo $row["teachername"]; ?></td>
                           <td><?php echo $row["time"]; ?></td>
                           <td><?php echo $row["capacity"]; ?></td>
                           <td><?php echo $row["tuition"]; ?></td>
                           <td><?php echo $row["starttime"]; ?></td>
                        
                          <td>
                          <a href= "managecalendar.php?edit=<?php echo $row['id']; ?>" name="edit-calendar" class="btn btn-success">ویرایش</a>
                          <a href="managecalendar.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">حذف</a>
                          </td>
                          </tr>
                          <?php } ?>
                                
                               
                            </tbody>
                       
                        </table>
                </div>
            </div>

           

    <div class=" col-lg-12 content">
         <div class="col-lg-12  banner">
            <p>فرم ویرایش</p>
            <br>
          </div>
          <div class=" col-lg-6  boxform">
               <form method="post" action="managecalendar.php" enctype="multipart/form-data" >
                <input type="hidden" value="<?php echo $calendarInfo['id'] ?>" name="id">
                 <div class="form-group">
                      <label>نام دوره:</label>
                      <input type="text" name="course-name" class="form-control" value="<?php echo $calendarInfo['coursename'] ?>">
                 </div>
                 <div class="form-group">
                      <label>نام استاد:</label>
                      <input type="text" name="teacher-name" class="form-control" value="<?php echo $calendarInfo['teachername'] ?>">
                 </div>
                 <div class="form-group">
                      <label>مدت:</label>
                      <input type="text" name="time" class="form-control" value="<?php echo $calendarInfo['time'] ?>">
                 </div>
                 <div class="form-group">
                      <label>ظرفیت:</label>
                      <input type="text" name="capacity" class="form-control" value="<?php echo $calendarInfo['capacity'] ?>">
                 </div>
                 <div class="form-group">
                      <label>مبلغ:</label>
                      <input type="text" name="tuition" class="form-control" value="<?php echo $calendarInfo['tuition'] ?>">
                 </div>
                 <div class="form-group">
                      <label>تاریخ شروع:</label>
                      <input type="text" name="start-time" class="form-control" value="<?php echo $calendarInfo['starttime'] ?>">
                 </div>

                 <div class="form-group">
                   <center><button class="btn btn-success" name="edit-calendar" type="submit">ویرایش</button></center> 
                 </div>
               </form>
          </div>
     </div>



                     
            
          </section>
      </section>
      <!--main content end-->
@endsection