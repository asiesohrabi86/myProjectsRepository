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
                        فرم ثبت اسلاید جدید
                     
                        </header>
                        <div class="panel-body">
                            <form role="form" method="post" action="manageslider.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">متن اسلایدر :</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" name="slidertext" placeholder="متن اسلایدر  را وارد نمایید">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">آپلود عکس:</label>
                                    <input type="file" id="exampleInputFile" name="image">
                                   
                                </div>
                                
                               
                                <button type="submit" class="btn btn-info" name="addslider">ثبت</button>
                            </form>

                        </div>
                    </section>

         

                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           لیست اسلایدها
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>متن اسلاید</th>
                                    <th>عکس</th>
                                </tr>
                                </thead>
                                <tbody>
                              

                           <tr>
        
                           <td><?php echo $row["id"]; ?></td>
                           <td><?php echo $row["slidertext"]; ?></td>
                           <td>
                           <img src="../upload/<?php echo $row['image']; ?>" width="50px" height="50px">
                           </td>

                          <td>
                          <a href= "manageslider.php?edit=<?php echo $row['id']; ?>" name="edit-slider" class="btn btn-success">ویرایش</a>
                          <a href="manageslider.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">حذف</a>
                          </td>
                          </tr>
                          
                                
                               
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
               <form method="post" action="manageslider.php" enctype="multipart/form-data" >
                <input type="hidden" value="<?php echo $sliderInfo['id'] ?>" name="id">
                 <div class="form-group">
                      <label>متن اسلاید:</label>
                      <input type="text" name="slide-text" class="form-control" value="<?php echo $sliderInfo['slidertext'] ?>">
                 </div>
   
        <div class="form-group">
             <label>عکس:</label>
             <input type="file" name="new-image">
             <input type="hidden" name="image" value ="<?php echo $sliderInfo['image'] ?> ">
        </div>

                 <div class="form-group">
                   <center><button class="btn btn-success" name="edit-slider" type="submit">ویرایش</button></center> 
                 </div>
               </form>
          </div>
     </div>

 
         
          </section>
            
          </section>
      </section>
      <!--main content end-->
  </section>

@endsection
