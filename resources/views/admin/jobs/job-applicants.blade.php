 @extends('layouts.admin-master')
@section('title', $post->title)
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
                        <h4 class="text-themecolor">{{$post->title}}</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Applicants</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="{{route('admin.product.list')}}" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Post list</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                     <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                        
                        <table id="config-table" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Earn</th>
                                    <th>Submit Date</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead> 
                            <tbody>
                                @if(count($jobApplicants)>0)
                                @foreach($jobApplicants as $index => $applicant)
                                <tr id="item{{$post->id}}">
                                    <td>{{$index+1}}</td>
                                    
                                    <td><a target="_blank" href="{{ route('jobApplicantDetails',[$applicant->id, $applicant->user->username]) }}"> {{$applicant->user->name}} </a></td>
                                    <td>{{Config::get('siteSetting.currency_symble').$applicant->amount}}</td>
                                    
                                    <td>{{Carbon\Carbon::parse($applicant->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                    <td>
                                        <span style="cursor:pointer;" class="label @if($applicant->status == 'accepted') label-success @elseif($applicant->status == 'reject') label-danger @else label-info @endif" title="Applicant Status (pending, active, reject)" 
                                         > {{$applicant->status}}</span>
                                        @if($applicant->status == 'reject') <p>Reason: {{$applicant->reject_reason}}</p> @endif
                                    </td>
                                   
                                </tr>
                                @endforeach
                                @else
                                <tr style="text-align: center;"><td colspan="8">Applicant not found.!</td></tr>
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
