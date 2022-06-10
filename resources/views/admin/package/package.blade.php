@extends('layouts.admin-master')
@section('title', 'Package list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
     <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .asColorPicker_open{z-index: 9999999;border:1px solid #ccc;}
        
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
                    <h4 class="text-themecolor">Package List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Package</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        @if($permission['is_add'])
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New Package</button>@endif
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

                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ribbon</th>
                                            <th>Package Name</th>
                                            <th>Ribbon Position</th>
                                           
                                            <th>Status</th>
                                            <th>Set Packages Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($get_data as $data)
                                        <tr id="item{{$data->id}}">
                                            <td><img width="60" src="{{asset('upload/images/package/'.$data->ribbon)}}"></td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->ribbon_position}}</td>
                                            
                                            <td>{!!($data->status == 1) ? "<span class='label label-info'>Active</span>" : '<span class="label label-danger">Deactive</span>'!!}
                                            </td>
                                            <td><a href="{{route('adspackageValue', $data->slug)}}"  class="btn btn-success btn-sm"><i class="ti-eye" aria-hidden="true"></i> View</a>
                                                @if($permission['is_add'])
                                                <button type="button" onclick="setValue('{{$data->id}}')"  data-toggle="modal" data-target="#setValue" class="btn btn-primary btn-sm"><i class="ti-plus" aria-hidden="true"></i> Set Value</button>@endif
                                            </td>
                                            <td>
                                                @if($permission['is_edit'])
                                                <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>@endif
                                                @if($permission['is_delete'])
                                                <button data-target="#delete" onclick="deleteConfirmPopup('{{route("adspackage.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>@endif
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
    <!-- add Modal -->
    <div class="modal fade" id="add" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Package</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('adspackage.store')}}" enctype="multipart/form-data" method="POST">
                    {{csrf_field()}}
                    <div class="modal-body form-row">

                        <div class="card-body">

                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name required">Package Name</label>
                                                <input name="name" placeholder="Write package name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <div class="form-group">
                                                <label for="ribbon">Ribbon Image</label>
                                                <input name="ribbon" id="ribbon" type="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Ribbon Position</label>
                                                <select name="ribbon_position" class="form-control">
                                                    <option value="top-left">Top left</option>
                                                    <option value="top-right">Top right</option>
                                                    <option value="bottom-left">Bottom left</option>
                                                    <option value="bottom-right">Bottom right</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Bacground Color</label>
                                                <input name="background_color" type="text" value="transparent" class="gradient-colorpicker form-control ">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Text Color</label>
                                                <input name="text_color" value="transparent" class="gradient-colorpicker form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">Border Color</label>
                                                <input name="border_color" value="transparent" class="gradient-colorpicker form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Package Details</label>
                                                <textarea name="details" rows="1" id="name" value="{{old('details')}}" placeholder="Write package details" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="promote_demo">Promote Demo</label>
                                                <input name="promote_demo" id="promote_demo" type="file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                           <span class="switch-box">Status</span>
                                            <div class="head-label">

                                                <div  class="status-btn" >
                                                    <div class="custom-control custom-switch">
                                                        <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                        <label  class="custom-control-label" for="status">Active/Deactive</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                     <div class="modal-footer">
                        <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- set Package Modal -->
    <div class="modal fade" id="setValue" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Set Package Value</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('adspackageValue.store')}}"  method="POST">
                    {{csrf_field()}}
                    <input type="hidden" value="" id="setValueId" name="package_id">
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="required">Select Categroy</label>
                                            <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                                <option value="all">All Category</option>
                                                @foreach($get_category as $category)
                                                    <option @if(Session::get('autoSelectId') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                    <!-- get subcategory -->
                                                    @if(count($category->get_subcategory)>0)
                                                   
                                                        @foreach($category->get_subcategory as $subcategory)

                                                            <option @if(Session::get('autoSelectId') == $subcategory->id) selected @endif value="{{$subcategory->id}}">--{{$subcategory->name}}</option>

                                                            <!-- get sub childcategory -->
                                                            @if(count($subcategory->get_subcategory)>0)
                                                             
                                                                @foreach($subcategory->get_subcategory as $subchildcategory)

                                                                    <option @if(Session::get('autoSelectId') == $subchildcategory->id) selected @endif value="{{$subchildcategory->id}}"> &nbsp;---{{$subchildcategory->name}}</option>

                                                                @endforeach
                                                            
                                                            @endif
                                                            <!-- end sub childcatgory -->
                                                        @endforeach
                                                      
                                                    @endif
                                                    <!-- end subcategory -->
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Number of ads</label>
                                            <input name="ads" required placeholder="Example: 50 ads" value="{{old('ads')}}" class="form-control" type="number">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Ads duration</label>
                                            <input name="duration" required placeholder="Example: 7 Days" value="{{old('ads')}}" class="form-control" type="number">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Price</label>
                                            <input name="price" required placeholder="Example: {{ config('siteSetting.currency_symble') }}50 " value="{{old('price')}}" class="form-control" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Discount</label>
                                            <input name="discount" value="{{old('discount')}}" class="form-control" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Package Details</label>
                                            <input name="details" id="name" value="{{old('details')}}"  placeholder="Write details" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <span>Status</span>
                                        <div class="head-label">

                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="statusValue">
                                                    <label  class="custom-control-label" for="statusValue">Active/Deactive</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                     <div class="modal-footer">
                        <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                        <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog"   style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('adspackage.update')}}"  enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Package</h4>
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
    <!-- delete Modal -->
    @include('admin.modal.delete-modal')

@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(".select2").select2();
        $(function () {
            $('#myTable').DataTable();
        });

        function setValue(id){
            document.getElementById('setValueId').value = id;
        }
    </script>

    <script type="text/javascript">

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("adspackage.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                         $(".select2").select2();
                         $(".gradient-colorpicker").asColorPicker({
                            mode: 'gradient'
                        });
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });

        }

    $("#displayIn").change(function() {
        if(this.checked) { $("#displayInDetailsPage").show(); }
        else { $("#displayInDetailsPage").hide(); }
    });


</script>

<!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <script>
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
    </script>

@endsection
