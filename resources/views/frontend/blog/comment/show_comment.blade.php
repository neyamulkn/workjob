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