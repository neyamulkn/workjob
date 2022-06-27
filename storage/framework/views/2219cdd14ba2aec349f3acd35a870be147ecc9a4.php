
<?php $__env->startSection('title', 'Site Setting'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css')); ?>/pages/bootstrap-switch.css" rel="stylesheet">
    <style type="text/css">
    	.text-muted{margin: 5px 0 0}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                
                <div class="col-md-12 align-self-center ">
                    <div class="d-fl ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Site</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Site Setting</h4>
                             <i class="drag-drop-info">Drag & drop sorting position</i>
                            <table class="table">
                            	<tbody class="" id="positionSorting" data-table="site_settings">
                            	<?php $__currentLoopData = $siteSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siteSetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="item<?php echo e($siteSetting->id); ?>">
                                	<td style="padding-left: 30px;">
	                                    <h4><?php echo e(str_replace('_', ' ', ucwords($siteSetting->type))); ?></h4>
	                                
	                                    <p class="text-muted font-13"></p>
	                                    <div class="bt-switch">
								            <input onchange="siteSettingActiveDeactive(this, '<?php echo e($siteSetting->type); ?>')" <?php echo e(($siteSetting->status == 1) ? 'checked' : ''); ?> type="checkbox" data-on-color="success" data-off-color="danger" data-on-text="Enabled" data-off-text="Disabled">
										</div>
                                        <?php if($siteSetting->message): ?>
                                        <p class="text-muted font-13"><?php echo $siteSetting->message; ?></p>
										<?php endif; ?>
                                        <form id="<?php echo e($siteSetting->type); ?>" style="display: <?php echo e(($siteSetting->status == 1) ? 'block' : 'none'); ?>;">
                                            <input type="hidden" name="type" value="<?php echo e($siteSetting->type); ?>">
											<?php if($siteSetting->type == 'customer_account_activation'): ?>
												<p class="text-muted font-13">Select account verification via SMS/Email. </p>
		                                        <label for="email<?php echo e($siteSetting->id); ?>"> <input type="radio" name="value" value="email" onclick="siteSettingValueUpdate('<?php echo e($siteSetting->type); ?>')"  <?php echo e(($siteSetting->value == 'email') ? 'checked' : ''); ?> id="email<?php echo e($siteSetting->id); ?>">
		                                        Email</label> 
		                                        <label for="sms<?php echo e($siteSetting->id); ?>"> <input type="radio" name="value" value="sms" onclick="siteSettingValueUpdate('<?php echo e($siteSetting->type); ?>')" <?php echo e(($siteSetting->value == 'sms') ? 'checked' : ''); ?> id="sms<?php echo e($siteSetting->id); ?>">
		                                        SMS</label>

											<?php endif; ?>

											<?php if($siteSetting->type == 'vendor_account_activation'): ?>
												<p class="text-muted font-13">Select account verification via SMS/Email.</p>
		                                        <label for="email<?php echo e($siteSetting->id); ?>"> <input type="radio" name="value" value="email" onclick="siteSettingValueUpdate('<?php echo e($siteSetting->type); ?>')" <?php echo e(($siteSetting->value == 'email') ? 'checked' : ''); ?> id="email<?php echo e($siteSetting->id); ?>">
		                                        Email</label> 
		                                        <label for="sms<?php echo e($siteSetting->id); ?>"> <input type="radio" name="value" value="sms" onclick="siteSettingValueUpdate('<?php echo e($siteSetting->type); ?>')" <?php echo e(($siteSetting->value == 'sms') ? 'checked' : ''); ?> id="sms<?php echo e($siteSetting->id); ?>">
		                                        SMS</label>
											<?php endif; ?>

											<?php if($siteSetting->type == 'facebook_login' || $siteSetting->type == 'google_login' || $siteSetting->type == 'twitter_login'): ?>
											 	<p class="text-muted font-13">You need to configure <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> Client correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('socialLoginSetting')); ?>">Configure Now</a>
											<?php endif; ?>

                                            <?php if($siteSetting->type == 'customer_withdraw_configure'): ?>
                                                <p class="text-muted font-13">You need to <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> Client correctly to enable this feature. </p> 
                                                <a target="_blank" href="<?php echo e(route('customer.withdrawConfigure')); ?>">Withdraw Configure Now</a>
                                            <?php endif; ?>

											<?php if($siteSetting->type == 'google_recaptcha'): ?>
											 	<p class="text-muted font-13">You need to configure <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('google_recaptcha')); ?>">reCaptcha Configure Now</a>
											<?php endif; ?>

											<?php if($siteSetting->type == 'free_ads_limit'): ?>
											 	<p class="text-muted font-13">You need to configure <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('freeAdsLimit')); ?>">Ads Duration</a>
											<?php endif; ?>

                                            <?php if($siteSetting->type == 'discount_config'): ?>
                                                <p class="text-muted font-13">You need to configure <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
                                                <a target="_blank" href="<?php echo e(route('discountConfig')); ?>">Ads Duration</a>
                                            <?php endif; ?>

											<?php if($siteSetting->type == 'refund_request'): ?>
											 	<p class="text-muted font-13">You need to configure <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('admin.refundConfig')); ?>">Set refund request </a>
											<?php endif; ?>

											<?php if($siteSetting->type == 'otp_configurations'): ?>
												
											 	<p class="text-muted font-13">You need to <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('otp_configurations')); ?>">OTP configurations now</a>
											<?php endif; ?>

											<?php if($siteSetting->type == 'smtp_configurations'): ?>
											 	<p class="text-muted font-13">You need to <?php echo e(str_replace('_', ' ', $siteSetting->type)); ?> correctly to enable this feature. </p> 
											 	<a target="_blank" href="<?php echo e(route('smtp_settings')); ?>">smtp configurations now</a>
											<?php endif; ?>
											
										</form>
									</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script type="text/javascript">

        //change status by field type
        function siteSettingActiveDeactive(el, field){

        	if($(el).is(':checked')){
              $('#'+field).show();
            }
            else{
                $('#'+field).hide();
            }
            var  url = '<?php echo e(route("siteSettingActiveDeactive")); ?>';
            $.ajax({
                url:url,
                method:"get",
                data:{field:field},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }

        //set value 
        function siteSettingValueUpdate(type){
        
            $.ajax({
                url:'<?php echo e(route("siteSettingUpdate")); ?>',
                type:'get',

                data:$('#'+type).serialize(),
                success:function(data){
                    if(data.status == 'success'){
                        toastr.success(data.msg);
                    }else{
                        toastr.error('Update failed.');
                    }
                 }
            });
        }
    </script>  
    <!-- bt-switch -->
    <script src="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/setting/site-setting.blade.php ENDPATH**/ ?>