<div class="product-detail user-profile col-md-3 col-sm-4 col-xs-12" >
    <aside style="background: #fff;padding-top: 10px;transform: scale(1.0);" class="user-sitebar-dashboard">
        
        <div class="profileImageBox">
            <div class="dash-avatar">
                <a href="#"><img data-toggle="tooltip" data-original-title="Upoad Profile Image" src="<?php echo e(asset('upload/users')); ?>/<?php echo e((Auth::user()->photo) ? Auth::user()->photo : 'default.png'); ?>"></a>
            </div>
            
            <span  data-toggle="modal" data-target="#user_imageModal" class="uploadIcon" ><i class="fa fa-camera"></i></span>
            <span  data-toggle="modal" data-target="#user_imageModal" style=" position: absolute;bottom: 12px;border: 1px solid #ccc;right: 95px;border-radius: 50%;padding: 0px 7px;background: #ccc;"><i class="fa fa-camera"></i></span>
        </div>
        <p style="text-align: center;"><strong><?php echo e(Auth::user()->name); ?></strong></p>
    
        <div class="module-content custom-border ">
            <ul class="list-box">
                 
                <li><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="<?php echo e(route('post.create')); ?>"><i class="fa fa-pencil-alt"></i> Ads Post</a></li>
               
                <li class="navbar-dropdown" style="">
                    <a class="navbar-link" href="javascript:void(0)">
                        <span><i style="font-size: 16px;" class="fa fa-th-list"></i> My Ads</span>
                        <i class="fas fa-plus"></i>
                    </a>
                    <ul class="dropdown-list" style="display: none;">
                        <li><a href="<?php echo e(route('post.list')); ?>">All Ads</a></li>
                        <li><a href="<?php echo e(route('post.list', 'active')); ?>">Active Ads</a></li>
                        <li><a href="<?php echo e(route('post.list', 'deactive')); ?>">Deactive Ads</a></li>
                        <li><a href="<?php echo e(route('post.list', 'reject')); ?>">Reject Ads</a></li>
                        <li><a href="<?php echo e(route('post.list', 'pending')); ?>">Pending Ads</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo e(route('user.packageHistory')); ?>"><i class="fa fa-clipboard-list"></i> My Package</a></li>
                <li><a href="<?php echo e(route('blog.list')); ?>"><i class="fa fa-pen-square"></i> Blogs</a></li>
                <li><a href="<?php echo e(route('user.message')); ?>"><i class="fa fa-comment"></i> Message</a></li>
                <li><a href="<?php echo e(route('wishlists')); ?>"><i class="fa fa-heart"></i> Wishlist</a></li>
                
                <li><a href="<?php echo e(route('user.myAccount')); ?>"><i class="fa fa-user"></i> My Profile</a></li>
                <li><a href="<?php echo e(route('verifyAccount')); ?>"><i class="fa fa-user-plus"></i> Seller verification</a></li>
                <li><a href="<?php echo e(route('user.change-password')); ?>"><i class="fa fa-edit"></i> Change Password </a></li>
                <li><a href="<?php echo e(route('userLogout')); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                 
            </ul>
        </div>
    </aside>
</div>
<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/inc/sidebar.blade.php ENDPATH**/ ?>