@extends('admin.layouts.main')
@section('main')
<div id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                    فرم ثبت اسلایدر جدید
                 
                    </header>
                    <div class="panel-body">
                        <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                             @csrf
                            <div class="form-group">
                                <label for="exampleInputPassword1">متن اسلایدر</label>
                                <input type="text" class="form-control @error('description') is-inalid' @enderror" id="exampleInputPassword1" placeholder="متن اسلایدر را وارد نمایید" name="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group" style="display: flex">
                                <input type="text" id="image_label" class="form-control" name="image"
                                       aria-label="Image" aria-describedby="button-image">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب</button>
                                </div>
                            </div>
                            
                           
                            <button type="submit" class="btn btn-info" name="addCourse">ثبت</button>
                            <a href="{{route('sliders.index')}}" class="btn btn-default">لغو</a>
                        </form>
                    </div>
                </section>
            </div>
          </div> 
    </section>
</div>

@endsection

 