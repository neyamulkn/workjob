@extends('layouts.admin-master')
@section('title', $staff->name.' | Profile')
@section('css')

    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .dropify-wrapper{
        height: 100px !important;
    }
    .title_head{
        width: 100%; margin-top: 5px; background: #8d8f90; color:#fff; padding: 10px;
    }

</style>
@endsection

@section('content')

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
                        <h4 class="text-themecolor">Profile</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">staff</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                            <a href="{{route('staff.list')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-angle-left"></i> Back</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center> <img src="{{asset('assets/images/users')}}/{{( $staff->photo) ? $staff->photo : 'default.png'}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$staff->name}}</h4>
                                    <h6 class="card-subtitle">{{$staff->user_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a title="User status" href="javascript:void(0)" class="link"><i class="fa fa-check"></i> <font class="font-medium">{{($staff->status == 1) ? 'Active' : 'Deactive'}} </font></a></div>
                                        <div class="col-6"><a title="Total Tickets " href="javascript:void(0)" class="link"><i class="fa fa-clipboard-list"></i> <font class="font-medium">{{Config::get('siteSetting.currency_symble'). $staff->wallet_balance}}</font></a></div>
                                    </div>
                                </center>
                                <hr/>
                                <small class="text-muted">Mobile</small>
                                <h6>{{$staff->mobile}}</h6> 
                                <small class="text-muted">Email</small>
                                <h6>{{$staff->email}}</h6> 

                                <small class="text-muted">Member Since </small>
                                <h6>{{Carbon\Carbon::parse($staff->created_at)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <small class="text-muted p-t-30 db">Birthday</small>
                                <h6>{{ Carbon\Carbon::parse($staff->birthday)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <p>Gender: {{ $staff->gender }}, Blood: {{ $staff->blood }}</p>
                                <small class="text-muted p-t-30 db">Address</small>
                               
                                
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-twitter"></i></button>
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-youtube"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-9 col-xlg-9 col-md-9">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><i class="fa fa-user"></i> Order</a> </li>
                               <!--  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab"> <i class="fa fa-chart-line"></i> Reports</a> </li> -->
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <label class="title_head">
                                            Order list
                                        </label>
                                        <div class="row">
                                            
                                            <div class="col-md-12 col-xs-6 b-r">
                                                <div class="table-responsive">
                                                   <table id="config-table" class="table display table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Order ID</th>
                                                                <th>Order Date</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                                <th>Payment Method</th>
                                                                <th>Payment Status</th>
                                                                <th>Delivery Status</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            <tr><td colspan="8"> <h1>No orders found.</h1></td></tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="settings" role="tabpanel">
                                    
                                    <div class="card-body">
                                        <label class="title_head">
                                        <i class="fa fa-reports"></i>Staff Reports
                                    </label>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
              
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <div class="modal bs-example-modal-lg" id="getOrderDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Order Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body" id="order_details"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
   
@endsection

@section('js')
    <script type="text/javascript">
        function order_details(id){
            $('#order_details').html('<div class="loadingData"></div>');
            $('#getOrderDetails').modal('show');
           
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){

                        $("#order_details").html(data);
                    }
                }
            });
        }
    </script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

   
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>
       <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>

@endsection

