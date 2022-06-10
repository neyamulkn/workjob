@extends('layouts.admin-master')
@section('title', 'Ads Duration')
@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            width: 300px !important;
            height: 150px !important;
        }
    </style>
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
                        <h4 class="text-themecolor"><a href="{{ url()->previous() }}"> <i class="fa fa-angle-left"></i> Ads Duration</a></h4>
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
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    
                                    <li class="nav-item"> <a class="nav-link  active " data-toggle="tab" href="#Ads Limit" role="tab"> <span class="hidden-xs-down">Ads Duration</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                   <?php

                                    $free_ads_limit = App\Models\SiteSetting::where('type', 'free_ads_limit')->first();
                                    ?>
                                    <div class="tab-pane active" id="Ads Limit" role="tabpanel">
                                        <div class="p-20">
                                            <form action="{{ route('siteSettingUpdate') }}"  method="post" data-parsley-validate id="free_ads_limit">
                                                @csrf
                                                <input type="hidden" name="type" value="free_ads_limit">
                                                <div class="form-body">
                                                    <div class="">
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="Ads Limit_site_key">Post Ads Duration</label>
                                                            <div class="col-md-6">
                                                                <input style="width: 300px" name="value2" min="0" id="title" value="{{ $free_ads_limit->value2 }}" type="number" placeholder="Example 30 days" class="form-control">
                                                            </div> 
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="Ads Limit_site_key">Free Ads Period</label>
                                                            <div class="col-md-6">
                                                                <input style="width: 300px" required="" name="value" min="0" id="title" value="{{ $free_ads_limit->value }}" type="number" placeholder="Example 15 days" class="form-control">
                                                            </div> 
                                                        </div>

                                                        
                                                        <div class="form-group row">
                                                            <div class="col-md-2 text-right">
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                    <label for="active"> <input type="radio" name="status" value="1"  {{ ($free_ads_limit->status == '1') ? 'checked' : '' }} id="active">
                                                                    Active</label> 
                                                                    <label for="DeActive"> <input type="radio" name="status" value="0"  {{ ($free_ads_limit->status == '0') ? 'checked' : '' }} id="DeActive">
                                                                    DeActive</label>
                                                            </div>
                                                        </div>
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update Ads Limit</button>
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
