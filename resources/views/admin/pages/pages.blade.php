@extends('layouts.admin-master')
@section('title', 'Create New Page')
@section('css')
    <link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
   
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        

        .page-titles {
            margin: 0 -25px 5px !important;
        }
        .dropify-wrapper{
            margin-bottom: 10px;
        }
        .dropify_image_area{
            position: absolute;top: -14px;left: 12px;background:#fff;padding: 3px;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
            padding: 5px;
        }
        #image .dropify-wrapper, #video .dropify-wrapper {
            height: 18rem !important;
        }


    </style>
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
                    <h4 class="text-themecolor">Create New Page</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Page</a></li>
                            <li class="breadcrumb-item active">create</li>
                        </ol>
                        @if($permission['is_view'])
                        <a href="{{route('page.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Page List</a>@endif
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div class="card-body">
                    <form action="{{route('page.store')}}" enctype="multipart/form-data" method="post" id="page">
                        @csrf

                        <div class="form-body">
                            <div class="title_head">
                                Page Details 
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="required" for="title">Page Name</label>
                                        <input type="text" onchange="getSlug(this.value)" value="{{old('title')}}" placeholder="Enter page name" name="title" required="" id="title" class="form-control" >
                                       
                                    </div>
                                   
                                </div>

                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="required" for="title">Page Slug</label>
                                        <input required type="text" id="slugEdit" name="slug"  class="form-control" >
                                    </div>
                                     
                                </div>
                               

                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="required" style="background: #fff;top:-10px;z-index: 1" for="page_dsc">Page Description</label>
                                        <textarea required="" name="page_dsc" class="summernote form-control" id="page_dsc" rows="5">{{old('page_dsc')}}</textarea>
                                    </div>
                                </div>

                               <div class="col-md-10"><br/>
                                    <div class="form-group">
                                        <div class="checkbox2">
                                            <input type="checkbox" id="checkSeo" name="secheck" value="1">
                                            <label for="checkSeo">Allow Page SEO</label>
                                      </div>      
                                    </div> 
                                    <div  id="seoField" style="display: none;">  
                                        
                                        <div class="form-group">
                                            <label class="required" for="meta_title">Meta Title</label>
                                            <input type="text" value="{{old('meta_title')}}"  name="meta_title" id="meta_title" placeholder = 'Enter meta title'class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label class="required">Meta Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</label>

                                             <div class="tags-default">
                                                <input  type="text" name="meta_keywords[]"  data-role="tagsinput" placeholder="Enter meta keywords" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="meta_description">Meta Description</label>
                                            <textarea class="form-control" name="meta_description" id="meta_description" rows="2" style="resize: vertical;" placeholder="Enter Meta Description">{{old('meta_description')}}</textarea>
                                        </div>

                                        <div class="form-group">
                                    
                                            <label class="control-label">Meta image</label>
                                        
                                            <input type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpeg jpg png gif" name="meta_image" id="input-file-events">
                                        </div>
                                   
                                 
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        
                                        <label class="switch-box" style="top:-12px;">Status</label>
                                        
                                            <div class="custom-control custom-switch">
                                              <input checked="" name="status" {{ (old('status') == 'on') ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="status">
                                              <label style="padding: 5px 12px" class="custom-control-label" for="status">Publish/Unpublish</label>
                                        </div>
                                    </div>
                                </div>
                            
                            </div><hr>
                            <div class="form-actions pull-right">
                                <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Create page</button>
                               
                                <button type="reset" class="btn waves-effect waves-light btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')
   
 
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
        function getSlug(title) {
            var  url = '{{route("page.slug")}}';
          
            $.ajax({
                url:url,
                method:"get",
                data:{title:title},
                success:function(slug){
                    if(slug){
                        $('#slugEdit').focus();
                        document.getElementById('slugEdit').value = slug;
                    }else{
                        document.getElementById('slugEdit').value = "";
                    }
                }
             });
        }

    </script>


    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
      
    });

        $("#checkSeo").change(function() {
        if(this.checked) { $("#seoField").show(); }
        else { $("#seoField").hide(); }
    });
    </script>

    <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 200, // set editor height
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
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
    // Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });
    </script>


@endsection

