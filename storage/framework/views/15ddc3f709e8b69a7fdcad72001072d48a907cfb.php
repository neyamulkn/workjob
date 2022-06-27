
<?php $__env->startSection('title', 'Discount configuration'); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            width: 300px !important;
            height: 150px !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                        <h4 class="text-themecolor"><a href="<?php echo e(url()->previous()); ?>"> <i class="fa fa-angle-left"></i>Discount configuration</a></h4>
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
                                    
                                    <li class="nav-item"> <a class="nav-link  active " data-toggle="tab" href="#Ads Limit" role="tab"> <span class="hidden-xs-down">Discount configuration</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                   <?php

                                    $discount_config = App\Models\SiteSetting::where('type', 'discount_config')->first();
                                    ?>
                                    <div class="tab-pane active" id="Ads Limit" role="tabpanel">
                                        <div class="p-20">
                                            <form action="<?php echo e(route('siteSettingUpdate')); ?>"  method="post" data-parsley-validate id="discount_config">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="type" value="discount_config">
                                                <div class="form-body">
                                                    <div class="">
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="Ads Limit_site_key">Deposit(%)</label>
                                                            <div class="col-md-6">
                                                                <input style="width: 300px" name="value" min="0" id="title" value="<?php echo e($discount_config->value); ?>" type="number" placeholder="Example 10% " class="form-control"><br>
                                                                <small>Additional commission will be added when the user makes a deposit.</small>
                                                            </div> 
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="Ads Limit_site_key">Minimum Deposit</label>
                                                            <div class="col-md-6">
                                                                <input style="width: 300px" required="" name="value2" min="0" id="title" value="<?php echo e($discount_config->value2); ?>" type="number" placeholder="Example 5" class="form-control">
                                                            </div> 
                                                        </div>
                                                        <!-- <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="Ads Limit_site_key">Job Post Discount</label>
                                                            <div class="col-md-6">
                                                                <input style="width: 300px" name="value3" min="0" id="title" value="<?php echo e($discount_config->value3); ?>" type="number" placeholder="Example 10% " class="form-control">
                                                            </div> 
                                                        </div> -->
                                                        
                                                        
                                                        
                                                        <div class="form-group row">
                                                            <div class="col-md-2 text-right">
                                                                <label>Status</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                    <label for="active"> <input type="radio" name="status" value="1"  <?php echo e(($discount_config->status == '1') ? 'checked' : ''); ?> id="active">
                                                                    Active</label> 
                                                                    <label for="DeActive"> <input type="radio" name="status" value="0"  <?php echo e(($discount_config->status == '0') ? 'checked' : ''); ?> id="DeActive">
                                                                    DeActive</label>
                                                            </div>
                                                        </div>
                                                            
                                                    </div><hr>
                                                    <div class="form-actions pull-right">
                                                        <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update Discount</button>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/setting/discount_config.blade.php ENDPATH**/ ?>