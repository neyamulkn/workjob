@extends('layouts.frontend')
@section('title')
@if($category) {{$category->name}} |  @endif Blog 
@endsection
@section('content')
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Blogs</h4>
                    </div>
                    
                </div>
     <section class="blog-part">
            <div class="container">
                <div class="row content-reverse">
                    <div class="col-lg-4">
                        <div class="row">

                            <!-- SEARCH BAR -->
                            <div class="col-lg-12">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Search</h5>
                                    </div>
                                    <form class="blog-src">
                                        <input type="text" name="keyword" value="{{Request::get('keyword')}}" placeholder="Search...">
                                        <button><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- TOP CATEGORY -->
                            <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Top categories</h5>
                                    </div>
                                    <ul class="blog-cate">
                                        @foreach($categories as $category)
                                        <li>
                                            <h5><a href="{{route('blog', $category->slug)}}">{{$category->name}}</a></h5>
                                            <p>{{$category->blogs_by_category_count}}</p>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- POPULAR POST -->
                            <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>popular post</h5>
                                    </div>
                                    <ul class="blog-suggest">
                                        @foreach($popular_blogs as $popular_blog)
                                        <li>
                                            <div class="suggest-img">
                                                <a href="{{route('blog_details', $popular_blog->slug)}}"><img src="{{asset('upload/images/blog/thumb/'.$popular_blog->image)}}" alt="{{$popular_blog->title}}"></a>
                                            </div>
                                            <div class="suggest-content">
                                                <div class="suggest-title">
                                                    <h4><a href="{{route('blog_details', $popular_blog->slug)}}">{{Str::limit($popular_blog->title, 40)}}</a></h4>
                                                </div>
                                                <div class="suggest-meta">
                                                    <div class="suggest-date">
                                                        <i class="far fa-calendar-alt"></i>
                                                        <p>{{Carbon\Carbon::parse($popular_blog->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                                    </div>
                                                    <div class="suggest-comment">
                                                        <i class="far fa-comments"></i>
                                                        <p>0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            

                            <!-- BEST TAGS -->
                            <!-- <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Best tags</h5>
                                    </div>
                                    <ul class="blog-tag">
                                        <li><a href="#">domain</a></li>
                                        <li><a href="#">cloud</a></li>
                                        <li><a href="#">web</a></li>
                                        <li><a href="#">offer</a></li>
                                        <li><a href="#">support</a></li>
                                        <li><a href="#">payment</a></li>
                                        <li><a href="#">E-commerce</a></li>
                                        <li><a href="#">Sequerity</a></li>
                                        <li><a href="#">solution</a></li>
                                        <li><a href="#">knowladge</a></li>
                                    </ul>
                                </div>
                            </div>
 -->
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            @if(count($blogs)>0)
                            @foreach($blogs as $blog)
                            <div class="col-md-6 col-lg-6">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <img src="{{asset('upload/images/blog/thumb/'.$blog->image)}}" alt="{{$blog->title}}">
                                        <div class="blog-overlay">
                                            <span class="marketing">{{$blog->get_category->name}}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        @if($blog->author)
                                        <a href="#" class="blog-avatar">
                                            <img src="{{ asset('upload/users') }}/{{($blog->author->photo) ? $blog->author->photo : 'defualt.png'}}" alt="{{$blog->author->name}}">
                                        </a>
                                        <ul class="blog-meta">
                                           
                                            <li>
                                                <i class="fas fa-user"></i>
                                                <p><a href="#">{{$blog->author->name}}</a></p>
                                            </li>
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <p>{{Carbon\Carbon::parse($blog->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                            </li>
                                        </ul>
                                        @endif
                                        <div class="blog-text">
                                            <h4><a href="{{route('blog_details', $blog->slug)}}">{{Str::limit($blog->title, 40)}}</a></h4>
                                            <p>{!! Str::limit(strip_tags($blog->description), 100) !!}</p>
                                        </div>
                                        <a href="{{route('blog_details', $blog->slug)}}" class="blog-read">
                                            <span>read more</span>
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div style="text-align: center;">
                                <h3>Search Result Not Found.</h3>
                                <p>We're sorry. We cannot find any matches for your search term</p>
                                <i style="font-size: 10rem;" class="fa fa-search"></i>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{$blogs->appends(request()->query())->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div></div>
@endsection

