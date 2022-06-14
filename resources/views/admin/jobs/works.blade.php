 @extends('layouts.admin-master')
@section('title', 'All works')
@section('css')
<style type="text/css">
.progress{background-color: #dddedf;}
.clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { text-align: center; font-size: 14px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}
.work_screenshot label{font-size: 12px;margin-bottom: 5px;}
    .details{padding: 10px;}
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
                        <h4 class="text-themecolor">My works</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Works</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="{{route('myJobs')}}" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Job list</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
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
                        <form action="" method="get">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <input name="title" placeholder="Title" value="{{ Request::get('title')}}" type="text" class="form-control">
                                    </div>
                                    <div class="col-6 col-md-3" style="margin-bottom: 5px;">
                                        <select name="status" class="form-control">
                                            <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                            <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                            <option value="accepted" {{ (Request::get('status') == 'accepted') ? 'selected' : ''}}>Accepted</option>
                                           
                                            <option value="reject" {{ (Request::get('status') == 'reject') ? 'selected' : ''}}>Reject</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group" >
                                           <button type="submit" class="form-control btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                        
			                        <table id="config-table" class="table table-hover table-bordered table-striped">
			                            <thead>
			                                <tr>
			                                    <th>#</th>
			                                    <th>User</th>
                                                <th>Job Name</th>
			                                    <th>Earn</th>
			                                    <th>Date</th>
			                                    <th>Status</th>
			                                    <th>Action</th>
			                                </tr>
			                            </thead> 
			                            <tbody>
			                                @if(count($myWorks)>0)
			                                @foreach($myWorks as $index => $myWork)
			                                <tr id="item{{$myWork->id}}">
			                                    <td>{{$index+1}}</td>
                                                <td>{{$myWork->user->name}}</td>
			                                    
			                                    <td><a target="_blank" href="{{ route('job_details',[$myWork->job->slug]) }}"> {{$myWork->job->title}} </a></td>
			                                    <td>{{Config::get('siteSetting.currency_symble').$myWork->amount}}</td>
			                                    
			                                    <td>{{Carbon\Carbon::parse($myWork->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
			                                    <td>
			                                        <span style="cursor:pointer;" class="label @if($myWork->status == 'accepted') label-success @elseif($myWork->status == 'reject') label-danger @else label-info @endif" title="myWork Status (pending, active, reject)" 
			                                         > {{$myWork->status}}</span>
			                                    </td>
			                                    <td>
			                                         <a target="_blank" class="btn-sm btn-info" title="View job details" href="{{ route('job_details',[$myWork->job->slug]) }}"><i class="ti-eye"></i> View job </a>                        
			                                    </td>
			                                </tr>
			                                @endforeach
			                                @else
			                                <tr style="text-align: center;"><td colspan="8">You Have No Work.!</td></tr>
			                                @endif
			                            </tbody>
			                        </table>
			                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
@endsection
