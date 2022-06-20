@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading text-center p-2 mt-2" style="border-radius:10px; background-color:yellowgreen;">
           <h3> تقویم آموزشی</h3>
           
        </header>
        
        <table class="table table-striped border-top mt-1" id="sample_1">
            <thead>
                <tr>
                    <th>#</th>
                    <th> نام دوره </th>
                    <th>مدرس</th>
                    <th>مدت</th>
                    <th>ظرفیت</th>
                    <th> مبلغ </th>
                    <th>تاریخ شروع</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($calendars as $calendar)
                <tr>
                    <td>{{$calendar->id}}</td>
                    <td>{{$calendar->course}}</td>
                    <td >{{$calendar->teacher}}</td>
                    <td >{{$calendar->time}}</td>
                    <td >{{$calendar->capacity}}</td>
                    <td >{{$calendar->cost}}</td>
                    <td >{{$calendar->startingtime}}</td>
                   
                </tr>   
                @endforeach
                
            </tbody>
        </table>
    </section>
</div>

<!--main content end-->
@endsection