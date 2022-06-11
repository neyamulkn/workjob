

<?php $__env->startSection('title', $post->title . ' | '. Config::get('siteSetting.site_name') ); ?>
<?php $__env->startSection('css'); ?>
 <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
    .dropify-wrapper{height: 150px!important;padding: 5px; overflow: hidden ;}
    .work_screenshot label{font-size: 12px;margin-bottom: 5px;}
    .details{padding: 10px;}
 </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
           
                <div class="row">
                   
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        
                        <form action="<?php echo e(route('applicantStatusUpdate', $applicant->id)); ?>" method="post" data-parsley-validate enctype="multipart/form-data"> 
                        <?php echo csrf_field(); ?>
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item" style="padding:10px"><h3><?php echo e($post->title); ?> </h3></li>
                            </ul>
                            
                            <div class="card-body">
                                <img src="<?php echo e(asset('upload/images/post/'.$post->thumb_image)); ?>">
                               
                                <h4><i class="fa fas fa-tasks"></i> What is expected from workers?</h4>
                               <?php if($post->workstep): ?>
                                <?php $__currentLoopData = json_decode($post->workstep); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $workstep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div  class="details">
                                    <?php echo e($workstep); ?>

                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4><i class="fa fas fa-tasks"></i> REQUIRED PROOF THAT TASK WAS FINISHED?</h4>
                                <div class="details"><?php echo e($post->workProve); ?></div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4><i class="fa fa-pencil-alt"></i>WORK PROVE DETAILS?</h4>
                                <div class="details">
                                    <?php echo $applicant->work_prove; ?>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body row work_screenshot">
                                <div class="col-12">WORK PROVE SCREENSHOT</div> 
                                <?php if($applicant->screenshots): ?>
                                    <?php $__currentLoopData = json_decode($applicant->screenshots); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $screenshot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6">
                                        <label for="screenshot<?php echo e($i); ?>"><span class="label label-inverse"><?php echo e($i+1); ?></span> SCREENSHOT </label>
                                        <a target="_blank" href="<?php echo e(asset('upload/images/jobs/'.$screenshot)); ?>"><img src="<?php echo e(asset('upload/images/jobs/'.$screenshot)); ?>" style="width:100%"></a>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select required onchange="rejectReason(this.value)" name="status" class="form-control">
                                        <option value="" >Select Status</option>
                                        <option value="pending" <?php if($applicant->status == 'pending'): ?> selected <?php endif; ?> >Pending</option>
                                        <option value="accepted" <?php if($applicant->status == 'accepted'): ?> selected <?php endif; ?>>Accepted</option>
                                        <option value="reject" <?php if($applicant->status == 'reject'): ?> selected <?php endif; ?>>Reject</option>
                                    </select>
                                </div>


                                <div class="form-group" id="rejectReason"><?php if($applicant->status == 'reject'): ?><div class="form-group"><label>Reject reason</label><textarea name="reject_reason" required class="form-control" placeholder="Write job reject reason"><?php echo $applicant->reject_reason; ?></textarea></div><?php endif; ?></div>

                                <button style="width: 100%;" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Applicant Update</span>
                                </button>
                                
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- Column -->
                     <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> 
                                    <img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($applicant->user && $applicant->user->photo) ? $applicant->user->photo : 'default.png'); ?>" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10"><?php echo e($applicant->user->name); ?></h4>
                                    <h6 class="card-subtitle"><?php echo e($applicant->user->user_dsc); ?></h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-12">

                                            <h6>Since <?php echo e(Carbon\Carbon::parse($applicant->user->created_at)->format('d M, Y')); ?></h6>
                                            <h6>Reviews(0) </h6>
                                            <?php if($applicant->user->verify): ?> <span class="label label-success"> Verified </span> <?php else: ?> <span class="label label-danger">Unverify</span> <?php endif; ?>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
         
        function rejectReason(status) {
            if(status == 'reject'){
                $('#rejectReason').html(`<div class="form-group"><label>Write reject issue</label><textarea name="reject_reason" class="form-control" required placeholder="Write job reject reason"><?php echo $applicant->reject_reason; ?></textarea></div>`);
            }else{
                 $('#rejectReason').html('');
            }

        }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/jobs/jobWorkDetails.blade.php ENDPATH**/ ?>