@extends('layouts.admin-master')
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
                    	<div class="row">
		                    <div class="col-6">
		                        <div class="card">
		                            <div class="card-body">
		                                <h4 class="card-title">Worker Done</h4>
		                                <div style="display: flex;justify-content: space-between;">
		                                	<div>
                                                
		                                		<span class="text-success"> {{$post->job_tasks_count}} OF {{$post->job_workers_need}}</span>
				                                <div class="progress" style="width:200px">
				                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{\App\Http\Controllers\HelperController::workerProgress($post->job_tasks_count, $post->job_workers_need)}}%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				                                </div>
		                                	</div>
			                                <div class="text-right"> 
			                                    <h1 class="font-light"><sup><i class="ti-check-box text-primary"></i></sup> </h1>
			                                </div>
		                            	</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-6">
		                        <div class="card">
		                            <div class="card-body">
		                                <h4 class="card-title">YOU CAN EARN</h4>
		                                <div class="text-right"> 
		                                    <h1 class="font-light"> {{Config::get('siteSetting.currency_symble') . $post->per_workers_earn}}</h1>
		                                </div>
		                                
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <form @if(!$post->userJobTask) action="{{route('jobWork.store', $post->slug)}}" method="post" data-parsley-validate enctype="multipart/form-data" @endif> 
                        @csrf
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item" style="padding:10px"><h3>{{$post->title}} </h3></li>
                            </ul>
                            
                            <div class="card-body">
                            	<img src="{{asset('upload/images/post/'.$post->thumb_image)}}">
                        		<div class="row" style="margin:20px -10px;">
					                <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"> <i class="fas fa-tags"></i>@if($post->get_category) {{$post->get_category->name}} @endif @if($post->get_category) - {{$post->get_subcategory->name}} @endif</span></h5></b>
						            </div>

						             <div class="col-sm-6"> <b> <h5>
						                <span style="padding: 5px" class="card-text text-muted">
						                    <i class="fas fa-globe"></i> @foreach($locations as $location)  {{$location->name}},  @endforeach</span></h5></b>
						            </div>
						            
						            <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"> <i class="fa fa-hourglass-half "></i> Time {{$post->estimated_time}}</span></h5></b>
						            </div>

						            <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"><i class="fa fa-clock"></i> Last Updated- {{ Carbon\Carbon::parse($post->updated_at)->format('d M, Y H:i:s') }}</span></h5></b>
						            </div>
						        </div>
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
                            	<h4><i class="fa fa-pencil-alt"></i> SUBMIT REQUIRED WORK PROVE?</h4>
                              	<div class="details">
                                    <textarea required type="text" name="work_prove" rows="3" class="form-control" placeholder="Write description" id="completed">@if($post->userJobTask){{$post->userJobTask->work_prove}}@endif</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body row work_screenshot">
                                @if($post->userJobTask && $post->userJobTask->screenshots)
                                    @foreach(json_decode($post->userJobTask->screenshots) as $i => $screenshot)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="screenshot{{$i+1}}"><span class="label label-inverse">{{$i+1}}</span> UPLOAD SCREENSHOT PROVE </label>
                                            <input required type="file" id="screenshot{{$i+1}}" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" data-default-file="{{asset('upload/images/jobs/'.$screenshot)}}" accept="image/*" name="screenshot[]">
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @for($i=1; $i<=$post->work_screenshots; $i++)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="screenshot{{$i}}"><span class="label label-inverse">{{$i}}</span> UPLOAD SCREENSHOT PROVE </label>
                                            <input required type="file" id="screenshot{{$i}}" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" accept="image/*" name="screenshot[]">
                                        </div>
                                    </div>
                                    @endfor
                                @endif
                            	
                            </div>

                            <div class="card-body text-right">
                                @if($post->userJobTask)
                                <h3 style="text-align:center;color: red;">Job Already Submited.</h3>
                                @else
                                <button style="width: 100%;" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Submit Job</span>
                                </button>
                                @endif
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
                                	<img src="{{asset('upload/users')}}/{{($post->user && $post->user->photo) ? $post->user->photo : 'default.png'}}" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$post->user->name}}</h4>
                                    <h6 class="card-subtitle">{{$post->user->user_dsc}}</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-12">

                                        	<h6>Since {{ Carbon\Carbon::parse($post->user->created_at)->format('d M, Y') }}</h6>
                                        	<h6>Reviews(0) </h6>
                                       		@if($post->user->verify) <span class="label label-success"> Verified </span> @else <span class="label label-danger">Unverify</span> @endif
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
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
@endsection

