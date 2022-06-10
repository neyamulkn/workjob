<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="text/css" href="<?php echo e(asset('upload/images/logo/'. Config::get('siteSetting.favicon'))); ?>"/>
    <title><?php echo $__env->yieldContent('title'); ?></title>
  
    <!-- /*process bar*/ -->
    <style type="text/css">
    .pace{-webkit-pointer-events:none;pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none}.pace-inactive{display:none}.pace .pace-progress{background:#07c10d;position:fixed;z-index:2000;top:0;right:100%;width:100%;height:2px}
    </style>
    <?php echo $__env->make('layouts.partials.frontend.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="fixed-layout skin-blue-dark" >
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Please Wait...</p>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
    <div id="app">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php echo $__env->make('layouts.partials.frontend.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
      
        <?php echo $__env->make('layouts.partials.frontend.sidebar1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
       <!-- ============================================================== -->
        <?php echo $__env->yieldContent('content'); ?>


        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            <?php echo config('siteSetting.copyright_text'); ?>

        </footer>
    </div>
    </div>
    <!-- End Wrapper -->
    <!-- include js files -->
    <?php echo $__env->make('layouts.partials.frontend.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>