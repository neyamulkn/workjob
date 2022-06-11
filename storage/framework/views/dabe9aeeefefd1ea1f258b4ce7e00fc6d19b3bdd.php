
<?php $__env->startSection('title', 'Notifications'); ?>

<?php $__env->startSection('css'); ?>
<style type="text/css" src="<?php echo e(asset('css/pages/other-pages.css')); ?>"></style>
    <style type="text/css">
        .inbox-chat-list{overflow-y: scroll;min-height: 250px;}}
        .active{background: #25b90a1a;}
        .removeMessage{background: rgb(225 221 221 / 40%);color: #b56161;border-radius: 5px;padding: 5px;font-size: 12px;}
    .notify-item {border-bottom: 1px solid #e9e9e9;list-style: none;margin-bottom: 10px;padding-bottom: 5px;}
    .notify-link{display: flex;line-height: normal;}
    .notify-link p{margin-bottom: 0;}
    .notify-filter{    display: flex;
    justify-content: space-between; margin-bottom: 10px;}
    .search-listing{padding: 6px;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Job lists</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Job</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="<?php echo e(route('post.create')); ?>" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search Result For "Angular Js"</h4>
                                <h6 class="card-subtitle">About 14,700 result ( 0.10 seconds)</h6>
                                <div class="notify-filter">
                                <select onchange="markMotification(this.value)" class="select notify-select">
                                    <option <?php if(Request::get('mark') == 'all'): ?> selected <?php endif; ?> value="all">All notification</option>
                                    <option <?php if(Request::get('mark') == 'read'): ?> selected <?php endif; ?> value="read">Read notification</option>
                                    <option <?php if(Request::get('mark') == 'unread'): ?> selected <?php endif; ?> value="unread">Unread notification</option>
                                </select>
                                <div class="notify-action">
                                    
                                    <a style="width:100%; border-radius: 5px; line-height: 28px; padding:5px;" href="<?php echo e(route('readNotify')); ?>" title="Mark All As Read" class="fas fa-envelope-open"> Mark Read</a>
                                    <!-- <a href="#" title="Notification Setting" class="fas fa-cog"></a> -->
                                </div>
                            </div>
                                <ul class="search-listing">
                                <?php if(count($notifications )>0): ?>
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($notification->type == 'post'): ?>
                                <?php if($notification->product): ?>
                                    <li class="notify-item <?php if($notification->read == 0): ?> active <?php endif; ?>">
                                        <a onclick="readNotify('<?php echo e($notification->id); ?>')" href="<?php echo e(route('job_details', $notification->product->slug)); ?>" class="notify-link">
                                            <div class="notify-img">
                                                <img width="25" src="<?php echo e(asset('upload/images/product/thumb/'. $notification->product->feature_image)); ?>" alt="avatar">
                                            </div>
                                            <div class="notify-content">
                                                <p class="notify-text"><?php if($notification->user): ?><span><?php echo e($notification->user->name); ?>: </span><?php endif; ?><span><?php echo e($notification->notify); ?></span>  <?php echo e(Str::limit($notification->product->title, 25)); ?></p>
                                                <span class="notify-time"><?php echo e(Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?></span>
                                            </div> 
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php elseif($notification->type == 'package'): ?>
                                    <li class="notify-item <?php if($notification->read == 0): ?> active <?php endif; ?>">
                                        <a onclick="readNotify('<?php echo e($notification->id); ?>')" href="<?php echo e(route('user.packageHistory')); ?>#<?php echo e($notification->item_id); ?>" class="notify-link">
                                            <div  class="notify-img">
                                                 <img width="25" src="https://img.favpng.com/19/10/20/blue-computer-icon-area-symbol-png-favpng-Rsn1G41w4PgR3fpkZntM1wVrZ.jpg" alt="avatar">
                                            </div>
                                            <div class="notify-content">
                                                <p class="notify-text"> <?php echo e($notification->notify); ?> </p>
                                                <span class="notify-time"><?php echo e(Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php elseif($notification->type == 'register'): ?>{
                                    <li class="notify-item <?php if($notification->read == 0): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(route('user.dashboard')); ?>" class="notify-link">
                                        <div class="notify-img">
                                            <img src="<?php echo e(asset('frontend/images/post.png')); ?>" alt="avatar">
                                        </div>
                                        <div class="notify-content">
                                            <p class="notify-text"><span><?php echo e($notification->notify); ?></span></p>
                                            <span class="notify-time"><?php echo e(Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?></span>
                                        </div>
                                    </a>
                                </li>
                                }
                                <?php else: ?>

                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <h3>No notification found.</h3>
                                <?php endif; ?>
                                    
                                </ul>
                                <nav aria-label="Page navigation example" class="m-t-40">
                                        <?php echo e($notifications->links()); ?>

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
 
    </div>
</div>
<?php $__env->stopSection(); ?>   

<?php $__env->startSection('js'); ?> 
      <script type="text/javascript">
          function markMotification(read) {
           if (read != undefined && read != null) {
                window.location = '<?php echo e(route("allNotifications")); ?>?mark=' + read;
            }
          }
      </script>
<?php $__env->stopSection(); ?>    
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/notifications/notifications.blade.php ENDPATH**/ ?>