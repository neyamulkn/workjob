@extends('layouts.frontend')
@section('title', 'My Account | '. Config::get('siteSetting.site_name') )

@section('content')
<div class="breadcrumbs">
	<div class="container">
		<ul class="breadcrumb-cate">
		    <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
		    <li><a href="#">My account</a></li>
		 </ul>
	</div>
</div>
<!-- Main Container  -->
<div class="container">

	<div class="row">
		<!--Right Part Start -->
		@include('users.inc.sidebar')
		<!--Middle Part Start-->
		<div id="content" class="col-md-9 sticky-conent">
		
			<form action="{{ route('user.profileUpdate') }}" method="post" data-parsley-validate>
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
								<input type="email" class="form-control" id="input-email" placeholder="E-Mail" value="{{ $user->email }}" name="email">
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
								<label for="blood" class="control-label">Blood Group</label>
								<select name="blood" class="form-control">
									<option value="">Select</option>
									<option @if( $user->blood == 'A+') selected @endif value="A+">A+</option>
									<option @if( $user->blood == 'A-') selected @endif value="A-">A-</option>
									<option @if( $user->blood == 'B+') selected @endif value="B+">B+</option>
									<option @if( $user->blood == 'B-') selected @endif value="B-">B-</option>
									<option @if( $user->blood == 'O+') selected @endif value="O+">O+</option>
									<option @if( $user->blood == 'O-') selected @endif value="O-">O-</option>
									<option @if( $user->blood == 'AB+') selected @endif value="AB+">AB+</option>
									<option @if( $user->blood == 'AB-') selected @endif value="AB-">AB-</option>
								</select>
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

						<div class="col-sm-12">
							<div class="form-group">
								<label for="about" class="control-label">About </label>
								<textarea class="form-control" maxlength="120" rows="1" id="user_dsc" name="user_dsc">{{ $user->user_dsc }}</textarea>
								<p>Max 120 character</p>
							</div>
						</div>
						
					</div>
					<div class="buttons clearfix">
						<div class="pull-right" style="text-align: right;">
							<input type="submit" class="btn btn-sm btn-primary" value="Save Changes">
						</div>
					</div>
			</form>

			<form action="{{ route('user.addressUpdate') }}" method="post" data-parsley-validate>
				@csrf
				<div class="row">
						<div class="col-sm-12">
							<fieldset id="personal-details">
							<legend>Address</legend></fieldset>
						</div>
						<div class="col-sm-4">
						<div class="form-group ">
							<span class="required">Select Your Region</span>
							<select name="region" onchange="get_city(this.value)" required id="input-payment-country" class="form-control">
								<option value=""> Please Select  </option>
								@foreach($states as $state)
								<option @if($user->region == $state->id) selected @endif value="{{$state->id}}"> {{$state->name}} </option>
								@endforeach
							</select>
						</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<span class="required">City</span>
								<select name="city" onchange="get_area(this.value)"  required id="show_city" class="form-control">
									
									<option value="">Please Select</option>
									@foreach($cities as $city)
									<option @if($user->city == $city->id) selected @endif value="{{$city->id}}"> {{$city->name}} </option>
									@endforeach
								</select>
							</div>
						</div>
					
						<div class="col-sm-12">
							<div class="form-group ">
								<span class="required">Address</span>
								<textarea class="form-control" id="address" placeholder="For example: #road:2, #sector: 3, Dhaka-1215" name="address">{{ $user->address }}</textarea>
								
							</div>
						</div>
						
					</div>
					<div class="buttons clearfix" style="text-align: right; margin-bottom: 5px;">
						<div class="pull-right">
							<input type="submit" class="btn btn-sm btn-primary" value="Save Changes">
						</div>
					</div>
			</form>
		</div>
		<!--Middle Part End-->
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
@endsection