
<?php $__env->startSection('title', 'Dashboard | '. Config::get('siteSetting.site_name') ); ?>
<?php $__env->startSection('css'); ?>
 <link rel="stylesheet" href="<?php echo e(asset('frontend')); ?>/css/custom/dashboard.css">
<style type="text/css">
    .country-state li {
    margin-top: 0px;
    margin-bottom: 10px;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="margin-top:10px">

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center> <img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(( $user->photo) ? $user->photo : 'default.png'); ?>" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10"><?php echo e($user->name); ?></h4>
                                    <h6 class="card-subtitle"><?php echo e($user->user_dsc); ?></h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-6"><a title="User status" href="javascript:void(0)" class="link"><i class="fa fa-check"></i> <font class="font-medium"><?php echo e($user->status); ?> </font></a></div>
                                        <div class="col-6"><a title="Total Tickets " href="javascript:void(0)" class="link"> <?php if($user->verify): ?> <span class="label label-success"> Verified </span> <?php else: ?> <span class="label label-danger">Unverify</span> <?php endif; ?></a></div>
                                    </div>
                                </center>
                                <hr/>
                                <small class="text-muted">Mobile</small>
                                <h6><?php echo e($user->mobile); ?></h6> 
                                <small class="text-muted">Email</small>
                                <h6><?php echo e($user->email); ?></h6> 

                                <small class="text-muted">Member Since </small>
                                <h6><?php echo e(Carbon\Carbon::parse($user->created_at)->format(Config::get('siteSetting.date_format'))); ?></h6> 
                                <small class="text-muted p-t-30 db">Birthday</small>
                                <h6><?php echo e(Carbon\Carbon::parse($user->birthday)->format(Config::get('siteSetting.date_format'))); ?></h6> 
                                <p>Gender: <?php echo e($user->gender); ?>, Blood: <?php echo e($user->blood); ?></p>
                                <small class="text-muted p-t-30 db">Address</small>
                                <h6><?php echo e($user->address); ?> 
                                    <?php if($user->get_area): ?><?php echo e($user->get_area['name']); ?> <?php endif; ?>
                                    <?php if($user->get_city): ?> <?php echo e($user->get_city['name']); ?> <?php endif; ?>
                                    <?php if($user->get_state): ?><?php echo e($user->get_state['name']); ?> <?php endif; ?></h6>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3><?php echo e($total_posts); ?></h3>
                                                <h6 class="card-subtitle">Total Post</h6></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3><?php echo e($pending_posts); ?></h3>
                                                <h6 class="card-subtitle">Pending Post</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3><?php echo e($total_task); ?></h3>
                                                <h6 class="card-subtitle">Total Task</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3><?php echo e($pending_task); ?></h3>
                                                <h6 class="card-subtitle">Pending Task</h6></div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Working</h4>
                                <table class="table no-border">
                                    <tbody>
                                        <tr>
                                            <td><h4>Task Attend</h4></td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Satisfied</h4> 
                                                <small>Approved in task</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Not Satisfied</h4> 
                                                <small>Rejected in task prove</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Pending</h4> 
                                                <small>In review for rating</small>
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Deleted/Removed task</h4> 
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4>Payment Received</h4> 
                                            </td>
                                            <td class="font-medium"><strong>0</strong></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                  
                </div>
                
            </div>
        </div>
<?php $__env->stopSection(); ?>     
    



<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/dashboard.blade.php ENDPATH**/ ?>