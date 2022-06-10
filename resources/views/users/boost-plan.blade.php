@extends('layouts.frontend')
@section('title', 'Boost ads  | '. Config::get('siteSetting.site_name') )

@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/price.css">
@endsection
@section('content')
	<div class="breadcrumbs">
		<div class="container">
			<ul class="breadcrumb-cate">
				<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
				<li><a href="#">Boost Ads</a></li>
			</ul>
		</div>
	</div>
	<!--=====================================
	             PRICE PART START
	=======================================-->
	<section class="price-part">
	    <div class="container">
	        <div class="row">
	            <div class="col-md-6 col-lg-4">
	                <div class="price-card">
	                    <div class="price-head">
	                        <i class="flaticon-bicycle"></i>
	                        <h3>$00</h3>
	                        <h4>Free Plan</h4>
	                    </div>
	                    <ul class="price-list">
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>1 Regular Ad for 7 days</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Credit card required</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Top or Featured Ad</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Ad will be bumped up</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>Limited Support</p>
	                        </li>
	                    </ul>
	                    <div class="price-btn">
	                        <a href="user-form.html" class="btn btn-inline">
	                            <i class="fas fa-sign-in-alt"></i>
	                            <span>Register Now</span>
	                        </a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6 col-lg-4">
	                <div class="price-card price-active">
	                    <div class="price-head">
	                        <i class="flaticon-car-wash"></i>
	                        <h3>$23</h3>
	                        <h4>Standard Plan</h4>
	                    </div>
	                    <ul class="price-list">
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>1 Recom Ad for 30 days</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Featured Ad Available</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Ad will be bumped up</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-times"></i>
	                            <p>No Top Ad Available</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>Basic Support</p>
	                        </li>
	                    </ul>
	                    <div class="price-btn">
	                        <a href="user-form.html" class="btn btn-inline">
	                            <i class="fas fa-sign-in-alt"></i>
	                            <span>Register Now</span>
	                        </a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6 col-lg-4">
	                <div class="price-card">
	                    <div class="price-head">
	                        <i class="flaticon-airplane"></i>
	                        <h3>$49</h3>
	                        <h4>Premium Plan</h4>
	                    </div>
	                    <ul class="price-list">
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>1 Featured Ad for 60 days</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>Access to All features</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>With Recommended</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>Ad Top Category</p>
	                        </li>
	                        <li>
	                            <i class="fas fa-plus"></i>
	                            <p>Priority Support</p>
	                        </li>
	                    </ul>
	                    <div class="price-btn">
	                        <a href="user-form.html" class="btn btn-inline">
	                            <i class="fas fa-sign-in-alt"></i>
	                            <span>Register Now</span>
	                        </a>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-lg-12">
	                <div class="section-center-heading">
	                    <h2>Do you have something to advertise?</h2>
	                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit aspernatur illum vel sunt libero voluptatum repudiandae veniam maxime tenetur.</p>
	                    <a href="ad-post.html" class="btn btn-outline">
	                        <i class="fas fa-plus-circle"></i>
	                        <span>post your ad</span>
	                    </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<!--=====================================
	             PRICE PART END
	=======================================-->
@endsection    
