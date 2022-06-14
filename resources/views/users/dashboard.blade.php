@extends('layouts.frontend')
@section('title', 'Dashboard | '. Config::get('siteSetting.site_name') )
@section('css')
 <link rel="stylesheet" href="{{asset('frontend')}}/css/custom/dashboard.css">
<style type="text/css">
    .country-state li {
    margin-top: 0px;
    margin-bottom: 10px;
}
</style>
@endsection
@section('content')
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="margin-top:10px">

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center> <img src="{{asset('upload/users')}}/{{( $user->photo) ? $user->photo : 'default.png'}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$user->name}}</h4>
                                    <h6 class="card-subtitle">{{$user->user_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a title="User status" href="javascript:void(0)" class="link"><i class="fa fa-check"></i> <font class="font-medium">{{$user->status}} </font></a></div>
                                        <div class="col-6"><a title="Total Tickets " href="javascript:void(0)" class="link"> @if($user->verify) <span class="label label-success"> Verified </span> @else <span class="label label-danger">Unverify</span> @endif</a></div>
                                    </div>
                                </center>
                                <hr/>
                                <small class="text-muted">Mobile</small>
                                <h6>{{$user->mobile}}</h6> 
                                <small class="text-muted">Email</small>
                                <h6>{{$user->email}}</h6> 

                                <small class="text-muted">Member Since </small>
                                <h6>{{Carbon\Carbon::parse($user->created_at)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <small class="text-muted p-t-30 db">Birthday</small>
                                <h6>{{ Carbon\Carbon::parse($user->birthday)->format(Config::get('siteSetting.date_format'))}}</h6> 
                                <p>Gender: {{ $user->gender }}, Blood: {{ $user->blood }}</p>
                                <small class="text-muted p-t-30 db">Address</small>
                                <h6>{{ $user->address }} 
                                    @if($user->get_area){{ $user->get_area['name']}} @endif
                                    @if($user->get_city) {{$user->get_city['name']}} @endif
                                    @if($user->get_state){{ $user->get_state['name'] }} @endif</h6>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>{{$total_posts}}</h3>
                                                <h6 class="card-subtitle">Total Post</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>{{$pending_posts}}</h3>
                                                <h6 class="card-subtitle">Pending Post</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>{{$total_task }}</h3>
                                                <h6 class="card-subtitle">Total Task</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>{{$pending_task}}</h3>
                                                <h6 class="card-subtitle">Pending Task</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Working</h4>
                                <table class="table no-border">
                                    <tbody>
                                        <tr>
                                            <td><h4>Task Attend</h4></td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Satisfied</h4> 
                                                <small>Approved in task</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Not Satisfied</h4> 
                                                <small>Rejected in task prove</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Pending</h4> 
                                                <small>In review for rating</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Deleted/Removed task</h4> 
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Payment Received</h4> 
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                  
                </div>
                
            </div>
        </div>
@endsection     
    


