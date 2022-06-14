
<?php $__env->startSection('title', 'Change Password | '. Config::get('siteSetting.site_name') ); ?>
<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
	<div class="row">
		
		<div  id="content" class="col-md-9 sticky-conent">
			
			<form action="<?php echo e(route('user.change-password')); ?>" method="post" data-parsley-validate>
				<?php echo csrf_field(); ?>
				<div class="row">
					
					<div class="col-sm-6">
						<fieldset>
							<legend>Change Your Password</legend>
							<div class="form-group ">
								<label for="input-password" class="control-label">Old Password</label>
								<input type="password" required class="form-control"  placeholder="Old Password" value="" name="old_password">
							</div>
							<div class="form-group ">
								<label for="input-password" class="control-label">New Password</label>
								<input type="password" required class="form-control" minlength="6" id="password" placeholder="New Password" value="" name="password">
							</div>
							<div class="form-group ">
								<label for="input-confirm" class="control-label">New Password Confirm</label>
								<input type="password" class="form-control" id="input-confirm"  data-parsley-equalto="#password" required="" placeholder="New Password Confirm" value="" name="password_confirmation">
							</div>
						</fieldset>
						<div class="buttons clearfix">
							<div class="pull-right">
								<input type="submit" class="btn btn-md btn-primary" value="Save Changes">
							</div>
						</div>
					</div>
				</div>
				
			</form>
		</div>
		<!--Middle Part End-->
		
	</div>
</div>
</div>
<!-- //Main Container -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/password-change.blade.php ENDPATH**/ ?>