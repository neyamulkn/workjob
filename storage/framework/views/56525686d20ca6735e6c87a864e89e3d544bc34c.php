<style type="text/css">.modulelist{display: none;}</style>
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
              
                <?php
                $role_id = Auth::guard('admin')->user()->role_id;
               
                $modules = App\Models\Module::where('parent_id', null)->with(['rolePermission' => function ($query) use ($role_id) { $query->where('role_id', $role_id); }, 'sub_modules' => function ($query) use ($role_id){
                    if($role_id != SUPER_ADMIN){
                        $query->where('status', 1);
                    }
                	$query->where('is_hidden_sidebar', null)->with(['rolePermission' => function ($query) use ($role_id) { $query->where('role_id', '=', $role_id); }]);
                }]);
                if($role_id != SUPER_ADMIN){
                    $modules->where('status', 1);
                }
                $modules = $modules->orderBy('position', 'asc')->get()->toArray();
               
                ?>
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <?php $modulePermission = $module['role_permission']; ?>
            <?php if($module['slug'] == 'dashboard'): ?>
	                <?php if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1)): ?>
	                <li> <a class="waves-effect waves-dark" href="<?php echo e(route('admin.dashboard')); ?>" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?></span></a></li>
	                <?php endif; ?>
            <?php elseif($module['slug'] == 'post'): ?>

                <?php $pendingPosts = App\Models\Product::where('status', 'pending')->count(); ?>
               
                <li class="modulelist module<?php echo e($module['id']); ?>">
                	<a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?>  <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($pendingPosts); ?></span> </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $permission = $submodule['role_permission']; ?>

                        <?php if($role_id == 1 || ($permission && $permission['is_view'] == 1)): ?>
                        <li><a href="<?php echo e(($submodule['route']) ? route($submodule['route'], $submodule['slug']) : 'javascript:void(0)'); ?>"><?php echo e($submodule['module_name']); ?> <?php if($submodule['slug'] == 'pending'): ?> <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($pendingPosts); ?></span> <?php endif; ?></a></li>
                        <style type="text/css">.module<?php echo e($module['id']); ?>{display: block;}</style>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
               <?php elseif($module['slug'] == 'packages'): ?>

                <?php $pendingpackage = App\Models\PackagePurchase::where('payment_method', '!=', 'pending')->where('payment_status', 'pending')->count(); ?>
                <li class="modulelist module<?php echo e($module['id']); ?>">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?>  <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($pendingpackage); ?></span> </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $permission = $submodule['role_permission']; ?>

                        <?php if($role_id == 1 || ($permission && $permission['is_view'] == 1)): ?>
                        <li><a href="<?php echo e(($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'); ?>"><?php echo e($submodule['module_name']); ?> <?php if($submodule['slug'] == 'purchase-package'): ?> <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($pendingpackage); ?></span> <?php endif; ?></a></li>
                        <style type="text/css">.module<?php echo e($module['id']); ?>{display: block;}</style>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
               
            <?php elseif($module['slug'] == 'blog-posts'): ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) )): ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                    	<?php if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1): ?>
                        <li><a href="<?php echo e(route('admin.blog.upload')); ?>">Add New Blog</a></li>
                        <?php endif; ?>
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1): ?>
                        <li><a href="<?php echo e(route('admin.blog.list')); ?>">Manage Blog</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            <?php elseif($module['slug'] == 'staff'): ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) )): ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1): ?>
                        <li><a href="<?php echo e(route('staff.create')); ?>">Add New Staff</a></li>
                        <?php endif; ?>
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1): ?>
                        <li><a href="<?php echo e(route('staff.list')); ?>">Manage Staff</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

            <?php elseif($module['slug'] == 'manage-pages'): ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && ($modulePermission['is_add'] == 1 || $modulePermission['is_view'] == 1) )): ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_add'] == 1): ?>
                        <li><a href="<?php echo e(route('page.create')); ?>">Add New Page</a></li>
                        <?php endif; ?>
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1): ?>
                        <li><a href="<?php echo e(route('page.list')); ?>">Page list</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?> 
            <?php elseif($module['slug'] == 'account-setting'): ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1 )): ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php if($role_id == SUPER_ADMIN || $modulePermission['is_view'] == 1): ?>
                        <li><a href="<?php echo e(route('admin.profileUpdate')); ?>">Profile Setting</a></li>
                        
                        <li><a href="<?php echo e(route('admin.passwordChange')); ?>">Change Password</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            <?php elseif($module['slug'] == 'reports'): ?>
                <li class="modulelist module<?php echo e($module['id']); ?>">
                    <a class="has-arrow waves-effect waves-dark" href="<?php echo e(($module['route']) ? route($module['route']) : 'javascript:void(0)'); ?>" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?>  </span></a>
                    
                    <ul aria-expanded="false" class="collapse">
                        <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $permission = $submodule['role_permission']; ?>

                        <?php if($role_id == 1 || ($permission && $permission['is_view'] == 1)): ?>
                        <li><a href="<?php echo e(($submodule['route']) ? route($submodule['route'], $submodule['slug']) : 'javascript:void(0)'); ?>"><?php echo e($submodule['module_name']); ?></a></li>
                        <style type="text/css">.module<?php echo e($module['id']); ?>{display: block;}</style>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
           <?php elseif($module['slug'] == 'manage-users'): ?>
                <?php $verifyRequest = App\User::whereNotNull('shop_name')->whereNull('verify')->count(); ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1) ): ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Manage Users <span class="badge badge-pill badge-primary text-white ml-auto"><?php echo e($verifyRequest); ?></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo e(route('customer.list')); ?>">All Users</a></li>
                        <li><a href="<?php echo e(route('customer.list', 'active')); ?>">Active Users</a></li>
                        <li><a href="<?php echo e(route('customer.list', 'band')); ?>">Banded Users</a></li>
                        <li><a href="<?php echo e(route('customer.list', 'verified')); ?>">Verified Users</a></li>
                        <li><a href="<?php echo e(route('customer.list', 'unverified')); ?>">Unverified Users</a></li>
                        <li><a href="<?php echo e(route('userVerifyRequest')); ?>">Verified Request <span class="badge badge-pill badge-primary text-white ml-auto"><?php echo e($verifyRequest); ?></span></a></li>
                    </ul>
                </li>
                <?php endif; ?>
            <?php elseif($module['slug'] == 'wallet'): ?>
                <li>
                    <?php $withdrawRequest = App\Models\Transaction::where('customer_id', '!=', null)->where('status', 'pending')->count(); ?>

                    <a class="<?php if(count($module['sub_modules'])>0): ?> has-arrow <?php endif; ?> waves-effect waves-dark" href="<?php echo e(($module['route']) ? route($module['route']) : 'javascript:void(0)'); ?>" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?> <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($withdrawRequest); ?></span></span></a>
                    <?php if(count($module['sub_modules'])>0): ?>
                    <ul aria-expanded="false" class="collapse">
                        <li> <a href="<?php echo e(route('customerWalletHistory')); ?>">Wallet History</a></li>
                        <li> <a href="<?php echo e(route('customerWithdrawRequest')); ?>">Withdraw Request <span class="badge badge-pill badge-cyan ml-auto"><?php echo e($withdrawRequest); ?></span></a></li>
                        <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $permission = $submodule['role_permission']; ?>
                        <li><a href="<?php echo e(($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'); ?>"><?php echo e($submodule['module_name']); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php else: ?> 
                <?php if(count($module['sub_modules'])>0): ?>   
                <li class="modulelist module<?php echo e($module['id']); ?>">
                    <a class="<?php if(count($module['sub_modules'])>0): ?> has-arrow <?php endif; ?> waves-effect waves-dark" href="<?php echo e(($module['route']) ? route($module['route']) : 'javascript:void(0)'); ?>" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?> </span></a>
                   
                    <ul aria-expanded="false" class="collapse">
                        <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $permission = $submodule['role_permission']; ?>

                        <?php if($role_id == SUPER_ADMIN || ($permission && $permission['is_view'] == 1)): ?>
                        <li><a href="<?php echo e(($submodule['route']) ? route($submodule['route']) : 'javascript:void(0)'); ?>"><?php echo e($submodule['module_name']); ?> </a></li>
                        <style type="text/css">.module<?php echo e($module['id']); ?>{display: block;}</style>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
                <?php else: ?>
                <?php if($role_id == SUPER_ADMIN || ($modulePermission && $modulePermission['is_view'] == 1)): ?>
                <li>
                    <a class="waves-effect waves-dark" href="<?php echo e(($module['route']) ? route($module['route']) : 'javascript:void(0)'); ?>" aria-expanded="false"><i class="<?php echo e($module['icon']); ?>"></i><span class="hide-menu"><?php echo e($module['module_name']); ?> </span></a></li>
                <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li> <a class="waves-effect waves-dark" href="<?php echo e(route('adminLogout')); ?>"  aria-expanded="false"><i class="fa fa-power-off text-success"></i><span class="hide-menu">Log Out</span></a></li>
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/partials/backend/admin-sidebar.blade.php ENDPATH**/ ?>