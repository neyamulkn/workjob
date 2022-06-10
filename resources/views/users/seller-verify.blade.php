@extends('layouts.frontend')
@section('title', 'Seller Verification')

@section('css')
 <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.dropify-wrapper{height: 125px;padding: 5px;}
	    .adjust-field{cursor: pointer; border: none;border-radius:0;position: absolute;top: 0;right: 0;background: #e9ecef;padding: 7px;}

	    .dropify-wrapper.touch-fallback{height: 115px!important;}
.dropify-wrapper{height: 120px!important;padding: 5px; overflow: hidden ;}
 @media (max-width: 768px) { label.required{font-size: 12px;}
.dropify-wrapper .dropify-message{top: initial;}}
.dropify-wrapper.touch-fallback .dropify-clear{top: 3px; right: 3px; bottom: inherit;}
.fa-check-square{color: green;}
  .addNumber{position: relative;margin-right: 10px;width: 320px;border-bottom: 1px solid #e5e5e5;padding: 5px;}
  .removeNumber{color:red;padding: 3px 5px;}
</style>
@endsection
@section('content')
<div class="breadcrumbs">
	<div class="container">
		<ul class="breadcrumb-cate">
		    <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
		    <li><a href="#">Account Verify</a></li>
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
		
			<form action="{{ route('verifyAccount') }}" method="post" enctype="multipart/form-data" data-parsley-validate>
				@csrf
				<div class="row">
						<div class="col-sm-12">
						<fieldset id="personal-details">
							<legend>Seller Verification</legend></fieldset>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="name" class="control-label required">Full Name</label>
								<input type="text" required class="form-control" id="name" placeholder="Full Name" value="{{ $user->name }}" name="name">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="shop_name" class="control-label required">Shop Name</label>
								<input type="text" required class="form-control" id="shop_name" placeholder="Shop Name" value="{{ $user->shop_name }}" name="shop_name">
							</div>
						</div>

						
						
						<div class="col-sm-6">
							<label for="mobile" class="control-label required">Mobile Number</label>
							<div class="form-group" id="moreMobile" style="position: relative;">
								
								<input type="text" disabled class="form-control" id="mobile" placeholder="Enter Mobile" value="{{ $user->mobile }}" name="mobile">
								<span class="adjust-field">
                                    <label onclick="moreMobile()"><small>Chnage Number</small></label>
                                </span>
							</div>
						</div>
						<div class="col-sm-6">
							<label for="input-email" class="control-label required">E-Mail Address</label>
							<div class="form-group" id="moreEmail" style="position: relative;">
								
								<input type="email" disabled class="form-control" id="input-email" placeholder="E-Mail" value="{{ $user->email }}" name="email">
								<span class="adjust-field">
                                    <label onclick="moreEmail()"><small>Chnage Email</small></label>
                                </span>
							</div>
						</div>

						
						<div class="col-4 col-md-3" style="padding-right: 5px;padding-top: 5px;">   
							<label class="required">Your Photo</label>                         
							<input type="file" @if($user->photo) data-default-file="{{asset('upload/users/'.$user->photo)}}" @else required @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="photo">
                        </div>

                        <div class="col-4 col-md-3" style="padding: 5px;">   
							<label class="required">NID Front Side</label>                         
							<input type="file" @if($user->nid_front) data-default-file="{{asset('upload/users/'.$user->nid_front)}}" @else required @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="nid_front" >
                        </div>

                        <div class="col-4 col-md-3" style="padding: 5px;">   
							<label class="required">NID Back Side</label>                         
							<input type="file" @if($user->nid_back) data-default-file="{{asset('upload/users/'.$user->nid_back)}}" @else required @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="nid_back"  >
                        </div>

                        <div class="col-12">   
                        	<div class="form-group " style="margin-top: 10px;">
							<label class="required">Upload Trade License</label>   
							<div class="row">
							<div class="col-4 col-md-3" style="padding-right: 5px;padding-top: 5px">                      
							<input type="file" @if($user->trade_license) data-default-file="{{asset('upload/users/'.$user->trade_license)}}" @else required @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" name="trade_license" ></div>
							<div class="col-4 col-md-3" style="padding: 5px;">
							<input type="file" @if($user->trade_license2) data-default-file="{{asset('upload/users/'.$user->trade_license2)}}" @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" name="trade_license2"></div>
							<div class="col-4 col-md-3" style="padding: 5px;">
							<input type="file" @if($user->trade_license3) data-default-file="{{asset('upload/users/'.$user->trade_license3)}}" @endif data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" name="trade_license3"></div>
							</div>
							</div>
                        </div>

						<div class="col-sm-6">
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
						<div class="col-sm-6">
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
								<span class="required">Shop Address</span>
								<textarea required class="form-control" id="address" placeholder="For example: #road:2, #sector: 3, Dhaka-1215" name="address">{{ $user->address }}</textarea>
								
							</div>
						</div>
						
					</div>
					<div class="buttons clearfix">
						@if($user->verify)
						<h3>Your account allready verified.</h3>
						@else
						<div class="pull-right">
							<input type="submit" class="btn btn-md btn-primary" value="Verify Account">
						</div>
						@endif
					</div>
					<br>
			</form>
		</div>
		<!--Middle Part End-->
	</div>
</div>
<!-- //Main Container -->
@endsection

@section('js')
<script src="{{ asset('js/parsley.min.js') }}"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
</script>
<script type="text/javascript">

	    function moreMobile(number=null){
       
        $('#moreMobile').html(`
        <div style="display:flex; margin-bottom: 10px;">
        
        <div style="position: relative;width: 100%;">
        <input type="number" id="number" value="`+number+`" required name="contact_mobile" class="form-control" placeholder="Enter your number">
        <span class="adjust-field" onclick="addNumber()"> Add</span>
       
        </div>
        </div>`);
    }

    function addNumber(){
       var number = $('#number').val();
        if(number){
        $.ajax({
            url:"{{route('addNumber')}}",
            method:'get',
            data:{number:number},
            success:function(data){
                $('#moreMobile').html(data);
            }
        });
        }
    }

    function verifyNumber(number){

       var otp = $('#otp').val();
        if(otp){
        $.ajax({
            url:"{{route('verifyNumber')}}",
            method:'get',
            data:{otp:otp,number:number},
            success:function(data){
                if(data.status){
                    $('#moreMobile').html(data.number);
                    
                }else{
                    $('#optmsg').html('<span style="color:red">Invalid otp code.</span>')
                }
            }
        });
        }else{
            $('#optmsg').html('<span style="color:red">Please enter otp</span>')
        }
    }

    function removeNumber(number) {
       $('#'+number).remove();
       if($('.contact_mobile').val() == null){
            moreMobile();
       }
    }


     function moreEmail(email=''){
       
        $('#moreEmail').html(`
        <div style="display:flex; margin-bottom: 10px;">
        
        <div style="position: relative;width: 100%;">
        <input type="email" id="email" value="`+email+`" required name="email" class="form-control" placeholder="Enter your email">
        <span class="adjust-field" onclick="addEmail()"> Add</span>
       
        </div>
        </div>`);
    }

    function addEmail(){
       var email = $('#email').val();
        if(email){
        $.ajax({
            url:"{{route('addEmail')}}",
            method:'get',
            data:{email:email},
            success:function(data){
                $('#moreEmail').html(data);
            }
        });
        }
    }

    function verifyEmail(email){

       var code = $('#code').val();
        if(code){
        $.ajax({
            url:"{{route('verifyEmail')}}",
            method:'get',
            data:{code:code,email:email},
            success:function(data){
                if(data.status){
                    $('#moreEmail').html(data.email);
                    
                }else{
                    $('#codemsg').html('<span style="color:red">Invalid verify code.</span>')
                }
            }
        });
        }else{
            $('#codemsg').html('<span style="color:red">Please enter verify code</span>')
        }
    }

    function removeEmail(email) {
       $('#'+email).remove();
       if($('.contact_email').val() == null){
            moreEmail();
       }
    }

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