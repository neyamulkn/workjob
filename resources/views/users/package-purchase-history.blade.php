@extends('layouts.frontend')
@section('title', 'Package History')
@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/stylish-tooltip.css') }}">
   <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
    	    .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    .label-return{background: #ff6226;}
    #content .card{border-radius: 5px; }
    .user-box{padding: 10px;    margin-bottom: 10px;}
    .card-title, .icon-box{color: #fff}
    .user-box a{    font-size: 3rem !important; color: #fff}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
    </style>
@endsection
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Job lists</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Job</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="{{route('post.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                    </div>
                </div>

		<div class="row">
			
			<!--Middle Part Start-->
			<div id="content" class="col-md-9 sticky-content">
				
				@if(Session::has('success'))
                <div class="alert alert-success">
                  <strong>Success! </strong> {{Session::get('success')}}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                  <strong>Error! </strong> {{Session::get('error')}}
                </div>
                @endif
			
				<form action="{{route('user.packageHistory')}}" id="orerControll" method="get">
                    <div class="row">
                                
                        <div class="col-md-4 col-6">
                            <div class="form-group">
                                
                                <input name="package" value="{{ Request::get('package')}}" type="text" placeholder="package name" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                    <option value="received" {{ (Request::get('status') == 'received') ? 'selected' : ''}}>Received</option>
                                   
                                    <option value="paid" {{ (Request::get('status') == 'paid') ? 'selected' : ''}}>Paid</option>
                                   
                                    <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All</option>
                                </select>
                            </div>
                        </div>  
                        
                        <div class="col-md-2 col-12">
                            <div class="form-group">
                                
                               <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="fa fa-search"></i> Search </button>
                            </div>
                        </div>
                    </div>
                </form>
		       
				<div class="table-responsive">
                    <table id="config-table" class="table display table-bordered ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="min-width: 100px;">Package</th>
                               
                                <th>Category</th>
                                <th>Post</th>
                                <th>Duration</th>
                                <th>Price</th>
                               
                                <th>Pay_method</th>
                                <th>Payment</th>
                                <th>Promote</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders)>0)
                                @foreach($orders as $index => $order)
                                @php $total_price = $order->price @endphp
                                <tr id="{{$order->order_id}}" @if($order->order_status == 'cancel') style="background:#ff000026" @endif >
                                    <td>{{(($orders->perPage() * $orders->currentPage() - $orders->perPage()) + ($index+1) )}}</td>
                                    <td><img width="30" src="{{asset('upload/images/package/'.$order->get_package->ribbon)}}"> {{ $order->get_package->name }}
                                       <p style="font-size: 12px;margin: 0;padding: 0"> {{\Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}<br/>
                                    {{\Carbon\Carbon::parse($order->order_date)->format('h:i:s A')}}</p>
                                    </td>

                                  
                                  	<td>{{($order->get_category) ? $order->get_category->name : 'Not found.' }}</td>
                                    <td>Total: {{$order->total_ads}} ads<br>
                                    Remaining: {{$order->remaining_ads}} ads</td>
                                    <td>{{$order->duration}} days</td>
                                    <td>
                                        {{$order->currency_sign}}{{$total_price }}
                                        
                                    </td>
                                   
                                    <td>{{ str_replace( '-', ' ', $order->payment_method) }}</td>
                                    <td> <span class="badge badge-{{($order->payment_status=='pending') ? 'danger' : 'success' }}">{{$order->payment_status}}</span></td>

                                    
                                    <td><a href="{{route('ads.promoteHistory', $order->get_package->slug)}}">History</a> </td>
                                </tr>
                               @endforeach
                            @else <tr><td colspan="8"> <h1>No package found.</h1></td></tr> @endif
                        </tbody>
                    </table>
                </div>

			</div>
			<!--Middle Part End-->
			
		</div>
	</div>
</div>

	
@endsection		
@section('js')
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


