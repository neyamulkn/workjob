@extends('layouts.admin-master')
@section('title', $message->subject. ' | Edit')

@section('css-top')
	<link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/dropzone-master/dist/dropzone.css" rel="stylesheet">
@endsection
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css')}}/pages/inbox.css" rel="stylesheet">
    <link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    tbody p{padding: 0;margin: 0}
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
                        <h4 class="text-themecolor">Message</h4>
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
                                    @include('admin.message.leftsidebar')
                                </div>
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
                                    <div class="card-body">
                                        <h3 class="card-title">Update message</h3>
                                        <form action="{{route('adminMessage.store', $message->slug)}}" enctype="multipart/form-data" method="POST">
                                            {{csrf_field()}}
                                            <div class="form-body">
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select multiple required name="user_id[]" class="select2 form-control custom-select">
                                                                <option @if(in_array(0, json_decode($message->receiver_id))) selected @endif value="0">All User</option>
                                                                @foreach($users as $user)
                                                                    <option @if(in_array($user->id, json_decode($message->receiver_id))) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <input class="form-control" value="{{$message->subject}}" required name="subject" placeholder="Subject:">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea name="details" class="form-control summernote" placeholder="Write your details" id="details" rows="3">{{$message->details}}</textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="email_notify"><input type="radio" required value="email" id="email_notify" name="send_via" > Email</label> <label for="sms_notify"><input type="radio" required value="sms" id="sms_notify" name="send_via"> SMS</label> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-md-center">
                                                    <div class="col-md-12">
                                                        <div class="modal-footer">
                                                            <button type="submit" name="status" value="send" class="btn btn-success"> <i class="fa fa-check"></i> Send message</button>
                                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
   
@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- dropzone version change -->
    <script src="{{asset('assets')}}/node_modules/dropzone-master/dist/dropzone.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
        $(".select2").select2({placeholder: "Select User", allowClear: true});

       </script>

       <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>
@endsection
