@extends('layouts.admin-master')
@section('title', 'Verify request list')
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
  
    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
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
                    <h4 class="text-themecolor">Verify request List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Verify request</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <!-- <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button> -->
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

                    <div class="card ">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Mobile & Email</th>
                                           
                                            <th>Posts</th>
                                            
                                            <th>NID</th>
                                            <th>trade_license</th>
                                            <th>Address</th>
                                            <th>Verify</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach($customers as $index => $customer)
                                        <tr id="item{{$customer->id}}">
                                            <td>{{(($customers->perPage() * $customers->currentPage() - $customers->perPage()) + ($index+1) )}}</td>
                                            <td>
                                                <a style="display:flex;" class="dropdown-item" title="View Profile" href="{{ route('customer.profile', $customer->username) }}"><img src="{{asset('upload/users')}}/{{( $customer->photo) ? $customer->photo : 'default.png'}}" width="60"> 

                                                <p style="padding-left: 3px">{{$customer->shop_name}}<br>
                                                {{$customer->name}}</p>
                                                </a>
                                            </td>
                                            <td>{{$customer->mobile}} <br/> {{$customer->email}}</td> 
                                            <td><a href="{{ route('customer.profile', $customer->username) }}" class="label label-info">{{$customer->posts_count}}</a></td>
                                            <td>
                                                <a class="popup-gallery" href="{{asset('upload/users/'.$customer->nid_front)}}"><img width="50" src="{{asset('upload/users/'.$customer->nid_front)}}"></a>
                                                <a class="popup-gallery" href="{{asset('upload/users/'.$customer->nid_back)}}"><img width="50" src="{{asset('upload/users/'.$customer->nid_back)}}"></a>
                                            </td>
                                            <td>
                                                @if($customer->trade_license) <a class="popup-gallery" href="{{asset('upload/users/'.$customer->trade_license)}}"><img width="50" src="{{asset('upload/users/'.$customer->trade_license)}}"></a>@endif 
                                                @if($customer->trade_license2) <a class="popup-gallery" href="{{asset('upload/users/'.$customer->trade_license2)}}"><img width="50" src="{{asset('upload/users/'.$customer->trade_license2)}}"></a>@endif
                                                @if($customer->trade_license3) <a class="popup-gallery" href="{{asset('upload/users/'.$customer->trade_license3)}}"><img width="50" src="{{asset('upload/users/'.$customer->trade_license3)}}"></a>@endif
                                            </td>
                                            <td>{{ $customer->address }}</td>
                                            <td onclick="customerStatus({{ $customer->id }}, 'verify')"> @if($customer->verify) <span class="label label-success"> Verified </span> @else <span class="label label-danger">Unverify</span> @endif</td>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$customers->appends(request()->query())->links()}}
                  </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of total {{$customers->total()}} entries ({{$customers->lastPage()}} Pages)</div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
 
    <div class="modal fade" id="customerStatus_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Verify Status</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                                <form action="{{route('customerStatusUpdate')}}" method="POST">
                                {{csrf_field()}}
                               <div id="verify_form"></div>
                               <div class="modal-footer">
                                    <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Change Status</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-inverse">Close</button>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
  
@endsection
@section('js')

<script type="text/javascript">
    function customerStatus(id, verify){
        $('#verify_form').html('<div class="loadingData"></div>');
        $('#customerStatus_modal').modal('show');
        var  url = '{{route("customerStatus", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            data:{verify:verify},
            success:function(data){
                if(data){
                    $("#verify_form").html(data);
                }
            },
            // $ID = Error display id name
            @include('common.ajaxError', ['ID' => 'verify_form'])

        });
    }
    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("customer.edit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    }
</script>

@endsection
