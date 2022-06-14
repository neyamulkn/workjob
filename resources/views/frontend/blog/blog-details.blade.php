@extends('layouts.frontend')
@section('title', ($blog) ? $blog->title : 'not found' . ' | Blog')

@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/blog-details.css">
@endsection
@section('content')
  <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">  

                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">{{   $blog->title}}</h4>
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
                        <div class="blog-details-image">
                            <img src="{{asset('upload/images/blog/'. $blog->image)}}" alt="{{$blog->title}}">
                        </div>
                        <div class="blog-details-content">
                            <div class="description">
                                {!! $blog->description !!}
                            </div>
                            
                        </div>
                        <div class="blog-details-widget">
                            <!-- <ul class="tag-list">
                                <li><h4>Tags:</h4></li>
                                <li><a href="#">Crowd</a></li>
                                <li><a href="#">Party</a></li>
                                <li><a href="#">Concert</a></li>
                            </ul> -->
                            <ul class="share-list">
                                <li><h4>Share:</h4></li>
                                <li><a href="https://www.facebook.com/sharer.php?u={{route('blog_details', $blog->slug)}}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/share?url={{route('blog_details', $blog->slug)}}&amp;text={!! $blog->title !!}&amp;hashtags=blog"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{route('blog_details', $blog->slug)}}?rs={{$blog->id}}"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://web.whatsapp.com/send?text={{route('blog_details', $blog->slug)}}&amp;title={!! $blog->title !!}"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://pinterest.com/pin/create/button/?url={{route('blog_details', $blog->slug)}}?rs={{$blog->id}}"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            @foreach($related_blogs as $related_blog)
                            <div class="col-md-4 col-lg-4">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <img src="{{asset('upload/images/blog/thumb/'.$related_blog->image)}}" alt="{{$related_blog->title}}">
                                        <div class="blog-overlay">
                                            <span class="marketing">{{$related_blog->get_category->name}}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        @if($related_blog->author)
                                        <a href="{{route('userProfile', $related_blog->author->username)}}" class="blog-avatar">
                                            <img src="{{ asset('upload/users') }}/{{($related_blog->author->photo) ? $related_blog->author->photo : 'defualt.png'}}" alt="{{$related_blog->author->name}}">
                                        </a>
                                        <ul class="blog-meta">
                                           
                                            <li>
                                                <i class="fas fa-user"></i>
                                                <p><a href="#">{{$related_blog->author->name}}</a></p>
                                            </li>
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <p>{{Carbon\Carbon::parse($related_blog->created_at)->format(Config::get('siteSetting.date_format'))}}</p>
                                            </li>
                                        </ul>
                                        @endif
                                        <div class="blog-text">
                                            <h4><a href="{{route('blog_details', $related_blog->slug)}}">{{Str::limit($related_blog->title, 40)}}</a></h4>
                                            <p>{!! Str::limit(strip_tags($related_blog->description), 100) !!}</p>
                                        </div>
                                        <a href="{{route('blog_details', $related_blog->slug)}}" class="blog-read">
                                            <span>read more</span>
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div> 
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
                                    @if($blog->replyComments && count($blog->replyComments)>0)
                                    <ul>
                                        <li>
                                            <div class="comment">
                                                <div class="comment-author">
                                                    <a href="#"><img src="{{asset('frontend')}}/images/avatar/02.jpg" alt="comment"></a>
                                                    <button class="btn btn-inline">
                                                        <i class="fas fa-reply-all"></i>
                                                        <span>reply</span>
                                                    </button>
                                                </div>
                                                <div class="comment-content">
                                                    <h4>
                                                        <a href="#">LabonnoKhan</a>
                                                        <span>02 February 2020</span>
                                                    </h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero ab aperiam corrupti maiores animi nisi ratione maxime quae in doloremque corporis tempore earum ut voluptas exercitationem.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            <ul>
                                @if($totalComment > 5 )
                                <li style="text-align: center;"><a href="{{route('blog_comments', $blog->slug)}}">See All Comments</a><li>
                                @endif
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
                                            <button @if(Auth::check()) type="submit" @else data-toggle="modal" data-target="#so_sociallogin" type="button" @endif  class="btn btn-inline">
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
</div>
</div>
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
