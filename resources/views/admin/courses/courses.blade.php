@extends('admin.layouts.main')
@section('main')

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           لیست دوره ها

                           <a href="{{route('courses.create')}}" class="btn btn-danger" style="margin-right:5px">ایجاد دوره</a>
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام دوره</th>
                                    <th>استاد</th>
                                    <th>مدت دوره</th>
                                    <th>توضیحات</th>
                                    <th>عکس</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($courses as $course)
    
                                <tr>
                                    
                                    <td>{{$course->id}}</td>
                                    <td>{{$course->course}}</td>
                                    <td>{{$course->master}}</td>
                                    <td>{{$course->time}}</td>
                                    <td>{!!$course->description!!}</td>
                                    
 
                                    <td>
                                    <img src="{{$course->image}}" width="50px" height="50px">
                                    </td>
 
                                     <td>
                                        <a href="{{route('courses.edit', $course->id)}}" class="btn btn-success col-lg-3" style="margin-left:5px">ویرایش</a>

                                            <form method="POST" action="{{route('courses.destroy',$course->id)}}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger col-lg-3">حذف</a>
                                            </form>
                                        
                                    </td>
                                 </tr>
                                @endforeach
                                

                            </tbody>
                        </table>
                    </section>

                    <div class="text-center">
                        {{$courses->render()}}
                    </div>
                </div>
            </div>
          </section>
      </section>
      <!--main content end-->
@endsection