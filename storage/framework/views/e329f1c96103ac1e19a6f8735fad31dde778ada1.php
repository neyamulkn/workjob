
<?php $__env->startSection('title', 'Account Verification | '.Config::get('siteSetting.site_name')); ?>
<?php $__env->startSection('css-top'); ?>

<style type="text/css">
    @media (min-width: 1200px){
        .container {
            max-width: 1200px !important;
        }
    }
    .dropdown-toggle::after, .dropup .dropdown-toggle::after {
        content: initial !important;
    }
    .card-footer, .card-header {
        margin-bottom: 5px;
        border-bottom: 1px solid #ececec;
    }

    .loginArea{background: #fff; border-radius: 5px;margin:10px 0;padding: 20px;}
</style>
 <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div id="pageLoading" style="display: none;"></div>
    <div class="row justify-content-center">
       
        <div class="col-md-6 col-xs-12 ">
            <div class="card loginArea">
                <div class="card-body">
                    <div id="loginform">
                        <div class="col-xs-12">
                            <h3 style="text-align: center;">Account Verification</h3>
                            <?php if(Session::has('status')): ?>
                            <div class="alert alert-success">
                              <strong>Success! </strong> <?php echo e(Session::get('status')); ?>

                            </div>
                            <?php endif; ?>
                            <?php if(Session::has('error')): ?>
                            <div class="alert alert-danger">
                              <?php echo e(Session::get('error')); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if(Request::get('mobile')): ?> 
                        <form class="form-horizontal" data-parsley-validate  method="get" id="recoverResetform" action="<?php echo e(route('userAccountVerify')); ?>">
                           
                            <input type="hidden" name="mobile" value="<?php echo e(Request::get('mobile')); ?>">
                            <p>Please enter the 4-digit verification code we sent via SMS:</p>
                            <div class="row">
                                <div class="col-xs-9 col-sm-8">
                                    <input class="form-control" value="<?php echo e(old('otp_code')); ?>" name="otp_code" type="text" minlength="4" required placeholder="Enter your OTP Code."> 
                                    <?php if($errors->has('otp_code')): ?>
                                        <span class="error" role="alert">
                                           <?php echo e($errors->first('otp_code')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-xs-3 col-sm-4">
                                    <button class="btn btn-primary" type="submit">Verify</button>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="line-height: 2">
                                    <span> <?php echo e(__('If you did not receive the sms')); ?>?</span><br/>
                                    <a href="<?php echo e(route('resendVerifyToken')); ?>?token=<?php echo e(Request::get('mobile')); ?>"> Send code again</a><br/>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>      
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <p> <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?></p>
                            </div>
                            <div class="col-xs-12" style="line-height: 2">
                                <span> <?php echo e(__('If you did not receive the email')); ?></span><br/>
                                <a href="<?php echo e(route('resendVerifyToken')); ?>?token=<?php echo e(Request::get('email')); ?>"> <?php echo e(__('click here to request another')); ?></a><br/>
                            </div>
                        </div>
                        
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="actions-toolbar">
                <div class="col-sm-12 text-center">
                    Back to login <a href="<?php echo e(route('login')); ?>" class="text-info m-l-5"><b>Login</b></a>
                </div>
            </div>  
            <div class="col-md-3 col-xs-12"></div>     
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
     $('#sendBtn').click('on', function(){
        var token = $('#token').val();
        if(token){
            $('#sendBtn').html('Sending...');
        }
    });
        
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/verify-account.blade.php ENDPATH**/ ?>