@extends('dashboard.layouts.master')
@section('title','ایجاد محصول جدید')
    
@section('content')
<div class="main-content">
    <!-- Basic Form area Start -->
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-12 height-card box-margin">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">اطلاعات پایه</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">افزودن ویژگی</a>
                                    <a class="nav-item nav-link" id="nav-color-tab" data-toggle="tab" href="#nav-color" role="tab" aria-controls="nav-color" aria-selected="false">افزودن رنگ</a>
                                    <a class="nav-item nav-link" id="nav-guarantee-tab" data-toggle="tab" href="#nav-guarantee" role="tab" aria-controls="nav-guarantee" aria-selected="false">افزودن گارانتی</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="col-xl-6 box-margin height-card">
                                        <div class="card card-body">
                                            <h4 class="card-title">فرم ایجاد محصول جدید</h4>
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    @if ($errors->any())
                                                        <ul class="alert alert-danger">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail111">نام محصول</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail111" value="{{old('title')}}" name="title">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>متن محصول</label>
                                                        <textarea class="form-control" id="editor-id" name="text"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>دسته بندی محصول</label>
                                                        <select class="form-control" id="categories" name="categories[]" multiple>
                                                            @foreach ($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword11">قیمت محصول</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword11" value="{{old('price')}}" name="price">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword12">موجودی محصول</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword12" value="{{old('amount')}}" name="amount">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword12">تصویر محصول</label>
                                                        <input type="file" class="form-control" id="exampleInputPassword12" value="{{old('image')}}" name="image">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword12">متاتایتل</label>
                                                        <textarea type="file" class="form-control" id="exampleInputPassword12" value="{{old('metaTitle')}}" name="metaTitle">
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword12">متادسکریپشن</label>
                                                        <textarea type="file" class="form-control" id="exampleInputPassword12" value="{{old('metaDescription')}}" name="metaDescription">
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="brand_id">برند محصول</label>
                                                        <select class="form-control" id="brand_id" name="brand_id">
                                                            <option value="">انتخاب برند</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2">ثبت محصول</button>
                                            <button type="button" class="btn btn-default">لغو</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    @foreach ($attributes as $attribute)
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <input type="checkbox" id="attr_check_{{$attribute->id}}" name="selected_attributes[]" value="{{$attribute->id}}" style="margin-left: 5px;">
                                                <label for="attr_check_{{$attribute->id}}" style="margin-bottom:0;">{{$attribute->name}}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select name="attributeValues[{{$attribute->id}}]" id="attr_select_{{$attribute->id}}" class="form-control" disabled>
                                                    @foreach ($attributeValues as $attributeValue)
                                                        @if($attribute->id == $attributeValue->attribute_id)
                                                            <option value="{{$attributeValue->id}}">{{$attributeValue->value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                    <script>
                                        document.querySelectorAll('input[type=checkbox][name="selected_attributes[]"]').forEach(function(checkbox) {
                                            checkbox.addEventListener('change', function() {
                                                let select = document.getElementById('attr_select_' + this.value);
                                                select.disabled = !this.checked;
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="tab-pane fade" id="nav-color" role="tabpanel" aria-labelledby="nav-color-tab">
                                    <div id="colors-wrapper">
                                        <div class="color-row row mb-2">
                                            <div class="col-md-4">
                                                <label>نام رنگ</label>
                                                <input type="text" name="colors[0][color_name]" class="form-control" placeholder="مثال: قرمز">
                                            </div>
                                            <div class="col-md-4">
                                                <label>کد رنگ</label>
                                                <input type="color" name="colors[0][color]" class="form-control" value="#000000">
                                            </div>
                                            <div class="col-md-3">
                                                <label>افزایش قیمت (تومان)</label>
                                                <input type="number" name="colors[0][price_increase]" class="form-control" placeholder="مثال: 50000">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-color" style="display:none">حذف</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success mt-2" id="add-color">افزودن رنگ جدید</button>
                                    <script>
                                        let colorIndex = 1;
                                        document.getElementById('add-color').addEventListener('click', function() {
                                            const wrapper = document.getElementById('colors-wrapper');
                                            const row = document.createElement('div');
                                            row.className = 'color-row row mb-2';
                                            row.innerHTML = `
                                                <div class="col-md-4">
                                                    <input type="text" name="colors[${colorIndex}][color_name]" class="form-control" placeholder="نام رنگ">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="color" name="colors[${colorIndex}][color]" class="form-control" value="#000000">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" name="colors[${colorIndex}][price_increase]" class="form-control" placeholder="افزایش قیمت (تومان)">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger remove-color">حذف</button>
                                                </div>
                                            `;
                                            wrapper.appendChild(row);
                                            colorIndex++;
                                        });
                                        document.addEventListener('click', function(e) {
                                            if(e.target && e.target.classList.contains('remove-color')) {
                                                e.target.closest('.color-row').remove();
                                            }
                                        });
                                    </script>
                                </div>
                                <div class="tab-pane fade" id="nav-guarantee" role="tabpanel" aria-labelledby="nav-guarantee-tab">
                                    <div id="guarantees-wrapper">
                                        <div class="guarantee-row row mb-2">
                                            <div class="col-md-6">
                                                <label>نام گارانتی</label>
                                                <input type="text" name="guarantees[0][name]" class="form-control" placeholder="مثال: ۱۸ ماهه شرکتی">
                                            </div>
                                            <div class="col-md-5">
                                                <label>افزایش قیمت (تومان)</label>
                                                <input type="number" name="guarantees[0][price_increase]" class="form-control" placeholder="مثال: 100000">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-guarantee" style="display:none">حذف</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success mt-2" id="add-guarantee">افزودن گارانتی جدید</button>
                                    <script>
                                        let guaranteeIndex = 1;
                                        document.getElementById('add-guarantee').addEventListener('click', function() {
                                            const wrapper = document.getElementById('guarantees-wrapper');
                                            const row = document.createElement('div');
                                            row.className = 'guarantee-row row mb-2';
                                            row.innerHTML = `
                                                <div class="col-md-6">
                                                    <input type="text" name="guarantees[${guaranteeIndex}][name]" class="form-control" placeholder="نام گارانتی">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="guarantees[${guaranteeIndex}][price_increase]" class="form-control" placeholder="افزایش قیمت (تومان)">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger remove-guarantee">حذف</button>
                                                </div>
                                            `;
                                            wrapper.appendChild(row);
                                            guaranteeIndex++;
                                        });
                                        document.addEventListener('click', function(e) {
                                            if(e.target && e.target.classList.contains('remove-guarantee')) {
                                                e.target.closest('.guarantee-row').remove();
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor-id', {
            filebrowserImageBrowseUrl: '/file-manager/ckeditor'
        });
    </script>
@endsection