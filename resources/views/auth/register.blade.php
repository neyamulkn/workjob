@extends('layouts.frontend')
@section('title', 'Register | '. Config::get('siteSetting.site_name') )
@php  

    $reCaptcha = App\Models\SiteSetting::where('type', 'google_recaptcha')->first(); 

    $socailLogins = App\Models\SiteSetting::where('type', 'facebook_login')->orWhere('type', 'google_login')->orWhere('type', 'twitter_login')->get(); 
   
@endphp
@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/user-form.css">

@if($reCaptcha->status == 1)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endsection
@section('content')

<section class="user-form-part">
            <div class="user-form-banner">
                <div class="user-form-content">
                    <a href="#"><img src="{{ asset('upload/images/logo/'.Config::get('siteSetting.logo') )}}" alt="logo"></a>
                    <h1>{{Config::get('siteSetting.site_name')}}</h1>
                    <p>{{Config::get('siteSetting.about')}}</p>
                </div>
            </div>

            <div class="user-form-category" style="padding-top: 10px;">
                
              
                <div class="tab-pane active" id="login-tab" >
                    
                    <div class="user-form-title">
                        <h2>Register</h2>
                        <p>Setup a new account in a minute.</p>
                    </div>
                    @if(count($socailLogins)>0)
                    <ul class="user-form-option">

                        @foreach($socailLogins as $socailLogin)
                        @if($socailLogin->type == 'facebook_login' && $socailLogin->status == 1)
                         <li >
                            <a class="facebook" href="{{route('social.login', 'facebook')}}">
                                <i class="fab fa-facebook-f"></i>
                                <span>facebook</span>
                            </a>
                        </li>
                        @endif
                        @if($socailLogin->type == 'google_login' && $socailLogin->status == 1)
                         <li>
                            <a class="google" href="{{route('social.login', 'google')}}">
                                <i class="fab fa-google"></i>
                                <span>google</span>
                            </a>
                        </li>
                        @endif
                        @if($socailLogin->type == 'twitter_login' && $socailLogin->status == 1)
                         <li>
                            <a class="twitter" href="{{route('social.login', 'twitter')}}">
                                <i class="fab fa-twitter"></i>
                                <span>twitter</span>
                            </a>
                        </li>
                        @endif
                        @if($socailLogin->type == 'linkedin_login' && $socailLogin->status == 1)
                        <li>
                            <a class="google" href="{{route('social.login', 'linkedin')}}">
                                <i class="fab fa-linkedin"></i>
                                <span>linkedin</span>
                            </a>
                        </li>
                        @endif
                      @endforeach
                    </ul>
                    @endif
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
                    <form action="{{route('userRegister')}}" id="loginform" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{old('name')}}" required class="form-control" placeholder="Name">
                                    <small class="form-alert">Please enter your full name</small>
                                    @if ($errors->has('name'))
                                        <span class="error" role="alert">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" value="{{old('emailOrMobile')}}" required name="emailOrMobile" class="form-control" placeholder="Email Or Mobile">
                                    
                                    @if ($errors->has('emailOrMobile'))
                                        <span class="error" role="alert">
                                            {{ $errors->first('emailOrMobile') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" required name="password" class="form-control" placeholder="Password">
                                    <button class="form-icon"><i class="eye fas fa-eye"></i></button>
                                    <small class="form-alert">Password must be 6 characters</small>
                                    @if ($errors->has('password'))
                                        <span class="error" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-12">
                                @if($reCaptcha->status == 1)
                                    <div class="form-group">
                                        
                                        <div class="g-recaptcha" data-sitekey="{{ $reCaptcha->public_key }}"></div>
                                        <span id="recaptcha-error" style="color: red"></span>
                                        
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input required type="checkbox" class="custom-control-input" id="signup-check">
                                        <label class="custom-control-label" for="signup-check">I agree to the all <a href="{{url('terms-conditions')}}">terms & consitions</a>.</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-inline">
                                        <i class="fas fa-user-check"></i>
                                        <span>Create new account</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="user-form-direction">
                        <p>Already have an account? click on the <a  href="{{url('login')}}" >( sign in )</a></p>
                    </div>
                    
                    
                </div>
                </div>

            </div>
        </section>
@endsection
@section('js')
<script type="text/javascript">
    @if($reCaptcha->status == 1)
        $("#loginform").submit(function(event) {

           var recaptcha = $("#g-recaptcha-response").val();
           if (recaptcha === "") {
              event.preventDefault();
              $("#recaptcha-error").html("Recaptcha is required");
           }
        });
    @endif
</script>
@endsection
