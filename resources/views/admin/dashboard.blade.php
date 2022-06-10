@extends('layouts.admin-master')
@section('title', 'Dashboard')
@section('css')
    <link href="{{ asset('assets/node_modules') }}/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="{{ asset('css') }}/pages/dashboard1.css" rel="stylesheet">
    <style type="text/css">.round{font-size:25px;}.display-5{font-size: 2rem !important;}</style>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
      <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid dashboard1"><br/>
               
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-success text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-cart-plus"></i> 
                                <a href="{{route('admin.product.list')}}" class="text-white">{{$allPosts}}</a></h1>
                                <h6 class="text-white">Total Posts</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-info text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-hourglass-half"></i> 
                                <a href="{{route('admin.product.list', 'pending')}}" class="text-white">{{$pendingPosts}}</a></h1>
                                <h6 class="text-white">Pending Posts</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-warning text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-database"></i> 
                                <a href="{{route('admin.packageList')}}" class="text-white">{{$promoteAdPosts}}</a></h1>
                                <h6 class="text-white">Promote Ads</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-danger text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-times"></i> 
                                <a href="{{route('brand')}}" class="text-white">{{$brands}}</a></h1>
                                <h6 class="text-white">Brands</h6>
                            </div>
                        </div>
                    </div>
                </div>
                
              
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-user-plus"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$newUser}}</h3>
                                        <h5 class="text-muted m-b-0">Customer 7 Days</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0">{{$allUser}}</h3>
                                    <h5 class="text-muted m-b-0">All Customer</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$categories}}</h3>
                                        <h5 class="text-muted m-b-0">Category</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="icon-people"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">{{$allBlogs}}</h3>
                                        <h5 class="text-muted m-b-0">Blog Post</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Popular Product</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Views</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($popularProducts)>0)
                                            @foreach($popularProducts as $product)
                                            <tr>
                                                <td><a target="_blank" href="{{ route('job_details', $product->slug) }}"> <img src="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" alt="Image" width="42"> {{Str::limit($product->title, 30)}}</a> </td>
                                                 <td>@if($product->author)<a target="_blank" href="{{ route('customer.profile', $product->author->username) }}"> {{$product->author->name}}</a>@else Seller not found. @endif
                                                    </td>
                                                 <td>{{ $product->views }}</td>
                                                <td>{{Config::get('siteSetting.currency_symble')}}{{$product->price}}</td>
                                                
                                            </tr>
                                           @endforeach
                                        @else <tr><td colspan="8"> <h1>No products found.</h1></td></tr> @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent blog</h5>
                                <div class="table-responsive ">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Blog</th>
                                                <th>Category</th>
                                                <th>Views</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @if(count($popularBlogs)>0)
                                            @foreach($popularBlogs as $index => $blog)
                                            <tr id="item{{$blog->id}}">
                                                <td><a target="_blank" href="{{ route('blog_details', $blog->slug) }}"><img src="{{asset('upload/images/blog/thumb/'. $blog->image)}}" width="50"> {{$blog->title}} </a></td>
                                                
                                                <td>{{$blog->get_category->name ?? ''}}</td>
                                              
                                                <td><p style="font-size:10px" class="fa fa-eye">  {{$blog->views}} </p></td>
                                               
                                                <td>
                                                    
                                                    <span class="label label-info"> {{$blog->status}} </span>
                                                    
                                                </td>
                                               
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr style="text-align: center;"><td colspan="8">Blog not found.!</td></tr>
                                            @endif
                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
@endsection
@section('js')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ asset('assets/node_modules') }}/raphael/raphael-min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/morrisjs/morris.min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="{{ asset('assets/node_modules') }}/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js') }}/dashboard1.js"></script>
@endsection