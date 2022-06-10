@extends('layouts.admin-master')
@section('title', 'package value list')

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
                        <h4 class="text-themecolor">{{$package->name}} package Value List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            
                            <a href="{{route('adspackage')}}" class="btn btn-success d-none d-lg-block m-l-15"><i  class="fa fa-arrow-left"></i> Package list</a>
                            @if($permission['is_add'])
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Set New Value</button>@endif
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
                                <form action="" method="get">
                                <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="ads" placeholder="number of ads" value="{{ Request::get('ads')}}" type="number" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                
                                                <select name="category" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                                    <option value="all">All Category</option>
                                                    @foreach($get_category as $category)
                                                        <option disabled @if(Session::get('autoSelectId') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        <!-- get subcategory -->
                                                        @if(count($category->get_subcategory)>0)
                                                       
                                                            @foreach($category->get_subcategory as $subcategory)

                                                                <option @if(Session::get('autoSelectId') == $subcategory->id) selected @endif value="{{$subcategory->id}}">-- {{$subcategory->name}}</option>

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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select class="form-control" name="show">
                                                        <option @if(Request::get('show') == 15) selected @endif value="15">15</option>
                                                        <option @if(Request::get('show') == 25) selected @endif value="25">25</option>
                                                        <option @if(Request::get('show') == 50) selected @endif value="50">50</option>
                                                        <option @if(Request::get('show') == 100) selected @endif value="100">100</option>
                                                        <option @if(Request::get('show') == 255) selected @endif value="250">250</option>
                                                        <option @if(Request::get('show') == 500) selected @endif value="500">500</option>
                                                        <option @if(Request::get('show') == 750) selected @endif value="750">750</option>
                                                        <option @if(Request::get('show') == 1000) selected @endif value="1000">1000</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                   
                                                   <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Ads</th>
                                                <th>Duration</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($get_data as $index => $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$index+1}}</td>
                                                <td>@if($data->get_category){{$data->get_category->name}}@endif</td>
                                                <td>{{$data->ads}} Ads</td>
                                                <td>{{$data->duration}} Days</td>
                                                <td>{{ config('siteSetting.currency_symble') }}{{$data->price}}</td>
                                                <td>{{($data->discount) ? $data->discount : 0}}%</td>
                                               
                                                <td>{!!($data->status == 1) ? "<span class='label label-info'>Active</span>" : '<span class="label label-danger">Deactive</span>'!!} 
                                                </td>
                                                <td>@if($permission['is_edit'])
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>@endif
                                                    @if($permission['is_delete'])
                                                    <button data-target="#delete" onclick="deleteConfirmPopup('{{route('adspackageValue.delete', $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>@endif
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
        <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Set package Value</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{route('adspackageValue.store')}}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$package->id}}" name="package_id">
                        <div class="modal-body form-row">

                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="required">Categroy</label>
                                                <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                                    <option value="">Select Category</option>
                                                    @foreach($get_category as $category)
                                                        <option disabled @if(Session::get('autoSelectId') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                        <!-- get subcategory -->
                                                        @if(count($category->get_subcategory)>0)
                                                       
                                                            @foreach($category->get_subcategory as $subcategory)

                                                                <option @if(Session::get('autoSelectId') == $subcategory->id) selected @endif value="{{$subcategory->id}}">-- {{$subcategory->name}}</option>

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
                                                <input name="ads" placeholder="Example: 50 ads" value="{{old('ads')}}" class="form-control" type="number">
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
                                                <input name="discount" value="{{old('discount')}}" class="form-control" placeholder="Example: 10%" type="number">
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
        <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('adspackageValue.update')}}"  enctype="multipart/form-data" method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Ads package</h4>
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


    <script type="text/javascript">

      function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("adspackageValue.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                   
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])


        });

    }


// if occur error open model
    @if($errors->any())
        $("#{{Session::get('submitType')}}").modal('show');
    @endif
</script>
  


@endsection
