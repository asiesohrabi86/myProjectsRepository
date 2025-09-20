@extends('dashboard.layouts.master')
@section('title','مدیریت نظرات')
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
                                    <h4 class="card-title mb-2">لیست نظرات</h4>
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
                                    @php
                                        function renderCommentRow($comment, $level = 0) {
                                            echo '<tr style="background:'.($level ? '#f8f9fa' : 'inherit').';">';
                                            echo '<td>'.$comment->id.'</td>';
                                            echo '<td>';
                                            if ($comment->commentable_type == 'App\\Models\\Product' && $comment->commentable) {
                                                echo e($comment->commentable->title);
                                            }
                                            echo '</td>';
                                            echo '<td>'.e($comment->user->name).'</td>';
                                            echo '<td>'.e($comment->text).'</td>';
                                            echo '<td>';
                                            if ($comment->parent) {
                                                echo e(Str::limit($comment->parent->text, 30));
                                            }
                                            echo '</td>';
                                            echo '<td>';
                                            if ($comment->approved) {
                                                echo '<span class="badge badge-success">تاییدشده</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">تاییدنشده</span>';
                                            }
                                            echo '</td>';
                                            echo '<td class="row">';
                                            echo '<form action="'.route('comments.destroy',$comment->id).'" method="POST">';
                                            echo csrf_field();
                                            echo method_field('delete');
                                            echo '<button type="submit" onclick="return confirm(\'آیا از حذف نظر مطمئن هستید؟\')" class="btn btn-danger btn-sm">حذف</button>';
                                            echo '</form>';
                                            echo '</td>';
                                            echo '</tr>';
                                            // نمایش فرزندان
                                            foreach ($comment->children as $child) {
                                                renderCommentRow($child, $level + 1);
                                            }
                                        }
                                    @endphp
                                    @foreach ($comments->where('parent_id', 0) as $comment)
                                        {!! renderCommentRow($comment) !!}
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