@extends('admin.layouts.main')
@section('main')

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          
              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           لیست اسلایددر ها

                           <a href="{{route('sliders.create')}}" class="btn btn-danger" style="margin-right:5px"> ایجاد اسلایدر</a>
                     
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>متن اسلایدر</th>
                                    <th>عکس</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($sliders as $slider)
    
                                <tr>
                                    
                                    <td>{{$slider->id}}</td>
                                    <td>{{$slider->description}}</td>
                                   
                                    <td>
                                    <img src="{{$slider->image}}" width="50px" height="50px">
                                    </td>
 
                                     <td>
                                        <a href="{{route('sliders.edit', $slider->id)}}" class="btn btn-success col-lg-3" style="margin-left:5px">ویرایش</a>

                                            <form method="POST" action="{{route('sliders.destroy',$slider->id)}}">
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
                        {{$sliders->render()}}
                    </div>
                </div>
            </div>
          </section>
      </section>
      <!--main content end-->
@endsection