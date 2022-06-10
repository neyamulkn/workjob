@extends('backend.layouts.master')
@section('title', $taskDetails->subject)

@section('css')
    <!-- page css -->
    <link href="{{asset('backend/css')}}/pages/inbox.css" rel="stylesheet">
    <link href="{{asset('backend/assets')}}/node_modules/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('backend/css')}}/pages/chat-app-page.css" rel="stylesheet">
    <style type="text/css">
    tbody p{padding: 0;margin: 0}
    .message-box{ background: rgba(127, 136, 151, 0.1);border-radius: 50px;height: 50px; width: 100%;padding: 10px;resize: none;}
.submit-btn { background-color: transparent;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%; width: 40px; height: 40px;line-height: 40px;font-size: 20px;outline: none;right: 12px;position: absolute;top: 50%;-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%); -ms-transform: translateY(-50%);-o-transform: translateY(-50%);transform: translateY(-50%);border: none;color: #7f8897;font-size: 20px;}
/*chrome, opere, safari*/
.message-box::-webkit-scrollbar{ display: none;}
/*firefox, ID Edge*/
.message-box{-ms-overflow-style:none; scrollbar-width:none;}
.active{background: #f8f9fa;}
    </style>
@endsection
@section('content')
    <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Working Task</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            
                            <a onclick="return confirm('Are you sure task completed?')" href="{{route('admin.workingTaskStatus', [$taskDetails->slug])}}" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-check"></i> Task End</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xlg-2 col-lg-3 col-md-4 ">
                                    @include('backend.message.leftsidebar')
                                </div>
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
                                    <div class="card-body">
                                        <div class="card b-all shadow-none">
                                            <div class="card-body">
                                                <h3 class="card-title m-b-0"><a href="{{route('admin.workingTaskDetails', [$taskDetails->slug])}}">{{$taskDetails->subject}}</a></h3>
                                                <small class="text-muted">To:@if(count($taskDetails->workingTaskUsers)>0) @foreach($taskDetails->workingTaskUsers as $taskUsers) @if($taskUsers->taskUser) {{$taskUsers->taskUser->name}}, @endif @endforeach @else All staffs @endif</small>
                                            </div>
                                            <div>
                                                <hr class="m-t-0">
                                            </div>
                                            @if(!Request::segment('5') == 'conversation')
                                            <div class="card-body">
                                                {!! $taskDetails->details!!}

                                                @if($taskDetails->attachment)
                                                 <a target="_blank" href="{{asset('upload/workingTask/'. $taskDetails->attachment)}}">
                                                <h4><i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <!-- <span>(3)</span> --></h4>
                                                </a>
                                                @endif
                                                <div>
                                                <hr class="m-t-0">
                                                </div>
                                                <p class="p-b-20">Click here to <a href="{{route('admin.workingTaskDetails', [$taskDetails->slug, 'conversation'])}}">Reply</a></p>
                                            </div>
                                            @else
                                            <div class="card-body">
                                                <div class="b-all">
                                                    <div class="card m-b-0">
                                                        <!-- .chat-row -->
                                                        <div class="chat-main-box">
                                                            <div class="chat-right-aside conversation-history" style="width:100%">
                                                                <div class="chat-rbox">
                                                                    <ul class="chat-list p-3">
                                                                        @if(count($taskDetails->taskConversations)>0)
                                                                        @foreach($taskDetails->taskConversations as $taskConversation)
                                                                        @if($taskConversation->from_user == Auth::guard('admin')->id())
                                                                        <li class="reverse">
                                                                            <div class="chat-content">
                                                                                
                                                                                <div class="box bg-light-inverse">{!! $taskConversation->message !!}
                                                                                @if($taskConversation->image)
                                                                                <br/>
                                                                                <a class="image-popup-no-margins" href="{{asset('upload/workingTask/'. $taskConversation->image)}}">
                                                                                <img width="150" src="{{asset('upload/workingTask/'. $taskConversation->image)}}" alt="" /></a>
                                                                                @endif
                                                                                </div>
                                                                                <div class="chat-time">{{Carbon\Carbon::parse($taskConversation->created_at)->format('h:i A')}}</div>
                                                                            </div>
                                                                        </li>
                                                                        @else
                                                                        <li>
                                                                            <div class="chat-img"><img src="{{asset('upload/images/users/'.$taskConversation->conversationUser->photo)}}" alt="user" /></div>
                                                                            <div class="chat-content">
                                                                                <h5>{{$taskConversation->conversationUser->name}}</h5>
                                                                                <div class="box bg-light-info">{!! $taskConversation->message !!}
                                                                                @if($taskConversation->image)
                                                                                <br/>
                                                                                <a class="image-popup-no-margins" href="{{asset('upload/workingTask/'. $taskConversation->image)}}">
                                                                                <img width="150" src="{{asset('upload/workingTask/'. $taskConversation->image)}}" alt="" /></a>
                                                                                @endif
                                                                                </div>
                                                                                <div class="chat-time">{{Carbon\Carbon::parse($taskConversation->created_at)->format('h:i A')}}</div>
                                                                            </div>
                                                                        </li>
                                                                        @endif
                                                                        @endforeach
                                                                        @else <h3>No conversation</h3> @endif
                                                                    </ul>
                                                                </div>
                                                                <div class="card-body border-top">
                                                                    <form action="{{route('admin.workingTaskConversation')}}" enctype="multipart/form-data" method="post" id="workingTaskConversation">
                                                                        @csrf
                                                                        <input type="hidden" name="task_id" value="{{$taskDetails->id}}">
                                                                        <div style="position:relative">
                                                                            <textarea name="message" required placeholder="Type your message here" id="message" class="message-box border-0"></textarea>
                                                                            <button type="submit" class="conversationBtn btn btn-info btn-circle btn-lg theme-btn submit-btn border-0"><i class="fas fa-paper-plane"></i> </button>
                                                                        </div>
                                                                        <input type="file" name="image">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.chat-row -->
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
   
@endsection
@section('js')
<script src="{{asset('js')}}/pages/chat.js"></script>
    <script src="{{asset('backend/assets')}}/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="{{asset('backend/assets')}}/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
<script type="text/javascript">
    $('.conversationBtnss').click(function(){
          $.ajax({
            url:'{{route("admin.workingTaskConversation")}}',
            type:'get',
            data:$('#workingTaskConversation').serialize(),
            success:function(data){
                if(data.status == 'success'){
                    $('.chat-list').append(`<li class="reverse">
            <div class="chat-content">
                <div class="box bg-light-inverse">It’s Great opportunity to work.</div>
                <div class="chat-time">10:57 am</div>
            </div>
            <div class="chat-img"><img src="{{asset('backend/assets')}}/images/users/1673487498.jpg" alt="user" /></div>
        </li>`);
                }else{
                    toastr.error(data.msg);
                }
              }
          });
      });

    // Enter form submit preventDefault for tags
        $('#message').keypress(function(e) {
          if(e.keyCode == 13 && !event.shiftKey) {
             $('.conversationBtn').click();
          }
        });
</script>
@endsection
