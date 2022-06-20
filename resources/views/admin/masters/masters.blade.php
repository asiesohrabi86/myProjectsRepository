@extends('admin.layouts.main')
@section('main')

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
             
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                        لیست اساتید
                     <a href="{{route('masters.create')}}" class="btn btn-danger">ثبت استاد جدید</a>
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                               
                            </thead>
                            <tr>
                                    <th>#</th>
                                    <th>نام استاد</th>
                                    <th>سابقه تدریس</th>
                                    <th>رشته تدریس</th>
                                    <th>عکس</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                            
                            @foreach ($masters as $master)
                            <tr>
                                    
                                <td>{{$master->id}}</td>
                                  <td>{{$master->name}}</td>
                                  <td>{{$master->antecedent}}</td>
                                  <td>{{$master->field}}</td>
                                 <td>
                                  <img src="{{$master->image}}" width="50px" height="50px">
                                  </td>

                                   <td>
                                      <a href= "{{route('masters.edit',$master->id)}}" class="btn btn-success col-lg-3">ویرایش</a>
                                      <form action="{{route('masters.destroy',$master->id)}}" method="post" class="col-lg-3">
                                        @csrf
                                        @method('delete')
                                         <button type="submit" class="btn btn-danger">حذف</a>
                                      </form>
                                  </td>
                               </tr>   
                            @endforeach
    
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            
          
          </section>
      </section>


@endsection

    