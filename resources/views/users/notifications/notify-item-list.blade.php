<li>
    <div class="drop-title">Notifications</div>
</li>
<li>
    <div class="message-center">

        @if(count($notifications )>0)
            @foreach($notifications as $notification)
            @if($notification->type == 'post' || $notification->type == 'userStatus' )
            @if($notification->product)
            <!-- Message -->
            <a href="{{route('job_details', $notification->product->slug)}}">
                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                <div class="mail-contnet">
                    <h5>@if($notification->user)<span>{{$notification->user->name}}: </span>@endif</h5> <span class="mail-desc">{{$notification->notify}}</span> <span class="time">{{Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span> </div>
            </a>
            @else

            @endif
            @endif
            @endforeach
        @else
        <a href="javascript:void(0)">No notification found.</a>
        @endif
    </div>
</li>
<li>
    <a class="nav-link text-center link" href="{{route('allNotifications')}}"> <strong>View notifications</strong> <i class="fa fa-angle-right"></i> </a>
</li>