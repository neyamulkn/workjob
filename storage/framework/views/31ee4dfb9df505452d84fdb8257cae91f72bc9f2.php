<li>
    <div class="drop-title">Notifications</div>
</li>
<li>
    <div class="message-center">

        <?php if(count($notifications )>0): ?>
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($notification->type == 'post' || $notification->type == 'userStatus' ): ?>
            <?php if($notification->product): ?>
            <!-- Message -->
            <a href="<?php echo e(route('job_details', $notification->product->slug)); ?>">
                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                <div class="mail-contnet">
                    <h5><?php if($notification->user): ?><span><?php echo e($notification->user->name); ?>: </span><?php endif; ?></h5> <span class="mail-desc"><?php echo e($notification->notify); ?></span> <span class="time"><?php echo e(Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?></span> </div>
            </a>
            <?php else: ?>

            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <a href="javascript:void(0)">No notification found.</a>
        <?php endif; ?>
    </div>
</li>
<li>
    <a class="nav-link text-center link" href="<?php echo e(route('allNotifications')); ?>"> <strong>View notifications</strong> <i class="fa fa-angle-right"></i> </a>
</li><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/notifications/notify-item-list.blade.php ENDPATH**/ ?>