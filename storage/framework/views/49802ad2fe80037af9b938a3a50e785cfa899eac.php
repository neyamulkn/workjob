
<?php $__env->startSection('title', '404 page not found'); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/pages/error-pages.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   
    <section id="wrapper" class="error-page">
        <div class="error-box" style="position: relative !important;">
            <div class="error-body text-center">
               
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="<?php echo e(url('/')); ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
            
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/404.blade.php ENDPATH**/ ?>