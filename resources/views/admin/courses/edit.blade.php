@extends('admin.layouts.main')
@section('main')
<div id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                    فرم ویرایش دوره
                 
                    </header>
                    <div class="panel-body">
                        <form action="{{route('courses.update',$course->id)}}" method="post" enctype="multipart/form-data">
                             @csrf
                             @method('put')
                            <div class="form-group">
                                <label for="exampleInputEmail1">نام دوره:</label>
                                <input type="text" class="form-control @error('course') is-inalid' @enderror" id="exampleInputEmail1" placeholder="نام دوره را وارد نمایید" name="course" value="{{$course->course}}">

                                @error('course')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">نام استاد:</label>
                                <input type="text" class="form-control @error('master') is-inalid' @enderror" id="exampleInputPassword1" placeholder="نام استاد را وارد نمایید" name="master" value="{{$course->master}}">

                                @error('master')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">مدت دوره :</label>
                                <input type="text" class="form-control @error('time') is-inalid' @enderror" id="exampleInputPassword1" placeholder="مدت دوره  را وارد نمایید" name="time" value="{{$course->time}}">

                                @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">توضیحات:</label>
                                <textarea class="form-control @error('description') is-inalid' @enderror" name="description" value="{{$course->description}}" id="editor-id"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group" style="display: flex">
                                <input type="text" id="image_label" class="form-control" name="image"
                                       aria-label="Image" aria-describedby="button-image" value="{{$course->image}}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب</button>
                                </div>
                            </div>
                            
                           
                            <button type="submit" class="btn btn-info" name="addCourse">ویرایش</button>
                        </form>
        
                    </div>
                </section>
            </div>
          </div> 
    </section>
</div>

@endsection

 