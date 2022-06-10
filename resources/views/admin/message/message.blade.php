@extends('layouts.admin-master')
@section('title', 'Messages')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- page css -->
    <link href="{{asset('css')}}/pages/inbox.css" rel="stylesheet">
  
    <style type="text/css">
    tbody p{padding: 0;margin: 0}
    tbody a{color: #000;}
    .userList{white-space: nowrap; 
  width: 100px; 
  overflow: hidden;
  text-overflow: ellipsis; 
  }
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
                        <h4 class="text-themecolor">Message list</h4>
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
                                <div class="col-xlg-2 col-lg-3 col-md-4">
                                    @include('admin.message.leftsidebar')
                                </div>
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left sticky-conent">
                                    
                                    <div class="card-body p-t-0">
                                        <div class="card b-all shadow-none">
                                            <div class="table-responsive" style="padding-top:0">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px;">#</th>
                                                            
                                                            <th style="max-width: 150px;">Subject</th>
                                                            <th>Description</th>
                                                            <th style="width: 90px;">Date</th>
                                                            <th style="width: 50px;">Action</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        @foreach($messages as $index => $message)
                                                        <tr id="item{{$message->id}}">
                                                            <td>{{$index+1}}</td>
                                                           
                                                            <td> {{Str::limit($message->subject, '50')}}</td>
                                                            <td>{!! Str::limit(strip_tags($message->details), 60) !!} </td>
                                                          
                                                            <td><p>{{ Carbon\Carbon::parse($message->start_date)->format('d M, y') }}</p><p> {{ Carbon\Carbon::parse($message->start_date)->format('h:i A') }}</p></td>
                                                            @if($permission['is_edit'])
                                                            <td><a title="Edit" href="{{route('adminMessage.edit', $message->slug)}} "> <i class="fa fa-reply"></i> </a>@endif
                                                            @if($permission['is_delete'])
                                                            <a style="color:red" title="Delete" data-target="#delete" onclick="deleteConfirmPopup('{{route("adminMessage.delete", $message->id)}}')" data-toggle="modal" href="javascript:void(0)"> <i class="ti-trash"></i> </a>@endif </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                       {{$messages->appends(request()->query())->links()}}
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of total {{$messages->total()}} entries ({{$messages->lastPage()}} Pages)</div>
                                                </div>
                                            </div>
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
   	<!-- delete Modal -->
   
    @include('admin.modal.delete-modal')
@endsection

