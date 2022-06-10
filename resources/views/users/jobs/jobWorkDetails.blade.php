
@extends('layouts.frontend')
@section('title', $post->title . ' | '. Config::get('siteSetting.site_name') )
@section('css')
 <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
    .dropify-wrapper{height: 150px!important;padding: 5px; overflow: hidden ;}
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
           
                <div class="row">
                   
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        
                        <form action="{{route('applicantStatusUpdate', $applicant->id)}}" method="post" data-parsley-validate enctype="multipart/form-data"> 
                        @csrf
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item" style="padding:10px"><h3>{{$post->title}} </h3></li>
                            </ul>
                            
                            <div class="card-body">
                                <img src="{{asset('upload/images/post/'.$post->thumb_image)}}">
                               
                                <h4><i class="fa fas fa-tasks"></i> What is expected from workers?</h4>
                               @if($post->workstep)
                                @foreach(json_decode($post->workstep) as $index => $workstep)
                                <div  class="details">
                                    {{$workstep}}
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4><i class="fa fas fa-tasks"></i> REQUIRED PROOF THAT TASK WAS FINISHED?</h4>
                                <div class="details">{{$post->workProve}}</div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4><i class="fa fa-pencil-alt"></i>WORK PROVE DETAILS?</h4>
                                <div class="details">
                                    {!! $applicant->work_prove !!}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body row work_screenshot">
                                <div class="col-12">WORK PROVE SCREENSHOT</div> 
                                @if($applicant->screenshots)
                                    @foreach(json_decode($applicant->screenshots) as $i => $screenshot)
                                    <div class="col-md-6">
                                        <label for="screenshot{{$i}}"><span class="label label-inverse">{{$i+1}}</span> SCREENSHOT </label>
                                        <a target="_blank" href="{{asset('upload/images/jobs/'.$screenshot)}}"><img src="{{asset('upload/images/jobs/'.$screenshot)}}" style="width:100%"></a>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select required onchange="rejectReason(this.value)" name="status" class="form-control">
                                        <option value="" >Select Status</option>
                                        <option value="pending" @if($applicant->status == 'pending') selected @endif >Pending</option>
                                        <option value="accepted" @if($applicant->status == 'accepted') selected @endif>Accepted</option>
                                        <option value="reject" @if($applicant->status == 'reject') selected @endif>Reject</option>
                                    </select>
                                </div>


                                <div class="form-group" id="rejectReason">@if($applicant->status == 'reject')<div class="form-group"><label>Reject reason</label><textarea name="reject_reason" required class="form-control" placeholder="Write job reject reason">{!! $applicant->reject_reason !!}</textarea></div>@endif</div>

                                <button style="width: 100%;" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Applicant Update</span>
                                </button>
                                
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- Column -->
                     <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <img src="{{asset('upload/users')}}/{{($applicant->user && $applicant->user->photo) ? $applicant->user->photo : 'default.png'}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$applicant->user->name}}</h4>
                                    <h6 class="card-subtitle">{{$applicant->user->user_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-12">

                                            <h6>Since {{ Carbon\Carbon::parse($applicant->user->created_at)->format('d M, Y') }}</h6>
                                            <h6>Reviews(0) </h6>
                                            @if($applicant->user->verify) <span class="label label-success"> Verified </span> @else <span class="label label-danger">Unverify</span> @endif
                                        </div>
                                    </div>
                                </center>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
@endsection

@section('js')
    <script>
         
        function rejectReason(status) {
            if(status == 'reject'){
                $('#rejectReason').html(`<div class="form-group"><label>Write reject issue</label><textarea name="reject_reason" class="form-control" required placeholder="Write job reject reason">{!! $applicant->reject_reason !!}</textarea></div>`);
            }else{
                 $('#rejectReason').html('');
            }

        }
</script>
@endsection
