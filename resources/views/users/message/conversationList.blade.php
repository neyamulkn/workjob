@foreach($conversationUsers as $conversationUser)

@php
if($conversationUser->sender_id == Auth::id()){
    $receiver = $conversationUser->receiver;
}else{
    $receiver = $conversationUser->sender;
}
@endphp

@if($conversationUser->product && (($conversationUser->sender_id == Auth::id() && $conversationUser->deleted_date_sender == null) || ($conversationUser->receiver_id == Auth::id() && $conversationUser->deleted_date_receiver == null) ))
<li class="message-item @if($conversationUser->last_message->receiver_id == Auth
::id() && $conversationUser->last_message->is_seen == 0) unread @endif ">
    <a href="javascript:void(0)" onclick="message('{{$conversationUser->id}}')" class="message-link">
        <div class="message-img">
            <img src="{{ asset('upload/images/product/thumb/'.$conversationUser->product->feature_image) }}" alt="photo">
        </div>
        <div class="message-text">
            <h6>{{$receiver->name}} <span>{{Carbon\Carbon::parse($conversationUser->last_message->created_at)->diffForHumans()}}</span></h6>
            <p><strong>{{Str::limit($conversationUser->product->title, 25)}}</strong></p>
            <p id="{{$conversationUser->id}}">{{ Str::limit($conversationUser->last_message->message, 25) }}</p>
        </div>
    </a>
    <div class="btn-group message-control">
        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('deleteAllMessage', $conversationUser->id)}}" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>
            <a class="dropdown-item" href="javascript:void(0)" onclick="report({{$conversationUser->product->id}})" title="Report"><i class="fas fa-flag"></i> Report</a>
            <a class="dropdown-item" href="{{route('blockUser', $conversationUser->id)}}" title="{{($conversationUser->block_user != null) ? 'Unblock' :'Block' }} "> <i class="fas fa-shield-alt"></i> Block</a>
        </div>
    </div>  
</li>
@endif
@endforeach