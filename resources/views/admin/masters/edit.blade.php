@extends('admin.layouts.main')
@section('main')
<div id="main-content">
    <section class="wrapper">
     <div class="row">
        <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
            فرم ویرایش استاد
         
            </header>
            <div class="panel-body">
                <form role="form"  action="{{route('masters.update',$master->id)}}"  method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام استاد:</label>
                        <input type="text" class="form-control @error('name') is-invalid' @enderror" id="exampleInputEmail1" placeholder="نام استاد را وارد نمایید" name="name" value="{{$master->name}}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">سابقه ی تدریس:</label>
                        <input type="text" class="form-control @error('antecedent') is-invalid' @enderror" id="exampleInputPassword1" placeholder="سابقه ی تدریس را وارد نمایید" name="antecedent" value="{{$master->antecedent}}">

                        @error('antecedent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">رشته ی تدریس :</label>
                        <input type="text" class="form-control @error('field') is-invalid' @enderror" id="exampleInputPassword1" placeholder="رشته ی تدریس را وارد نمایید"name="field" value="{{$master->field}}">

                        @error('field')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group" style="display: flex">
                        <input type="text" id="image_label" class="form-control" name="image"
                               aria-label="Image" aria-describedby="button-image" value="{{$master->image}}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب</button>
                        </div>
                    </div>
                    
                   
                    <button type="submit" class="btn btn-info" name="addmaster">ویرایش</button>
                    <a href="{{route('masters.index')}}" class="btn btn-default">حذف</a>
                </form>

            </div>
        </section>
    </div>
  </div>  
    </section>
</div>
@endsection
