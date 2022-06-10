@extends('layouts.frontend')
@section('title', 'wishtlist | '. Config::get('siteSetting.site_name') )
@section('css')

@endsection
@section('content')
<div class="breadcrumbs">
  <div class="container">
    
    <ul class="breadcrumb-cate">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">Wishtlist</a></li>
     </ul>
  </div>
</div>
<!-- Main Container  -->
<div class="container">
    <div class="row">
        @include('users.inc.sidebar')
        <div id="content" class="col-sm-9 sticky-content dash-header-card">
            <h2>My Wish List</h2>
            @if(count($wishlists)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-center">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-right">Price</td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlists as $wishlist)
                            <tr id="item{{$wishlist->id}}">
                                <td class="text-center">
                                    <a href="{{route('post_details', $wishlist->get_product->slug)}}"><img src="{{asset('upload/images/product/thumb/'. $wishlist->get_product->feature_image)}}" width="48" height="40" class="img-thumbnail"></a>
                                </td>
                                <td class="text-left"><a href="{{route('post_details', $wishlist->get_product->slug)}}">{{Str::limit($wishlist->get_product->title, 30)}}</a></td>
                                <td class="text-right">
                                    <div class="price">{{Config::get('siteSetting.currency_symble') . $wishlist->get_product->price}} </div>
                                </td>
                                <td class="text-right">
                                    
                                    <a href="#" onclick="deleteConfirmPopup('{{route("wishlist.remove", $wishlist->id)}}')" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-times"></i></a></td>
                            </tr>
                           @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{url('/')}}" class="btn btn-primary">Continue</a></div>
                </div>
            @else
                
                <div style="text-align: center;">
                    <i style="font-size: 80px;" class="fa fa-heart"></i>
                    <h1>Your wishlist is empty.</h1>
                    <p>Looks line you have no items in your wishlist list.</p>
                    Click here <a href="{{url('/')}}">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>

</div>	
@include('users.modal.delete-modal')
<!-- //Main Container -->
@endsection	   
  


