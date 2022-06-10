@extends('layouts.admin-master')
@section('title', 'Homepage section list')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />

@endsection
@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .asColorPicker_open{z-index: 9999999}
        .dropify-wrapper{height: 120px;}
    </style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Homepage section List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">homepage</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        @if($permission['is_add'])
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New</button>@endif
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <i class="drag-drop-info">Drag & drop sorting position</i>
                            
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Section Title</th>
                                            <th>Section Sourch</th>
                                            <th>Number Of Item</th>
                                            <th>Section Width</th>
                                            <th>Is Default</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody @if($permission['is_edit']) id="positionSorting" data-table="homepage_sections" @endif>
                                        @foreach($homepageSections as $index => $data)
                                        <tr id="item{{$data->id}}">
                                            <td>{{$index+1}}</td>
                                            <td>{{$data->title}}</td>
                                            <td>{{str_replace('-', ' ', $data->section_type)}}</td>
                                            <td>{{ $data->item_number }}</td>
                                            <td><span class="label label-info"> {{($data->layout_width != null) ? 'Full' : 'Box'}}</span>
                                            </td>
                                            <td>{!!($data->is_default == 1) ? '<span class="label label-info"> Default</span>' : '<span class="label label-danger">Custom</span>' !!}
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                  <input name="status" @if($permission['is_edit']) onclick="satusActiveDeactive('homepage_sections', {{$data->id}})" @endif type="checkbox" {{($data->status == 1) ? 'checked' : ''}} class="custom-control-input" id="status{{$data->id}}">
                                                  <label class="custom-control-label" for="status{{$data->id}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                @if($permission['is_edit'])
                                                @if($data->section_manage == 1)
                                                <a title="Add item under this section" class="btn btn-primary btn-sm" href="{{route('admin.homepageSectionItem', $data->slug)}}"><i class="ti-pin-alt" aria-hidden="true"></i> Manage {{$data->section_type}}</a>
                                                @endif

                                                <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                @endif
                                                @if($permission['is_delete'])
                                                @if($data->is_default != 1)
                                                <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.homepageSection.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('admin.homepageSection.update')}}" enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update homepage section</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="add">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Homepage section</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('admin.homepageSection.store')}}" enctype="multipart/form-data" data-parsley-validate  method="POST" >
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="name">Section Title</label>
                                            <input  name="title" id="name" value="{{old('title')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name required">Select Sourch</label>
                                            <select required onchange="sectionType(this.value)" name="section_type" class="form-control">
                                                <option value="">Selct one</option>
                                                <option value="section">Pick Products</option>
                                                <option value="category">Categories</option>
                                                <option value="category-product">Category Product</option>
                                                <option value="package">Package</option>
                                                <option value="banner">Banner</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12"><div class="row" id="showSection"></div></div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Number Of Item</label>
                                            <input type="number" min="1" class="form-control" placeholder="Example: 7" name="item_number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Section Width</label>
                                            <select name="layout_width" class="form-control">
                                                <option value="box">Box</option>
                                                <option value="full">Full</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required" for="name">Bacground Color</label>
                                            <input type="text" name="background_color" value="#ffffff" class="form-control gradient-colorpicker" >
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required" for="name">Text Color</label>
                                            <input name="text_color" value="#000000" class="gradient-colorpicker form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Tumbnail Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="thumb_image" id="input-file-events">
                                            <i class="upload-info">Recommended size: 300px*250px</i>
                                        </div>
                                        @if ($errors->has('thumb_image'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('thumb_image') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Image Position</label>
                                            <select name="image_position" class="form-control">
                                                <option value="left">Left</option>
                                                <option value="right">Right</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="required" for="name">Notes</label>
                                        <textarea name="notes" rows="2" class="form-control"></textarea> 
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box" style="margin-left: -12px; top:-12px;">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                    <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal -->
    @include('admin.modal.delete-modal')

@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>

    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
       
    });
    </script>
    <script>

    // Colorpicker
  
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });

    $(".select2").select2();
    </script>
    <script>
      
        function removeImage(id){
            if ( confirm("Are you sure delete thumb image.?")) {
                var url = "{{route('sectionImageDelete', ':id')}}";
                url = url.replace(':id', id);
                $.ajax({
                    url:url,
                    method:"get",
                    success:function(data){
                        if(data){
                             $('.thumb_image').html('<input  type="file" class="dropify" accept="image/*" data-type="image" data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="thumb_image" id="input-file-events">');
                           
                            $('.dropify').dropify();
                            toastr.success(data.msg);
                        }
                    }
                }); 
            }
            return false;
        }

    </script>
    <script type="text/javascript">


    function sectionType(sectionType, edit=''){

        var output = '';
        if(sectionType== 'banner'){
            output = '<div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Select Banner</label> <select name="product_id" required="required" id="product_id" class="form-control custom-select"> <option value="">Select banner</option>@foreach($banners as $banner)<option value="{{$banner->id}}" > {{$banner->title}}</option>@endforeach</select> </div></div>';
        }else if(sectionType== 'package'){
            output = '<div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Select Banner</label> <select name="product_id" required="required" id="product_id" class="form-control custom-select"> <option value="">Select Package</option>@foreach($packages as $package)<option value="{{$package->id}}" > {{$package->name}}</option>@endforeach</select> </div></div>';
        }else if(sectionType== 'category-product'){
            output = '<div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Product Categories</label> <select name="product_id" required="required" id="product_id" class="form-control select2" custom-select"><option value="">Select Category</option> @foreach($categories as $category)  <option value="{{$category->id}}">{{$category->name}}</option> <!-- get subcategory --> @if(count($category->get_subcategory)>0) @foreach($category->get_subcategory as $subcategory)  <option value="{{$subcategory->id}}">&nbsp; -{{$subcategory->name}}</option>  <!-- get childcategory --> @if(count($subcategory->get_subchild_category)>0) @foreach($subcategory->get_subchild_category as $childcategory)  <option value="{{$childcategory->id}}">&nbsp; &nbsp; --{{$childcategory->name}}</option>  @endforeach @endif <!-- end subcategory --> @endforeach  @endif <!-- end subcategory --> @endforeach</select> </div></div>';

        }else if(sectionType== 'category'){
            output = '<div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Product Categories</label> <select name="product_id" required="required" id="product_id" class="form-control select2" custom-select"><option value="">Select Category</option> @foreach($categories as $category)  <option value="{{$category->id}}">{{$category->name}}</option>  @endforeach</select> </div></div>';

        }
        else if(sectionType== 'section'){
            output += '<div class="col-md-12"><div class="form-group"> <label class="required" for="category">Product Categories</label> <select onchange="getAllProducts(this.value)"  required="required" id="category" class="form-control select2 custom-select"> <option value="">Select category</option> @foreach($categories as $category)  <option value="{{$category->id}}">{{$category->name}}</option> <!-- get subcategory --> @if(count($category->get_subcategory)>0) @foreach($category->get_subcategory as $subcategory)  <option value="{{$subcategory->id}}">&nbsp; -{{$subcategory->name}}</option>  <!-- get childcategory --> @if(count($subcategory->get_subchild_category)>0) @foreach($subcategory->get_subchild_category as $childcategory)  <option value="{{$childcategory->id}}">&nbsp; &nbsp; --{{$childcategory->name}}</option>  @endforeach @endif <!-- end subcategory --> @endforeach  @endif <!-- end subcategory --> @endforeach</select> </div></div><div class="col-md-12"> <div class="form-group"><label for="homepage">Select Product</label><select required onchange="getProduct(this.value)" id="showAllProducts" class="form-control select2 custom-select" style="width: 100%"><option value="">Select First Category</option></select></div></div><div class="col-md-12"><div class="form-group"><label for="getProducts">Selected Products</label><select required name="product_id[]" id="showSingleProduct" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose"></select></div></div>';
        }else{

        }
        if(edit == 'edit'){
            $('#editshowSection').html(output);
            $('#showSection').html('');
             $(".select2").select2();
        }else{
            $('#showSection').html(output);
            $('#editshowSection').html('');
            $(".select2").select2();
        }
        
       
    }

    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("admin.homepageSection.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $(".select2").select2();
                    $('.dropify').dropify();
                    $(".gradient-colorpicker").asColorPicker({
                        mode: 'gradient'
                    });
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])
        });

    }

    // get homepage Sourch
    function getAllProducts(id){

        var  url = '{{route("admin.getProductsByField", "category_id")}}';

        $.ajax({
            url:url,
            method:"get",
            data:{id:id},
            success:function(data){

                if(data){
                    $("#showAllProducts").html(data);
                    $(".select2").select2();
                }else{
                    $("#showAllProducts").html('<option>Product not found</option>');
                }
            }
        });
    }

    // get homepage Sourch
    function getProduct(id){

        var  url = '{{route("admin.getSingleProduct")}}';

        $.ajax({
            url:url,
            method:"get",
            data:{id:id},
            success:function(data){
                if(data){
                    $("#showSingleProduct").append(data);
                    $(".select2").select2();
                }
            }
        });
    }


        // get category Sourch
    function getSubcateogry(category_id, edit=''){

        var  url = '{{route("admin.getSubChildcategory")}}';
        if(category_id != ''){
            $.ajax({
                url:url,
                method:"get",
                data:{category_id:category_id},
                success:function(data){

                    if(data){
                        $("#"+edit+"showSubcateogry").html(data);
                        $(".select2").select2();
                    }else{
                        $("#"+edit+"showSubcateogry").html('<option>Category not found</option>');
                    }
                }
            });
        }else{
            $("#"+edit+"showSubcateogry").html('<option>Category not found</option>');
        }
    }

    // if occur error open model
    @if($errors->any())
        $("#{{Session::get('submitType')}}").modal('show');
    @endif
    </script>

@endsection
