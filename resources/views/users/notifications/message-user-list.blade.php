<div class="dropdown-header">
    <h5>Message</h5>
    <a href="{{route('user.message')}}">View all message</a>
</div>
<ul class="message-list ">
@foreach($notifications as $conversation)

@php
if($conversation->sender_id == Auth::id()){
    $receiver = $conversation->receiver;
}else{
    $receiver = $conversation->sender;
}
@endphp
@if($conversation->product)
<li class="message-item @if($conversation->last_message->receiver_id == Auth
::id() && $conversation->last_message->is_seen == 0) unread @endif ">
    <a href="{{route('user.message', $conversation->id)}}" class="message-link">
        <div class="message-img" style="border-radius: 3px">
            <img style="border-radius: 3px" src="{{ asset('upload/images/product/thumb/'.$conversation->product->feature_image) }}" alt="obondhu">

        </div>
        <div class="message-text">
            <h6>{{$receiver->name}} <span>{{Carbon\Carbon::parse($conversation->last_message->created_at)->diffForHumans()}}</span></h6>
            <p>{{Str::limit($conversation->product->title, 25)}} <br/>
            <p>{!! Str::limit($conversation->last_message->message, 25) !!}</p>
        </div>
    </a>
</li>
@endif
@endforeach
    
</ul>