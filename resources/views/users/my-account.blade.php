@extends('layouts.frontend')
@section('title', 'My Account | '. Config::get('siteSetting.site_name') )

@section('css')
 <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <div class="card">
            <div class="card-body">
            	<div class="row offset-md-2">
            		<div class="col-md-8 ">
					<form action="{{ route('user.profileUpdate') }}" enctype="multipart/form-data" method="post" data-parsley-validate>
						@csrf
						<div class="row">
								<div class="col-sm-12">
								<fieldset id="personal-details">
									<legend>Personal Details</legend></fieldset>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="name" class="control-label required">Full Name</label>
										<input type="text" class="form-control" id="name" placeholder="Full Name" value="{{ $user->name }}" name="name">
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group">
										<label for="mobile" class="control-label required">Mobile Number</label>
										<input type="text" class="form-control" id="mobile" placeholder="Enter Mobile" value="{{ $user->mobile }}" name="mobile">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="input-email" class="control-label required">E-Mail Address</label>
										<input type="email" disabled class="form-control" id="input-email" placeholder="E-Mail" value="{{ $user->email }}" name="email">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form-group">
										<label for="birthday" class="control-label">Birthday</label>
										<input type="date" class="form-control" id="birthday" placeholder="birthday" value="{{ $user->birthday }}" name="birthday">
									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group">
										<label for="gender" class="control-label">Gender</label>
										<select name="gender" id="gender" class="form-control">
											<option value="">Select</option>
											<option @if( $user->gender == 'male') selected @endif value="male">Male</option>
											<option @if( $user->gender == 'female') selected @endif value="female">Female</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
								<div class="form-group ">
									<span class="required">Country</span>
									<select name="country" disabled required id="input-payment-country" class="form-control">
										<option value=""> Please Select  </option>
										@foreach($states as $country)
										<option @if($user->country == $country->id) selected @endif value="{{$country->id}}"> {{$country->name}} </option>
										@endforeach
									</select>
								</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label for="about" class="control-label">About </label>
										<textarea class="form-control" maxlength="120" rows="3" id="user_dsc" name="user_dsc">{{ $user->user_dsc }}</textarea>
										
									</div>
								</div>
								<div class="col-md-6" style="padding-right: 5px;padding-top: 5px;">   
									<label class="required">Your Photo</label>                         
									<input type="file" @if($user->photo) data-default-file="{{asset('upload/users/'.$user->photo)}}" @else required @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="photo">
		                        </div>
							</div>
							<div class="buttons clearfix">
								<div class="pull-right" style="text-align: right;">
									<input type="submit" class="btn btn-sm btn-primary" value="Save Changes">
								</div>
							</div>
					</form>

					
				</div>
				</div>
		</div>
		<!--Middle Part End-->
	</div>
	</div>
	</div>

<!-- //Main Container -->
@endsection

@section('js')

<script type="text/javascript">
	 function get_city(id, type=''){
       
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_city"+type).html(data);
                    $("#show_city"+type).focus();
                }else{
                    $("#show_city"+type).html('<option>City not found</option>');
                }
            }
        });
    }  	 

    function get_area(id, type=''){
           
        var  url = '{{route("get_area", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_area"+type).html(data);
                    $("#show_area"+type).focus();
                }else{
                    $("#show_area"+type).html('<option>Area not found</option>');
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
@endsection