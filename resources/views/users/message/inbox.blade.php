@extends('layouts.frontend')
@section('title', 'Message')
@section('css-top')
    <link rel="stylesheet" href="{{asset('frontend')}}/css/vendor/nice-select.min.css">
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('frontend')}}/css/custom/message.css">
    <style type="text/css">
        .inbox-chat-list{overflow-y: scroll;min-height: 250px;}}
        .active{background: #25b90a1a;}
        .removeMessage{background: rgb(225 221 221 / 40%);color: #b56161;border-radius: 5px;padding: 5px;font-size: 12px;}
        .inbox-chat-form textarea{width: 95%;
    height: 50px;
    padding: 5px 45px 5px 5px;
    border: 1px solid #ccc; resize: none;}
    .message-arrow{font-size: 25px;
    margin-right: 8px;
    color: #565454;
    display: none;}
    .header-fixed{position: initial;}
    .message-control{display: none;position: absolute;top: 5%;right: 15px;}
    @media (max-width: 768px) {
        .inbox-header-list{display: none;}
        .message-item{display: flex;position: relative;}
        .message-control{display: block; }
        .message-arrow{display: block;}
        @if(Request::route('username'))
        .message-filter{display: none;}
        @endif

        .boxShow{display: block;}
        .boxHide{display: none;}
    }
    </style>
@endsection
@section('content')

<section class="message-part">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-xl-4">
                <div class="message-filter">
                    
                    <form style="display: block;" class="message-filter-src">
                        <input type="text" id="userList" placeholder="Search for message">
                    </form>
                    <ul class="message-list userList">
                        @include('users.message.conversationList') 
                    </ul>
                </div>
            </div>
            <div class="col-lg-7 col-xl-8">
                <div class="message-inbox">
                    @if($conversation)
                        @include('users.message.message')
                    @elseif($receiver && $product)
                        <div id="message-body" style="min-height: 250px;">
                        <div class="inbox-header">
                            <div class="inbox-header-profile">
                                <a class="inbox-header-img" target="_blank" href="{{route('post_details',$product->slug )}}">
                                    <img src="{{ asset('upload/images/product/thumb/'.$product->feature_image) }}" alt="avatar">
                                </a>
                                <div class="inbox-header-text">
                                    <h5><a href="{{route('userProfile', $receiver->username)}}">{{$receiver->name}}</a></h5>
                                    <p><a target="_blank" href="{{route('post_details',$product->slug )}}">{{Str::limit($product->title, 40)}}</a></p>
                                    <span>{{Config::get('siteSetting.currency_symble') . $product->price}}</span>
                                </div>
                            </div>
                            @if($conversation)
                            <ul class="inbox-header-list">
                                <li><a href="{{route('deleteAllMessage', $conversation->id)}}" title="Delete" class="fas fa-trash-alt"></a></li>
                                <li><a href="javascript:void(0)" onclick="report({{$product->id}})" title="Report" class="fas fa-flag"></a></li>
                                <li><a href="{{route('blockUser', $conversation->id)}}" title="{{($conversation->block_user != null) ? 'Unblock' :'Block' }} " class="fas fa-shield-alt"></a></li>
                            </ul>@endif
                        </div>
                        <ul class="inbox-chat-list" id="inbox-chat-list">
                        @if($conversation && $messages)
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
                        @else
                            <li><h3>No conversation</h3></li>
                        @endif
                        </ul>
                        </div>
                        @if(isset($messageWriteBox))

                        <div class="inbox-chat-form">
                        @if(!$conversation || $conversation->block_user == null)

                        <textarea  name="message" class="message" required placeholder="Type a Message"></textarea>
                        <button class="sendMessage" onclick="sendMessage('{{$product->id}}')" type="button"><i class="fas fa-paper-plane"></i></button>
                        @else
                            @if($conversation->block_user == Auth::id())
                                <p>You've blocked message. You can't message In this chat and you won't receive their message.</p>
                                <a href="{{route('blockUser', $conversation->id)}}">Unblock</a>
                            @else
                            <h3>You have been blocked so you can't send any message.</h3>
                            @endif
                        @endif
                        </div>
                        @endif 
                    @else
                    <div style="text-align: center;position: relative;top: 30%;">
                        <img width="30%" src="{{asset('frontend/images/communication.png')}}">
                       <p> Select a chat to view conversation</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="modal fade" id="reportModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Report</h4>
                    <button class="fas fa-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sellerReport')}}" method="post">
                        @csrf()
                        <input type="hidden" name="product_id"  id="product_id">
                        <div id="reportForm"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection	  

@section('js') 
        <script src="{{asset('frontend')}}/js/vendor/nice-select.min.js"></script>
        <script src="{{asset('frontend')}}/js/vendor/nicescroll.min.js"></script>
        <script src="{{asset('frontend')}}/js/custom/nice-select.js"></script>
        <script src="{{asset('frontend')}}/js/custom/nicescroll.js"></script>
    <script>
    function userHideShow() {
        $('.message-filter').addClass("boxShow").removeClass("boxHide");
        $('.message-inbox').addClass('boxHide').removeClass("boxShow");
    }

    var timeSet = '';
    function message(conversation_id){
        clearInterval(timeSet);
        $('.message-filter').addClass("boxHide").removeClass("boxShow");
        $('.message-inbox').addClass('boxShow').removeClass("boxHide");
        var  link = '{{route("user.getMessages", ":id")}}';
        link = link.replace(":id", conversation_id);

        $.ajax({
            url:link,
            method:"get",
            success:function(data){
                if(data){
                    $('.message-inbox').html(data);
                    var mydiv = $("#inbox-chat-list");
                    mydiv.scrollTop(mydiv.prop("scrollHeight"));
                    timeSet = setInterval(function(){
                        realTime(conversation_id);
                    }, 9000);
               }else{
                    $('.message-inbox').html('<h3>User not found.</h3>');
               }
            }
        });

        var path = "{{route('user.message')}}/"+conversation_id;
        history.pushState(null, null, path);
    }
</script>

<script type="text/javascript">
   function sendMessage(productOrConId){
    clearInterval(timeSet);
    var message = $('.message').val();
   
      $.ajax({
        url:'{{route("user.sendMessage")}}',
        type:'post',
        data:{productOrConId:productOrConId,message:message,'_token':'{{ csrf_token() }}'},
        success:function(data){
            if(data){
                $('#message-body').html(data);
                var mydiv = $("#inbox-chat-list");
                mydiv.scrollTop(mydiv.prop("scrollHeight"));
                //pass last sms
                $('#'+productOrConId).html(message);
                $('.message').val('');
                timeSet = setInterval(function(){
                        realTime(productOrConId);
                    }, 9000);
            }else{
                toastr.error('Message send failad.');
            }
          }
      });
    }

    function realTime(conversation_id){

      $.ajax({
        url:'{{route("realTimeMessage")}}',
        type:'get',
        data:{conversation_id:conversation_id},
        success:function(data){
            
            if(data.message){
                $('#inbox-chat-list').html(data.message);
                var mydiv = $("#inbox-chat-list");
                mydiv.scrollTop(mydiv.prop("scrollHeight"));
            }
            if(data.conversationUsers){
                $('.userList').html(data.conversationUsers);
            }
            
        }
      });
    }
    
    function removeMessage(id){
        var url = '{{route("deleteMessage", ":id")}}';
        url = url.replace(":id",id);
        $.ajax({
            url:url,
            type:'get',
            success:function(data){
                if(data.status){
                    $('#message'+id).remove();
                }
            }
        })
    }

    function report(product_id){
        $('#reportModal').modal('show');
         $('#reportForm').html('<div class="loadingData-sm"></div>');

        $.ajax({
            method:'get',
            url:'{{route("reportForm")}}',
            data:{
                type:'product'
            },
            success:function(data){
                if(data){
                    $('#reportForm').html(data);
                    $('#product_id').val(product_id);
                }

            }
        });
    }
    $('#userList').keyup(function(){
        var searchText = $(this).val().toUpperCase();
        $('.userList li a').each(function(){
        var currentLiText = $(this).text(),
            showCurrentLi = currentLiText.toUpperCase().indexOf(searchText) !== -1;
        $(this).toggle(showCurrentLi);
        });     
    });
    //browser back button action
    $(window).on('popstate', function() {  
        clearInterval(timeSet);
        $('.message-filter').addClass("boxShow").removeClass("boxHide");
        $('.message-inbox').addClass('boxHide').removeClass("boxShow");
        var path = window.location.pathname.split("/").pop();

        if(typeof path != 'undefined' && path != '' && path != 'message'){
        var  link = '{{route("user.getMessages", ":path")}}';
        link = link.replace(":path", path);
        $.ajax({
            url:link,
            method:"get",
            success:function(data){
                if(data){
                    $('.message-inbox').html(data);
                    var mydiv = $("#inbox-chat-list");
                    mydiv.scrollTop(mydiv.prop("scrollHeight"));
                    timeSet = setInterval(function(){
                        realTime(conversation_id);
                    }, 9000);
               }else{
                    $('.message-inbox').html('<h3>User not found.</h3>');
               }
            }
        });
        }
   });
</script>
@endsection    