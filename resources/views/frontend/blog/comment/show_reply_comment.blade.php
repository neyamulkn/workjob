
<li id="singleComment{{ $replyComment->id }}" style="background: #fff;">
    <div class="comment-box" style="margin: 0px;">
        <a  href="{{route('user.publicProfile', [$replyComment->user->username])}}"><img alt="" src="{{asset('upload/images/users')}}/{{($replyComment->user->photo) ?  $replyComment->user->photo : 'default.png'}}"></a>
        <div class="comment-content">
            <h4><a style="float: left; border:none;" href="{{route('user.publicProfile', [$replyComment->user->username])}}">{{$replyComment->user->name}} </a></h4>
            <span><i class="fa fa-clock-o"></i>{{ Carbon\Carbon::parse($replyComment->created_at)->diffForHumans()}}</span>
            <p id="reply_comment{{$replyComment->id}}">{{$replyComment->comments}}</p>

            <!-- update comment reply -->
            @if(Auth::check())
                @if($replyComment->user_id == Auth::user()->id)
                    <a onclick="reply_comment_edit('{{$replyComment->comment_id}}','{{$replyComment->id}}')" class="comment-control">Edit</a> 
                    <a  onclick="commentDelete('{{$replyComment->id}}')" class="comment-control">Delete</a>
                @endif
                <a onclick="reply_field('{{$replyComment->comment_id}}', 'reply_form', '{{$replyComment->id}}')" >Reply</a>

                <!-- show reply edit comment form -->
                <form method="post" action="{{route('comment_reply', $replyComment->id)}}" id="update_replyComment{{$replyComment->id}}" class="comment-reply-form">
                
                </form>
            @endif
<!-- end comment reply update -->
        </div>

        <form method="post" style="padding-top: 10px;" action="{{route('comment_reply', $replyComment->comment_id)}}" id="reply_form{{$replyComment->comment_id.$replyComment->id}}" class="comment-reply-form">

        </form>
    </div>
</li>