@foreach($messages as $message)
    @if($message->sender_id == Auth::id())
    <li class="inbox-chat-item my-chat" id="message{{$message->id}}">
        <div class="inbox-chat-content">
            @if($message->deleted_from_sender == 0)
            <div class="inbox-chat-text">
                <p>{!! $message->message !!}</p>
                <div class="inbox-chat-action">
                    <a href="javascript:void(0)" title="Remove" onclick= "removeMessage({{$message->id}})" class="fas fa-trash-alt"></a>
                </div>
            </div>
            <small class="inbox-chat-time">{{Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</small>
           @endif
        </div>
    </li>
    @else
    <li class="inbox-chat-item" id="message{{$message->id}}">
        <div class="inbox-chat-content">
            @if($message->deleted_from_receiver == 0)
            <div class="inbox-chat-text">
                <p>{!! $message->message !!}</p>
                <div class="inbox-chat-action">
                    <a href="javascript:void(0)" title="Remove" onclick= "removeMessage({{$message->id}})" class="fas fa-trash-alt"></a>
                </div>
            </div>
            <small class="inbox-chat-time">{{Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</small>
            @endif
        </div>
    </li>
    @endif
@endforeach