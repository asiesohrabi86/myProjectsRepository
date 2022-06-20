@extends('admin.layouts.main')
@section('main')

    <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            لیست کاربران
                     <a href="{{route('users.create')}}" class="btn btn-danger ">ایجاد کاربر</a>
                        </header>
                        <table class="table table-striped border-top" id="sample_1">
                            <thead>
                                <tr>
                                    <th>ایدی کاربر</th>
                                    <th>نام کاربری</th>
                                    <th>ایمیل</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($users as $user)

                                    <tr>
                                    
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-success col-lg-3">ویرایش</a>

                                            <form method="POST" action="{{route('users.destroy',$user->id)}}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger col-lg-3" style="margin-right:5px">حذف</a>
                                            </form>
                                            
                                         </td>
                                    </tr>
                                @endforeach
                           
                               
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
 
            <div class="text-center">
                {{$users->render()}}
            </div>


          </section>
      </section>
      <!--main content end-->
     
@endsection
