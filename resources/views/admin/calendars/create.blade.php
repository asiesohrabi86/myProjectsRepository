@extends('admin.layouts.main')
@section('main')
<div id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                    فرم ثبت دوره جدید
                 
                    </header>
                    <div class="panel-body">
                        <form action="{{route('calendars.store')}}" method="post" enctype="multipart/form-data">
                             @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">نام دوره:</label>
                                <input type="text" class="form-control @error('course') is-inalid' @enderror" id="exampleInputEmail1" placeholder="نام دوره را وارد نمایید" name="course">

                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">نام استاد:</label>
                                <input type="text" class="form-control @error('teacher') is-inalid' @enderror" id="exampleInputPassword1" placeholder="نام استاد را وارد نمایید" name="teacher">

                                @error('teacher')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">مدت دوره :</label>
                                <input type="text" class="form-control @error('time') is-inalid' @enderror" id="exampleInputPassword1" placeholder="مدت دوره  را وارد نمایید" name="time">

                                @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">ظرفیت :</label>
                                <input type="text" class="form-control @error('capacity') is-inalid' @enderror" id="exampleInputPassword1" placeholder="" name="capacity">

                                @error('capacity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">مبلغ :</label>
                                <input type="text" class="form-control @error('cost') is-inalid' @enderror" id="exampleInputPassword1" placeholder="" name="cost">

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">تاریخ شروع :</label>
                                <input type="text" class="form-control @error('startingtime') is-inalid' @enderror" id="exampleInputPassword1" placeholder="" name="startingtime">

                                @error('startingtime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                           
                            <button type="submit" class="btn btn-info" name="addcalendar">ثبت</button>
                        </form>
                    </div>
                </section>
            </div>
          </div> 
    </section>
</div>

@endsection

 