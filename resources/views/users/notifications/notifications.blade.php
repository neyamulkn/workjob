@extends('layouts.frontend')
@section('title', 'Notifications')

@section('css')
<style type="text/css" src="{{asset('css/pages/other-pages.css')}}"></style>
    <style type="text/css">
        .inbox-chat-list{overflow-y: scroll;min-height: 250px;}}
        .active{background: #25b90a1a;}
        .removeMessage{background: rgb(225 221 221 / 40%);color: #b56161;border-radius: 5px;padding: 5px;font-size: 12px;}
    .notify-item {border-bottom: 1px solid #e9e9e9;list-style: none;margin-bottom: 10px;padding-bottom: 5px;}
    .notify-link{display: flex;line-height: normal;}
    .notify-link p{margin-bottom: 0;}
    .notify-filter{    display: flex;
    justify-content: space-between; margin-bottom: 10px;}
    .search-listing{padding: 6px;}
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
                        <h4 class="text-themecolor">Job lists</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Job</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="{{route('post.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search Result For "Angular Js"</h4>
                                <h6 class="card-subtitle">About 14,700 result ( 0.10 seconds)</h6>
                                <div class="notify-filter">
                                <select onchange="markMotification(this.value)" class="select notify-select">
                                    <option @if(Request::get('mark') == 'all') selected @endif value="all">All notification</option>
                                    <option @if(Request::get('mark') == 'read') selected @endif value="read">Read notification</option>
                                    <option @if(Request::get('mark') == 'unread') selected @endif value="unread">Unread notification</option>
                                </select>
                                <div class="notify-action">
                                    
                                    <a style="width:100%; border-radius: 5px; line-height: 28px; padding:5px;" href="{{route('readNotify')}}" title="Mark All As Read" class="fas fa-envelope-open"> Mark Read</a>
                                    <!-- <a href="#" title="Notification Setting" class="fas fa-cog"></a> -->
                                </div>
                            </div>
                                <ul class="search-listing">
                                @if(count($notifications )>0)
                                @foreach($notifications as $notification)
                                @if($notification->type == 'post')
                                @if($notification->product)
                                    <li class="notify-item @if($notification->read == 0) active @endif">
                                        <a onclick="readNotify('{{$notification->id}}')" href="{{route('job_details', $notification->product->slug)}}" class="notify-link">
                                            <div class="notify-img">
                                                <img width="25" src="{{asset('upload/images/product/thumb/'. $notification->product->feature_image)}}" alt="avatar">
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
                                            <div  class="notify-img">
                                                 <img width="25" src="https://img.favpng.com/19/10/20/blue-computer-icon-area-symbol-png-favpng-Rsn1G41w4PgR3fpkZntM1wVrZ.jpg" alt="avatar">
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
                                            <img src="{{ asset('frontend/images/post.png') }}" alt="avatar">
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
                                <nav aria-label="Page navigation example" class="m-t-40">
                                        {{$notifications->links()}}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
 
    </div>
</div>
@endsection   

@section('js') 
      <script type="text/javascript">
          function markMotification(read) {
           if (read != undefined && read != null) {
                window.location = '{{route("allNotifications")}}?mark=' + read;
            }
          }
      </script>
@endsection    