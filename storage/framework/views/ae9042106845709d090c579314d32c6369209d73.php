<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo e(route('user.dashboard')); ?>">
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
                <li class="nav-item" style="line-height: 60px; padding: 5px;">
                    <a class=" btn btn-warning" href="javascript:void(0)" > Earning: <?php echo e(config('siteSetting.currency_symble') . Auth::user()->wallet_balance); ?></a>
                </li><li class="nav-item" style="line-height: 60px; padding: 5px;">
                    <a class=" btn btn-success" href="javascript:void(0)" > Deposit: <?php echo e(config('siteSetting.currency_symble') . Auth::user()->deposit_balance); ?></a>
                </li>

                <li class="nav-item dropdown">
                    <a <?php if(Auth::check()): ?> onclick="getNotification('notify-item-list')" <?php else: ?> data-toggle="modal" data-target="#so_sociallogin" <?php endif; ?> class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                        <div class="notify"> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox ">
                        <ul class="notify-item-list">
                            
                            
                        </ul>
                    </div>
                </li>

              
             
                <!-- ============================================================== -->
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(( Auth::user()->photo) ? Auth::user()->photo : 'default.png'); ?>" alt="user" class=""> <span class="hidden-md-down"><?php echo e(explode(' ', trim(Auth::user()->name))[0]); ?> &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                       
                         <a href="<?php echo e(route('user.dashboard')); ?>" class="dropdown-item"><i class="ti-user"></i> Profile</a>
                         <a href="<?php echo e(route('user.walletHistory')); ?>" class="dropdown-item"><i class="ti-money"></i> Wallet</a>
                         <a href="<?php echo e(route('topJobPoster')); ?>" class="dropdown-item"><i class="ti-user"></i> Top Job Poster</a>
                         <a href="<?php echo e(url('support')); ?>" class="dropdown-item"><i class="fas fa-question"></i> Support</a>
                        <a href="<?php echo e(route('user.change-password')); ?>" class="dropdown-item"><i class="fa fa-edit"></i> Change Password</a>
                        <a href="<?php echo e(route('userLogout')); ?>"
                        class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>

                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->

            </ul>
        </div>
    </nav>
</header>
<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/partials/frontend/header.blade.php ENDPATH**/ ?>