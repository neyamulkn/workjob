@extends('layouts.frontend')
@section('title', 'Addvertisement list')
@section('css')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .labelBox{border: 1px solid #95918f; border-radius: 5px;padding: 3px 7px;margin-bottom: 5px; color: #000; display: flex; justify-content: space-between;}
        .labelArea input[type="radio"]:checked + label { border-color: #079b20; }
        .labelArea input[type="radio"]:checked + label {background-color: #00fb082e;color: #035a06;}
        .labelArea input[type="radio"]{display: none;}
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
                        <h4 class="text-themecolor">Addvertisement List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">ads</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New</button>
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
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input name="title" placeholder="Title" value="{{ Request::get('title')}}" type="text" class="form-control">
                                                </div>
                                            </div>

                                           
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                                        <option value="deactive" {{ (Request::get('status') == 'deactive') ? 'selected' : ''}}>Deactive</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="show">
                                                        <option @if(Request::get('show') == 15) selected @endif value="15">15</option>
                                                        <option @if(Request::get('show') == 25) selected @endif value="25">25</option>
                                                        <option @if(Request::get('show') == 50) selected @endif value="50">50</option>
                                                        <option @if(Request::get('show') == 100) selected @endif value="100">100</option>
                                                        <option @if(Request::get('show') == 255) selected @endif value="250">250</option>
                                                        <option @if(Request::get('show') == 500) selected @endif value="500">500</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                   
                                                   <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Url</th>
                                                <th>Day</th>
                                                <th>Price</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($advertisements as $data)
                                            <tr id="item{{$data->id}}">

                                                <td>{{$data->ads_name}}</td>
                                                <td>{{$data->redirect_url}}</td>
                                                <td>{{$data->days}}</td>
                                                <td>{{ config('siteSetting.currency_symble'). $data->price}}</td>
                                                <td><img width="100" src="{{asset('upload/marketing/'.$data->image)}}"></td>
                                               
                                            
                                                <td>
                                                   <span>{{ $data->status }}</span>
                                                </td>
                                                <td>
                                                     <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                     <button title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("userAds.delete", $data->id)}}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$advertisements->appends(request()->query())->links()}}
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $advertisements->firstItem() }} to {{ $advertisements->lastItem() }} of total {{$advertisements->total()}} entries ({{$advertisements->lastPage()}} Pages)</div>
                </div>


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        
        <!-- add Modal -->
        <div class="modal fade" id="add">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new ads </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('userAds.store')}}" enctype="multipart/form-data" method="POST" >
                                {{csrf_field()}}
                               
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ads_name">Ads Title</label>
                                                <input type="text" value="{{old('ads_name')}}"  name="ads_name"  id="ads_name" placeholder="Enter ads name" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                           <div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" class="form-control" > </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group labelArea row"> 
                                                @for($i=1; $i<=7; $i++)
                                                <div class="col-md-6">
                                                <input type="radio" name="price" value="{{$i}}" id="price{{$i}}">
                                                <label for="price{{$i}}" class="labelBox"><span> <i class="fab fa-adversal"></i> {{$i}} Day</span> <span>{{ config('siteSetting.currency_symble'). $i}}</span></label> </div>
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                           <div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input required type="file" name="image" id="input-file-now" class="dropify" /> </div> </div>
                                        </div>
                                        

                                        
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
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

        <!-- update Modal -->
        <div class="modal fade" id="edit" role="dialog" style="display: none;">
            <div class="modal-dialog modal-sm">
                <form action="{{route('userAds.update')}}" enctype="multipart/form-data" method="post">
                      {{ csrf_field() }}
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update addvertisement</h4>
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
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    
    <script type="text/javascript">
        $('.dropify').dropify();
        $(".select2").select2();

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("userAds.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $(".select2").select2();
                        $('.dropify').dropify();
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'edit_form'])
            });

        }
        function adsTypes(type, edit=''){

            var output = '';
            if(type == 'image'){
                output = '<div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input required type="file" name="image" id="input-file-now" class="dropify" /> </div> </div><div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" class="form-control" > </div>';
            }else if(type == 'google'){
                output = '<div class="form-group"> <label class="required" for="add_code">Add code</label> <textarea name="add_code" class=" form-control" rows="5" id="add_code" placeholder="Enter ads code ..."></textarea> </div> ';
            }else if(type == 'others'){
                output = '<div class="form-group"> <label for="add_link required">Add code or link</label> <textarea name="add_code" class=" form-control" rows="3" id="add_link" placeholder="Enter ads code ..."></textarea></div><div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" class="form-control" > </div>';
            }else{
                 output = '';
            }

            if(edit == 'edit'){
                $('#editshowAdsType').html(output);
                $('#showAdsType').html('');
            }else{
                $('#showAdsType').html(output);
                $('#editshowAdsType').html('');
            }

            $('.dropify').dropify();
        }
    </script>

@endsection
