<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="img/favicon.html">

    <title>پنل مدیریتی</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/bootstrap-reset.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="{{asset('admin/assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{asset('admin/css/owl.carousel.css" type="text/css')}}">
    <!-- Custom styles for this template -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style-responsive.css')}}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="{{asset('admin/js/html5shiv.js')}}"></script>
      <script src="{{asset('admin/js/respond.min.js')}}"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="">

    @include('admin.layouts.navbar')

    
      
        @include('admin.layouts.sidebar')
      

      
        @yield('main')
      
    
    


     <!-- js placed at the end of the document so the pages load faster -->
   <script src="{{asset('admin/js/jquery.js')}}"></script>
   <script src="{{asset('admin/js/jquery-1.8.3.min.js')}}"></script>
   <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('admin/js/jquery.scrollTo.min.js')}}"></script>
   <script src="{{asset('admin/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
   <script src="{{asset('admin/js/jquery.sparkline.js')}}" type="text/javascript"></script>
   <script src="{{asset('admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
   <script src="{{asset('admin/js/owl.carousel.js')}}" ></script>
   <script src="{{asset('admin/js/jquery.customSelect.min.js')}}" ></script>

   <!--common script for all pages-->
   <script src="{{asset('admin/js/common-scripts.js')}}"></script>

   <!--script for this page-->
   <script src="{{asset('admin/js/sparkline-chart.js')}}"></script>
   <script src="{{asset('admin/js/easy-pie-chart.js')}}"></script>
   <script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>

 <script>

    CKEDITOR.replace('editor-id', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});


    document.addEventListener("DOMContentLoaded", function() {

    document.getElementById('button-image').addEventListener('click', (event) => {
      event.preventDefault();

      window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
    });
    });

    // set file link
    function fmSetLink($url) {
    document.getElementById('image_label').value = $url;
    }
     //owl carousel

     $(document).ready(function() {
         $("#owl-demo").owlCarousel({
             navigation : true,
             slideSpeed : 300,
             paginationSpeed : 400,
             singleItem : true

         });
     });

     //custom select box

     $(function(){
         $('select.styled').customSelect();
     });

 </script>

 </body>
</html>
