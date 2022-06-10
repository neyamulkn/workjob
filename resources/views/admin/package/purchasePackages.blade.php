@extends('layouts.admin-master')
@section('title', 'package lists')
@section('css')
<link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .payment-method, .customer{ max-width: 150px !important; font-size: 12px; }
        .label-return{background: #ff6226;}
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){max-width: 100px;}
        #orerControll .form-control{padding: 3px;}

    </style>
    <!-- page CSS -->
    <link href="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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
                    <h4 class="text-themecolor"> Package History</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="btn btn-info btn-sm d-none d-lg-block m-l-15" href="{{ route('admin.packageList') }}"><i class="fa fa-eye"></i> Package lists</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->

            
                

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">
                        <form action="{{route('admin.packageList')}}" id="orerControll" method="get">
                            <div class="form-body">
                                <div class="card-body" style="padding-bottom: 0;">
                                    <div class="row">
                                        
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">Package</label>
                                                <input name="package" value="{{ Request::get('package')}}" type="text" placeholder="package name" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label"> Status  </label>
                                                <select name="status" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                <option value="received" {{ (Request::get('status') == 'received') ? 'selected' : ''}}>Received</option>
                                               
                                                <option value="paid" {{ (Request::get('status') == 'paid') ? 'selected' : ''}}>Paid</option>
                                               
                                                <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All</option>
                                            </select>
                                            </div>
                                        </div>  
                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">From Date</label>
                                                <input name="from_date" value="{{ Request::get('from_date')}}" type="date" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6">
                                            <div class="form-group">
                                                <label class="control-label">End Date</label>
                                                <input name="end_date" value="{{ Request::get('end_date')}}" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-6">
                                            <div class="form-group">
                                                <label class="control-label">.</label>
                                               <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <h3>
                            @if(Route::current()->getName() == 'package.search')
                                Total Record: ({{count($packages)}})
                            @endif
                        </h3>
                        <div class="table-responsive">
                            <table class="table display table-bpackageed table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Package</th>
                                        <th>Customer</th>
                                        
                                        <th>Category</th>
                                        <th>Total Ads</th>
                                        <th>Remaining Ads</th>
                                        <th>Duration</th>
                                        <th style="min-width: 100px;">Price</th>
                                        <th>Pay_method</th>
                                        <th>Payment</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($packages)>0)
                                        @foreach($packages as $index => $package)
                                        @php 

                                            $total_price = $package->price @endphp
                                        <tr id="{{$package->package_id}}" @if($package->order_status == 'cancel') style="background:#ff000026" @endif >
                                            <td>{{(($packages->perPage() * $packages->currentPage() - $packages->perPage()) + ($index+1) )}}</td>
                                           <td><img width="30" src="{{asset('upload/images/package/'.$package->get_package->ribbon)}}"> {{ $package->get_package->name }}
                                             <p style="font-size: 12px;margin: 0;padding: 0">
                                                {{\Carbon\Carbon::parse($package->package_date)->format(Config::get('siteSetting.date_format'))}} <br/>
                                           {{\Carbon\Carbon::parse($package->package_date)->format('h:i:s A')}}</p>
                                            </td>
                                           <td>{{ $package->customer_name }}
                                            <p style="font-size: 12px;margin: 0;padding: 0">{{ $package->mobile }}</p></td>

                                            <td>{{($package->get_category) ? $package->get_category->name : 'Not found.' }}</td>
                                            <td>{{$package->total_ads}} ads</td>
                                            <td>{{$package->remaining_ads}} ads</td>
                                            <td>{{$package->duration}} days</td>
                                            <td>
                                                {{$package->currency_sign}}{{$total_price }}
                                                 
                                            </td>
                                            <td class ="payment-method"> 
                                                <span class="mytooltip tooltip-effect-2">
                                                <span class="label label-{{($package->payment_method=='pending') ? 'danger' : 'success' }}">{{ str_replace( '-', ' ', $package->payment_method) }}</span>
                                               
                                                @if($package->payment_info)
                                                <span class="tooltip-content clearfix">
                                                <span class="tooltip-text">
                                                    @if($package->tnx_id)
                                                    <strong>Tnx_id:</strong> <span> {{$package->tnx_id}}</span><br/>
                                                    @endif
                                                    {{$package->payment_info}}
                                                </span> 
                                                </span>
                                                @endif
                                                </span>
                                            </td>
                                            <td>
                                                 
                                                <a href="javascript:void(0)" class="label btn-xs @if($package->payment_status == 'paid')  label-success @elseif($package->payment_status == 'received') label-info @else label-danger @endif">
                                                
                                                <span class="mytooltip tooltip-effect-2">
                                                <div @if($permission['is_edit']) @if($package->payment_status != 'paid') onclick="orderPaymentPopup('{{ route("packagePaymentDetails", $package->order_id)}}')"  @endif  @endif  title="package payment info" data-toggle="tooltip"  class="text-inverse p-r-10" >{{$package->payment_status}} </div>
                                                </span>
                                                </a>

                                            </td>

                                        </tr>
                                       @endforeach
                                    @else <tr><td colspan="8"> <h1>No packages found.</h1></td></tr> @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$packages->appends(request()->query())->links()}}
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of total {{$packages->total()}} entries ({{$packages->lastPage()}} Pages)</div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
   <div class="modal fade" id="getpackageDetails" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="padding: 5px 15px;">
                    <h4 class="modal-title" id="myLargeModalLabel">Package Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="package_details"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @if($permission['is_edit'])
    <div class="modal bs-example-modal-lg" id="orderPaymentModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update payment info.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                      {{Session::get('error')}}
                    </div>
                @endif
                <div class="modal-body" id="orderPaymentDetails"></div> 
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endif
@endsection
@section('js')

    <script type="text/javascript">
        function package_details(id){
            $('#package_details').html('<div class="loadingData"></div>');
            $('#getpackageDetails').modal('show');
            var  url = '{{route("admin.getpackageDetails", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#package_details").html(data);
                    $('.selectpicker').selectpicker();
                    $('#'+id).css("background-color", "rgb(0 255 231 / 14%)");
                }
            }
        });
        }

        @if($permission['is_edit'])
        function changepackageStatus(status, package_id) {
            if (confirm("Are you sure "+status+ " this package.?")) {
                var link = '{{route("admin.changepackageStatus")}}';
                $.ajax({
                    url:link,
                    method:"get",
                    data:{'status': status, 'package_id': package_id},
                    success:function(data){
                        if(data.status){
                            $('#getpackageDetails').modal('hide');
                            toastr.success(data.message);
                        }else{
                            toastr.error(data.message);
                        }
                    }
                });
            }
            return false;
        }     

        //package cancel
        function packageCancelPopup(route) {
            document.getElementById('packageCancelRoute').value = route;
        }

        function packageCancel(route) {
            //separate id from route
            var id = route.split("/").pop();

            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#ship_status"+id).html('cancel');
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }


        function orderPaymentPopup(link){
            $('#orderPaymentModal').modal('show');
            $('#orderPaymentDetails').html('<div class="loadingData"></div>');
            $.ajax({
                url:link,
                method:"get",
                success:function(data){
                    $('#orderPaymentDetails').html(data);
                }
            });
        }

        function changePaymentStatus(status, order_id) {
            if (confirm("Are you sure change payment status "+status+".?")) {
                var link = '{{route("changePaymentStatus")}}';
                $.ajax({
                    url:link,
                    method:"get",
                    data:{'status': status, 'order_id': order_id},
                    success:function(data){
                        if(data){
                            toastr.success(data.message);
                        }else{
                            toastr.error(data.message);
                        }
                    }
                });
            }
            return false;
        }  

        @endif   

    </script>

    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true, searching: false, paging: false, info: false, packageing: false
        });
    </script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
 
    <script src="{{asset('assets')}}/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
 
    <script>
        function checkField(value, field){
            if(value != ""){
                $.ajax({
                    method:'get',
                    url:"{{ route('checkField') }}",
                    data:{table:'package_payments', field:field, value:value},
                    success:function(data){
                        if(data.status){
                            $('#'+field).html("");
                            
                            $('#submitBtn').removeAttr('disabled');
                            $('#submitBtn').removeAttr('style', 'cursor:not-allowed');
                            
                        }else{
                            $('#'+field).html("<span style='color:red'><i class='fa fa-times'></i> "+data.msg+"</span>");
                            
                            $('#submitBtn').attr('disabled', 'disabled');
                            $('#submitBtn').attr('style', 'cursor:not-allowed');
                            
                        }
                    },
                    error: function(jqXHR, exception) {
                        toastr.error('Unexpected error occur.');
                    }
                });
            }else{
                $('#'+field).html("<span style='color:red'>"+field +" is required</span>");
                $('#submitBtn').attr('disabled', 'disabled');
                $('#submitBtn').attr('style', 'cursor:not-allowed');   
            }
        }
        $(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">

    $(".select2").select2();
    </script>
 
    <script type="text/javascript">
        function reviewModal(package_id, product_id){
            $('#reviewModal').modal('show');
            $("#getReviewForm").html("<div class='loadingData-sm'></div>");
            $.ajax({
                url:'{{route("adminGetReviewForm")}}',
                type:'get',
                data:{package_id:package_id,product_id:product_id},
                success:function(data){
                    if(data){
                       $('#getReviewForm').html(data);
                    }else{
                      toastr.error(data);
                    }
                }
            });
         }
    </script>
@endsection
