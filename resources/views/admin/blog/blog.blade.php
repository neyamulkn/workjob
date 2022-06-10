@extends('layouts.admin-master')
@section('title', 'Blog Post' )
@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/ad-post.css">
<style type="text/css">
    .form-check-list li{display: inline-flex;}
    .adjust-field{border: none;border-radius:0;position: absolute;top: 0;right: 0;background: #e9ecef;padding: 5px;}
</style>
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                   
                </div>
                <div class="col-md-7 align-self-center text-right">
                    @if($permission['is_view'])
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">blog</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        
                        <a href="{{route('admin.blog.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> blog List</a>
                    </div>@endif
                </div>
            </div>
            <form action="{{ route('blog.store') }}" data-parsley-validate method="post" enctype="multipart/form-data" class="adpost-form">
                @csrf
                <div class="adpost-card">
                    <div class="adpost-title">
                        <h3>Write your blog</h3>
                    </div>
                    <div class="col-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label required">Blog Title</label>
                                <input name="title" required value="{{old('title')}}" type="text" class="form-control" placeholder="Type your product title here">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label required">Category</label>
                                <select required name="category_id" class="form-control custom-select">
                                    <option selected>Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                <input style="padding-top: 0;" name="feature_image" type="file" class="form-control">
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label required">Blog description</label>
                                <textarea name="description" required class="summernote form-control" placeholder="Describe your message">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <div class=" col-lg-12 form-group text-right">
                        <button class="btn btn-success">
                            <i class="fas fa-check-circle"></i>
                            <span>published your blog</span>
                        </button>
                    </div>
                    </div>
                    </div>

                </div>
                
                
            </form>
</div>
</div>
@endsection

@section('js')

<script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>
@endsection