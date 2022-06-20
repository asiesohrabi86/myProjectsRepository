@extends('layouts.app')

@section('content')
   
   <div class="col-lg-12 content">
      <br>
      <center>
        <div class="col-lg-8 p-2 m-auto" style="background-color: #dadada; border-radius:10px">
        <p>نقشه</p>
        <hr class="col-lg-8 m-auto" style="border-color: rgb(2, 2, 65)">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3204.7388277244786!2d53.063965885367075!3d36.56040978886176!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f853fe5d9df12c3%3A0x4f7144c2cf8340c2!2z2K3Ys9uM2YbbjNmHINmF24zYsdiz2LHYsdmI2LbZhw!5e0!3m2!1sfa!2s!4v1654859176888!5m2!1sfa!2s" width="800" height="330" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="mt-2"></iframe>
        </div>
      </center> 
      
      <div class="row">
        <div class="text-center col-lg-4 offset-lg-1 ">
           <div  class="box shadow ">
            <p class="pt-1">تماس با ما</p>
            <hr class=" offset-lg-2 col-lg-8 offset-lg-2 ">
            <p>ساری-خیابان فرهنگ-فرهنگ 8</p>
           
            <div class="row offset-lg-2">
             <div class="col-lg-6 tel">
               <div class="row container">
                <i class="fa fa-phone pl-2" aria-hidden="true" style="font-size: x-large"></i> 
                <span class="">تلفن</span>
               </div>
                
             </div>
              <div class="col-lg-6 fax">
                <div class="row">
                  <i class="fa fa-fax pl-2" aria-hidden="true" style="font-size: x-large"></i>
                <span>فکس</span>
                </div>
              </div>
            </div>
          </div>
            </div>
         

        <div class="offset-lg-1 col-lg-5 mt-2 w-60">
            <div class="shadow" style="background-color: #dadada">
              <p class="text-center pt-3">فرم تماس با آموزشگاه </p>
              <hr class=" offset-lg-2 col-lg-8 offset-lg-2 ">
              <form class="p-2" method="post" action="{{route('postForm')}}">
                @csrf
                <div class="form-group">
                    <label>نام فرستنده</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                  <label>ایمیل</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                  @enderror
               </div>
               <div class="form-group">
                <label>تلفن</label>
                <input type="text" name="tel" class="form-control @error('tel') is-invalid @enderror">
                @error('tel')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label>عنوان</label>
                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror">
                @error('subject')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label>شرح</label>
                <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                @enderror
             </div>
             <center><button  class="btn btn-success" type="submit"> ارسال</button></center>
             </form>
            </div>
        </div>
    </div>
       

      
  </div>   
          
   @endsection