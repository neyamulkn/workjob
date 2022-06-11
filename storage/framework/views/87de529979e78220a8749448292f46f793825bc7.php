
<?php $__env->startSection('title', 'Login | '. Config::get('siteSetting.site_name') ); ?>
<?php  

    $reCaptcha = App\Models\SiteSetting::where('type', 'google_recaptcha')->first(); 

    $socailLogins = App\Models\SiteSetting::where('type', 'facebook_login')->orWhere('type', 'google_login')->orWhere('type', 'twitter_login')->get(); 
   
?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('frontend')); ?>/css/custom/user-form.css">
<?php if($reCaptcha->status == 1): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="user-form-part">
            <div class="user-form-banner">
                <div class="user-form-content">
                    <a href="#"><img src="<?php echo e(asset('upload/images/logo/'.Config::get('siteSetting.logo') )); ?>" alt="logo"></a>
                    <h1><?php echo e(Config::get('siteSetting.site_name')); ?></h1>
                    <p><?php echo e(Config::get('siteSetting.about')); ?></p>
                </div>
            </div>

            <div class="user-form-category" style="padding-top: 10px;">
                
              
                <div class="tab-pane active" id="login-tab" >
                    <div class="user-form-title">
                        <h2>Welcome!</h2>
                        <p>Use credentials to access your account.</p>
                        
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
                    <form action="<?php echo e(route('userLogin')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" required name="emailOrMobile" value="<?php echo e(old('emailOrMobile')); ?>" class="form-control" placeholder="Email Or Mobile">
                                   
                                    <?php if($errors->has('emailOrMobile')): ?>
                                        <span class="error" role="alert">
                                            <?php echo e($errors->first('emailOrMobile')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" name="password" required class="form-control" id="pass" placeholder="Password">
                                    <button type="button" class="form-icon"><i class="eye fas fa-eye"></i></button>
                                    <small class="form-alert">Password must be 6 characters</small>
                                    <?php if($errors->has('password')): ?>
                                        <span class="error" role="alert">
                                            <?php echo e($errors->first('password')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <?php if($reCaptcha->status == 1): ?>
                                    <div class="form-group">
                                        
                                        <div class="g-recaptcha" data-sitekey="<?php echo e($reCaptcha->public_key); ?>"></div>
                                        <span id="recaptcha-error" style="color: red"></span>
                                        
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="signin-check">
                                        <label class="custom-control-label" for="signin-check">Remember me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group text-right">
                                    <a href="<?php echo e(url('password/reset')); ?>" class="form-forgot">Forgot password?</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-inline">
                                        <i class="fas fa-unlock"></i>
                                        <span>Enter your account</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if(count($socailLogins)>0): ?>
                        <ul class="user-form-option">
                            
                            <?php $__currentLoopData = $socailLogins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socailLogin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($socailLogin->type == 'facebook_login' && $socailLogin->status == 1): ?>
                             <li >
                                <a class="facebook" href="<?php echo e(route('social.login', 'facebook')); ?>">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>facebook</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if($socailLogin->type == 'google_login' && $socailLogin->status == 1): ?>
                             <li>
                                <a class="google" href="<?php echo e(route('social.login', 'google')); ?>">
                                    <i class="fab fa-google"></i>
                                    <span>google</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if($socailLogin->type == 'twitter_login' && $socailLogin->status == 1): ?>
                             <li>
                                <a class="twitter" href="<?php echo e(route('social.login', 'twitter')); ?>">
                                    <i class="fab fa-twitter"></i>
                                    <span>twitter</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if($socailLogin->type == 'linkedin_login' && $socailLogin->status == 1): ?>
                            <li>
                                <a class="google" href="<?php echo e(route('social.login', 'linkedin')); ?>">
                                    <i class="fab fa-linkedin"></i>
                                    <span>linkedin</span>
                                </a>
                            </li>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                    <div class="user-form-direction">
                        <p>Don't have an account? click on the <a href="<?php echo e(url('register')); ?>" >( sign up )</a></p>
                    </div>
                </div>

            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    <?php if($reCaptcha->status == 1): ?>
        $("#loginform").submit(function(event) {

           var recaptcha = $("#g-recaptcha-response").val();
           if (recaptcha === "") {
              event.preventDefault();
              $("#recaptcha-error").html("Recaptcha is required");
           }
        });
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/auth/login.blade.php ENDPATH**/ ?>