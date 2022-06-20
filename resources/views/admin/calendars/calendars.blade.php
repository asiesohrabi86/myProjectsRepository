@extends('admin.layouts.main')
@section('main')

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           تقویم آموزشی

                           <a href="{{route('calendars.create')}}" class="btn btn-danger" style="margin-right:5px">ایجاد دوره</a>
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>دوره</th>
                                    <th>استاد</th>
                                    <th>مدت</th>
                                    <th>ظرفیت</th>
                                    <th>مبلغ</th>
                                    <th>تاریخ شروع</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($calendars as $calendar)
    
                                <tr>
                                    
                                    <td>{{$calendar->id}}</td>
                                    <td>{{$calendar->course}}</td>
                                    <td>{{$calendar->teacher}}</td>
                                    <td>{{$calendar->time}}</td>
                                    <td>{{$calendar->capacity}}</td>
                                    <td>{{$calendar->cost}}</td>
                                    <td>{{$calendar->startingtime}}</td>
 
                                     <td>
                                        <a href="{{route('calendars.edit', $calendar->id)}}" class="btn btn-success col-lg-4" style="margin-left:5px">ویرایش</a>

                                            <form method="POST" action="{{route('calendars.destroy',$calendar->id)}}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger col-lg-4">حذف</a>
                                            </form>
                                        
                                    </td>
                                 </tr>
                                @endforeach
                                

                            </tbody>
                        </table>
                    </section>

                    <div class="text-center">
                        {{$calendars->render()}}
                    </div>
                </div>
            </div>
          </section>
      </section>
      <!--main content end-->
@endsection