<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">
                <b><img width="32" src="<?php echo e(asset('upload/images/logo/'.config('siteSetting.favicon'))); ?>" alt="" class="light-logo" />
                </b><span>
             <!-- Light Logo text -->    
             <img src="<?php echo e(asset('upload/images/logo/'.config('siteSetting.logo'))); ?>" width="150" class="light-logo" alt="" /></span> 
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
               
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <a target="_blank" title="Go to homepage" class="nav-link dropdown-toggle waves-effect waves-dark" href="<?php echo e(url('/')); ?>" > <i class="fa fa-globe"></i></a>
                </li>
               
             
                <!-- ============================================================== -->
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo e(asset('assets/images/users')); ?>/<?php echo e(( Auth::guard('admin')->user()->photo) ? Auth::guard('admin')->user()->photo : 'default.png'); ?>" alt="user" class=""> <span class="hidden-md-down"><?php echo e(explode(' ', trim(Auth::guard('admin')->user()->name))[0]); ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <?php if(Auth::guard('admin')->user()->role_id == 'admin'): ?>
                        <a href="<?php echo e(route('generalSetting')); ?>" class="dropdown-item"><i class="ti-settings"></i> General Setting</a><?php endif; ?>
                         <a href="<?php echo e(route('admin.profileUpdate')); ?>" class="dropdown-item"><i class="ti-user"></i> Profile</a>
                        <a href="<?php echo e(route('admin.passwordChange')); ?>" class="dropdown-item"><i class="fa fa-edit"></i> Change Password</a>
                        <a href="<?php echo e(route('adminLogout')); ?>"
                        class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>

                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->

            </ul>
        </div>
    </nav>
</header>
<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/partials/backend/admin-header.blade.php ENDPATH**/ ?>