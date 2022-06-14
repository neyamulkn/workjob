
<?php $__env->startSection('title', 'Account Verification'); ?>

<?php $__env->startSection('css'); ?>
 <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.dropify-wrapper{height: 125px;padding: 5px;}
	    .adjust-field{cursor: pointer; border: none;border-radius:0;position: absolute;top: 0;right: 0;background: #e9ecef;padding: 7px;}

	    .dropify-wrapper.touch-fallback{height: 115px!important;}
.dropify-wrapper{height: 120px!important;padding: 5px; overflow: hidden ;}
 @media (max-width: 768px) { label.required{font-size: 12px;}
.dropify-wrapper .dropify-message{top: initial;}}
.dropify-wrapper.touch-fallback .dropify-clear{top: 3px; right: 3px; bottom: inherit;}
.fa-check-square{color: green;}
  .addNumber{position: relative;margin-right: 10px;width: 320px;border-bottom: 1px solid #e5e5e5;padding: 5px;}
  .removeNumber{color:red;padding: 3px 5px;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
    <div class="container-fluid">
			
		<!-- Main Container  -->
		<div class="container">

			<div class="row">
				<!--Right Part Start -->
				
				<!--Middle Part Start-->
				<div class="col-md-9 sticky-conent" >
				
					<form action="<?php echo e(route('verifyAccount')); ?>" method="post" enctype="multipart/form-data" data-parsley-validate>
						<?php echo csrf_field(); ?>
						<div class="row offset-md-2" style="background:#fff">
								<div class="col-sm-12">
								<fieldset id="personal-details">
									<legend>Account Verification</legend></fieldset>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="name" class="control-label required">Full Name</label>
										<input type="text" required class="form-control" id="name" placeholder="Full Name" value="<?php echo e($user->name); ?>" name="name">
									</div>
								</div>

								

								<div class="col-sm-6">
									<div class="form-group">
										<label for="name" class="control-label required">Country</label>
										<select name="country" class="form-control">
											<?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option <?php if($user->country == $location->id): ?> selected <?php endif; ?> value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</div>
								</div>

								
								
								<div class="col-12 col-md-6" style="padding-right: 5px;padding-top: 5px;">   
									<label class="required">Choose Card</label>                         
									<select name="cardType" class="form-control">
										<option <?php if($user->cardType == 'nid'): ?> selected <?php endif; ?> value="nid"> NID Card</option>
										<option <?php if($user->cardType == 'passport'): ?> selected <?php endif; ?> value="passport"> Passport</option>
										<option <?php if($user->cardType == 'driving_lichance'): ?> selected <?php endif; ?> value="driving_lichance"> Driving lichance</option>
									</select>
		                        </div>

		                        <div class="col-6" >   
									<label class="required">Card Number</label>
									<input type="text" name="cardNumber" value="<?php echo e($user->cardNumber); ?>" class="form-control" >
		                        </div>

		                        <div class="col-6" >   
									<label class="required">Card Front Side</label>                         
									<input type="file" <?php if($user->nid_front): ?> data-default-file="<?php echo e(asset('upload/users/'.$user->nid_front)); ?>" <?php else: ?> required <?php endif; ?> data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="nid_front" >
		                        </div>

		                        <div class="col-6" >   
									<label class="required">Card Back Side</label>                         
									<input type="file" <?php if($user->nid_back): ?> data-default-file="<?php echo e(asset('upload/users/'.$user->nid_back)); ?>" <?php else: ?> required <?php endif; ?> data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  class="dropify" name="nid_back"  >
		                        </div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="name" class="control-label required">About</label>
										<textarea name="about" rows="1" class="form-control"><?php echo e($user->user_dsc); ?></textarea>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group ">
										<span class="required">Address</span>
										<textarea required class="form-control" id="address" placeholder="For example: #road:2, #sector: 3, Dhaka-1215" name="address"><?php echo e($user->address); ?></textarea>
										
									</div>
								</div>
								<div class="buttons clearfix">
								
								<div class="pull-right">
									<input type="submit" class="btn btn-md btn-primary" value="Verify Account">
								</div>
								
							</div>
							
							</div>
							
					</form>
				</div>
				<!--Middle Part End-->
			</div>
		</div>
		</div>
		</div>
		<!-- //Main Container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('js/parsley.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
</script>
<script type="text/javascript">

	    function moreMobile(number=null){
       
        $('#moreMobile').html(`
        <div style="display:flex; margin-bottom: 10px;">
        
        <div style="position: relative;width: 100%;">
        <input type="number" id="number" value="`+number+`" required name="contact_mobile" class="form-control" placeholder="Enter your number">
        <span class="adjust-field" onclick="addNumber()"> Add</span>
       
        </div>
        </div>`);
    }



    function removeNumber(number) {
       $('#'+number).remove();
       if($('.contact_mobile').val() == null){
            moreMobile();
       }
    }


     function moreEmail(email=''){
       
        $('#moreEmail').html(`
        <div style="display:flex; margin-bottom: 10px;">
        
        <div style="position: relative;width: 100%;">
        <input type="email" id="email" value="`+email+`" required name="email" class="form-control" placeholder="Enter your email">
        <span class="adjust-field" onclick="addEmail()"> Add</span>
       
        </div>
        </div>`);
    }

   

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/seller-verify.blade.php ENDPATH**/ ?>