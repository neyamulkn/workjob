<div class="dropdown-header">
    <h5>Notification</h5>
    <a href="{{route('allNotifications')}}">view all</a>
</div>
<ul class="notify-list ">
 
@if(count($notifications )>0)
@foreach($notifications as $notification)
@if($notification->type == 'post')
    @if($notification->product)
    <li class="notify-item @if($notification->read == 0) active @endif">
        <a onclick="readNotify('{{$notification->id}}')" href="{{route('post_details', $notification->product->slug)}}" class="notify-link">
            <div class="notify-img">
                <img src="{{asset('upload/images/product/thumb/'. $notification->product->feature_image)}}" alt="obondhu">
            </div>
            <div class="notify-content">
                <p class="notify-text">@if($notification->user)<span>{{$notification->user->name}}: </span>@endif<span>{{$notification->notify}}</span>  {{Str::limit($notification->product->title, 25)}}</p>
                <span class="notify-time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
            </div> 
        </a>
    </li>
    @endif
@elseif($notification->type == 'package')
<li class="notify-item @if($notification->read == 0) active @endif">
    <a onclick="readNotify('{{$notification->id}}')" href="{{route('user.packageHistory')}}#{{$notification->item_id}}" class="notify-link">
        <div class="notify-img">
             <img src="https://img.favpng.com/19/10/20/blue-computer-icon-area-symbol-png-favpng-Rsn1G41w4PgR3fpkZntM1wVrZ.jpg" alt="obondhu">
        </div>
        <div class="notify-content">
            <p class="notify-text"> {{$notification->notify}} </p>
            <span class="notify-time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
        </div>
    </a>
</li>
@elseif($notification->type == 'register'){
    <li class="notify-item @if($notification->read == 0) active @endif">
    <a href="{{route('user.dashboard')}}" class="notify-link">
        <div class="notify-img">
            <img src="{{ asset('frontend/images/post.png') }}" alt="obondhu">
        </div>
        <div class="notify-content">
            <p class="notify-text"><span>{{$notification->notify}}</span></p>
            <span class="notify-time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
        </div>
    </a>
</li>
}
@else

@endif
@endforeach
@else
<h3>No notification found.</h3>
@endif
    
</ul>