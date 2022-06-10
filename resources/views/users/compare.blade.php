@extends('layouts.frontend')
@section('title', 'Product Comparison | '. Config::get('siteSetting.site_name') )
@section('content')
	<div class="breadcrumbs">
		<div class="container">
			<ul class="breadcrumb-cate">
				<li><a href="{{url('/')}}"><i class="fa fa-home"></i></a></li>
				<li><a href="#">Product Comparison</a></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div id="content" class="col-sm-12">
				<h1>Product Comparison</h1>
				@if(count($products)>0)
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<td colspan="{{count($products)+1}}"><strong>Product Details</strong></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Product</td>
								@foreach($products as $product)
								<td><a href="{{route('post_details', $product->slug)}}">{{$product->title}}</a></td>
              					@endforeach
							</tr>
							<tr>
								<td>Image</td>
								@foreach($products as $product)
								<td class="text-center"> <img src="{{asset('upload/images/product/thumb/'. $product->feature_image)}}"  /> </td>
								@endforeach

							</tr>
							<tr>
								<td>Price</td>
								@foreach($products as $product)
								<td>{{Config::get('siteSetting.currency_symble')}}{{$product->price}}</td>
								@endforeach
							</tr>
						
							<tr>
								<td>Brand</td>
								@foreach($products as $product)
								@php
									$brand = DB::table('brands')->where('id', $product->brand_id)->first()
								@endphp
								<td>{{ ($brand) ? $brand->name : 'N/A' }}</td>
								@endforeach
							</tr>
							
							
						</tbody>

						<tr>
							<td></td>
							
								@foreach($products as $product)
								<td>
								<a href="javascript:void(0)" onclick="removeItem('{{route("productCompareRemove",$product->id)}}')" title="Remove " class="btn btn-danger btn-block">Remove</a></td>
								@endforeach
						</tr>
					</table>
				</div>
				@else
				
				<div style="text-align: center;">
				    <i style="font-size: 80px;" class="fa fa-history"></i>
				    <h1>Your comparison list is empty.</h1>
				    <p>Looks line you have no items in your comparison list.</p>
				    Click here <a href="{{url('/')}}">Continue Shopping</a>
				</div>
				@endif
			</div>
		</div>
	</div>
    <!-- //Main Container -->
 @endsection    

 @section('js')

 <script type="text/javascript">
 	    function removeItem(route) {
        //separate id from route
        var id = route.split("/").pop();
       
        $.ajax({
            url:route,
            method:"get",
            success:function(data){
                if(data.status){
                   
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
    }
 </script> 
  @endsection    
