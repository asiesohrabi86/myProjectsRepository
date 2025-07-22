@extends('dashboard.layouts.master')
@section('title','مدیریت نظرات تاییدنشده')
@section('content')
<div class="main-content">
    <div class="data-table-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 box-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title mb-2">لیست نظرات تاییدنشده</h4>
                                </div>
                                
                                <div class="row"><div class="col-sm-12 col-md-6"><div class="dt-buttons btn-group"> <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" type="button"><span>کپی</span></button> <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="datatable-buttons" type="button"><span>پرینت</span></button> </div></div><div class="col-sm-12 col-md-6"><div id="datatable-buttons_filter" class="dataTables_filter"><label>جستجو:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="datatable-buttons"></label></div></div></div>
                            </div>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>آیدی نظر</th>
                                        <th>مربوط به</th>
                                        <th>نام نظردهنده</th>
                                        <th>متن نظر</th>
                                        <th>نظر والد</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->id }}</td>
                                            <td>
                                                @if ($comment->commentable_type == 'App\\Models\\Product' && $comment->commentable)
                                                    {{ $comment->commentable->title }}
                                                @endif
                                            </td>
                                            <td>{{ $comment->user->name }}</td>
                                            <td>{{ $comment->text }}</td>
                                            <td>
                                                @if ($comment->parent)
                                                    {{ Str::limit($comment->parent->text, 30) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($comment->approved)
                                                    <span class="badge badge-success">تاییدشده</span>
                                                @else
                                                    <span class="badge badge-danger">تاییدنشده</span>
                                                @endif
                                            </td>
                                            <td class="row">
                                                <form action="{{ route('unapproved.post', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="btn btn-success btn-sm">تایید</button>
                                                </form>
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" onclick="return confirm('آیا از حذف نظر مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

 
        </div>
    </div>
</div>
@endsection