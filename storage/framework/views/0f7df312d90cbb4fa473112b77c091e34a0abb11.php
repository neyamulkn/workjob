
<?php $__env->startSection('title', $page->title . ' | '. Config::get('siteSetting.site_name') ); ?>

<?php $__env->startSection('metatag'); ?>
    <meta name="title" content="<?php echo e($page->meta_title); ?>">
    <meta name="description" content="<?php echo e($page->meta_description); ?>">
    <meta name="keywords" content="<?php echo e($page->meta_keywords); ?>" />
    
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="<?php echo e($page->title); ?>">
    <meta property="og:description" content="<?php echo e($page->meta_title); ?>">
    <meta property="og:image" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">
    <meta property="og:url" content="<?php echo e(url()->full()); ?>">
    <meta property="og:site_name" content="<?php echo e(Config::get('siteSetting.site_name')); ?>">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1323213265465">
    <meta property="fb:app_id" content="13212465454">
    <meta property="og:type" content="e-commerce">

    <!-- Schema.org for Google -->

    <meta itemprop="title" content="<?php echo e($page->meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($page->meta_title); ?>">
    <meta itemprop="image" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:title" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:description" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:site" content="<?php echo e(url('/')); ?>">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">
  
    <!-- Twitter - Product (e-commerce) -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

    <div class="container" style="background: #fff;">
        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="about_us">
                    <div class="about_wrapper">
                       <h3 class="title-page font-ct"><?php echo e($page->title); ?></h3>
                       <div class="content-page">
                        <?php echo $page->description; ?>

                       </div>
                    </div>
               </div>
         
            </div>
        </div>
    </div>
    </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/pages/page.blade.php ENDPATH**/ ?>