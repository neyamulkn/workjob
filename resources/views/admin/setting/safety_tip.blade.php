@extends('layouts.admin-master')
@section('title', 'Safety tip')
@section('css')
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
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
                        <h4 class="text-themecolor"><a href="{{ url()->previous() }}"> <i class="fa fa-angle-left"></i> Safety tip</a></h4>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="tab-content tabcontent-border">
                                   <?php

                                    $safety_tip = App\Models\SiteSetting::where('type', 'safety_tip')->first();
                                    ?>
                                    <div class="tab-pane active">
                                        <div class="p-20">
                                            <form action="{{ route('safety_tip') }}"  method="post" data-parsley-validate>
                                                @csrf
                                                
                                                <div class="form-body">
                                                    <div class="">
                                                        <div class="form-group">
                                                            <label>Safety tip</label>
                                                            <div class="col-md-8">
                                                                <textarea required name="safety_tip" class="summernote">{!! $safety_tip->value !!}</textarea>
                                                                
                                                            </div> 
                                                        </div>
                                                        
                                                    
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update safety tip</button>
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
                <!-- End PAge Content -->
           
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
@endsection

@section('js')
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
