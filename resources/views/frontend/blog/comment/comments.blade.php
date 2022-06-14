@extends('layouts.frontend')
@section('title', ($blog) ? $blog->title : 'not found' . ' | Blog')

@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/blog-details.css">
@endsection
@section('content')
    
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="{{url('blog')}}"> Blog</a></li>
                @if($blog)<li><a href="#">{{   $blog->title}}</a></li>@endif
            </ul>
        </div>
    </div>
    <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        @if($blog)
                        <div class="blog-details-title">
                            <h2><a href="#">{{$blog->title}}</a></h2>
                        </div>
                        <ul class="blog-details-meta">
                            @if($blog->author)
                            <li>
                                <a href="#">
                                    <i class="far fa-user"></i>
                                    <p>{{$blog->author->name}}</p>
                                </a>
                            </li>@endif
                            <li>
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <p>{{Carbon\Carbon::parse($blog->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                </a>
                            </li>
                            @if($blog->get_category)
                            <li>
                                <a href="#">
                                    <i class="far fa-folder-open"></i>
                                    <p>{{$blog->get_category->name}}</p>
                                </a>
                            </li>@endif
                            <li>
                                <a href="#">
                                    <i class="far fa-comments"></i>
                                    <p>{{$totalComment}} Comment</p>
                                </a>
                            </li>
                            
                        </ul>
                        
                        <div class="blog-details-comment">
                            <div class="comment-title">
                                <h3>Comments ({{$totalComment}})</h3>
                            </div>
                            <ul class="comment-list" id="show_comment">
                                @foreach($comments as $comment)
                                <li>
                                    <div class="comment">
                                        <div class="comment-author">
                                            <a href="{{route('userProfile', $comment->author->username)}}"><img src="{{ asset('upload/users') }}/{{($comment->author->photo) ? $comment->author->photo : 'defualt.png'}}" alt="comment"></a>
                                            
                                        </div>
                                        <div class="comment-content">
                                            <h4>
                                                <a href="#">{{$comment->author->name}}</a>
                                                <span>{{Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span>
                                            </h4>
                                            <p id="comment{{$comment->id}}">{!! $comment->comments !!}</p>
                                        </div>
                                    </div>
                                    
                                </li>
                                @endforeach
                            </ul>
                            <ul>
                                
                                <li style="text-align: center;margin-top: 5px">{{ $comments->links() }}<li>
                               
                            </ul>
                        </div>
                        <div class="blog-details-form">
                            <div class="form-title">
                                <h3>Leave Your Comment</h3>
                            </div>
                            <form method="post" id="commentForm">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" id="comment" placeholder="Your Comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                            <button @if(Auth::check()) type="submit" @else data-toggle="modal" data-target="#so_sociallogin" type="button" @endif class="btn btn-inline">
                                                <i class="fas fa-tint"></i>
                                                <span>Drop your comment</span>
                                            </button>
                                            <br>
                                            <br>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                        <div style="text-align: center;">
                            <h3>Blog Not Found.</h3>
                            
                            <i style="font-size: 10rem;" class="fa fa-search"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
@endsection
@section('js')
<script type="text/javascript">
        $(function(){
            $("#commentForm").submit(function(event){
                event.preventDefault();
              
                $.ajax({
                        url:'{{route("blog_comment_insert")}}',
                        type:'get',
                        data:$(this).serialize(),
                        success:function(result){
                            document.getElementById("comment").value = '';
                            $("#show_comment").append(result);
                             toastr.success('Comment inserted.');
                        }

                });
            });
        }); 
</script>
@endsection
