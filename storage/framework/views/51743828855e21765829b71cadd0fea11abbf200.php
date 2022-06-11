
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
                    	<div class="row">
		                    <div class="col-6">
		                        <div class="card">
		                            <div class="card-body">
		                                <h4 class="card-title">Worker Done</h4>
		                                <div style="display: flex;justify-content: space-between;">
		                                	<div>
                                                
		                                		<span class="text-success"> <?php echo e($post->job_tasks_count); ?> OF <?php echo e($post->job_workers_need); ?></span>
				                                <div class="progress" style="width:200px">
				                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e(\App\Http\Controllers\HelperController::workerProgress($post->job_tasks_count, $post->job_workers_need)); ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				                                </div>
		                                	</div>
			                                <div class="text-right"> 
			                                    <h1 class="font-light"><sup><i class="ti-check-box text-primary"></i></sup> </h1>
			                                </div>
		                            	</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-6">
		                        <div class="card">
		                            <div class="card-body">
		                                <h4 class="card-title">YOU CAN EARN</h4>
		                                <div class="text-right"> 
		                                    <h1 class="font-light"> <?php echo e(Config::get('siteSetting.currency_symble') . $post->per_workers_earn); ?></h1>
		                                </div>
		                                
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <form <?php if(!$post->userJobTask): ?> action="<?php echo e(route('jobWork.store', $post->slug)); ?>" method="post" data-parsley-validate enctype="multipart/form-data" <?php endif; ?>> 
                        <?php echo csrf_field(); ?>
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item" style="padding:10px"><h3><?php echo e($post->title); ?> </h3></li>
                            </ul>
                            
                            <div class="card-body">
                            	<img src="<?php echo e(asset('upload/images/post/'.$post->thumb_image)); ?>">
                        		<div class="row" style="margin:20px -10px;">
					                <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"> <i class="fas fa-tags"></i><?php if($post->get_category): ?> <?php echo e($post->get_category->name); ?> <?php endif; ?> <?php if($post->get_category): ?> - <?php echo e($post->get_subcategory->name); ?> <?php endif; ?></span></h5></b>
						            </div>

						             <div class="col-sm-6"> <b> <h5>
						                <span style="padding: 5px" class="card-text text-muted">
						                    <i class="fas fa-globe"></i> <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  <?php echo e($location->name); ?>,  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></span></h5></b>
						            </div>
						            
						            <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"> <i class="fa fa-hourglass-half "></i> Time <?php echo e($post->estimated_time); ?></span></h5></b>
						            </div>

						            <div class="col-sm-6"><b> <h5>
						                <span style="padding: 5px" class="card-text text-muted"><i class="fa fa-clock"></i> Last Updated- <?php echo e(Carbon\Carbon::parse($post->updated_at)->format('d M, Y H:i:s')); ?></span></h5></b>
						            </div>
						        </div>
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
                            	<h4><i class="fa fa-pencil-alt"></i> SUBMIT REQUIRED WORK PROVE?</h4>
                              	<div class="details">
                                    <textarea required type="text" name="work_prove" rows="3" class="form-control" placeholder="Write description" id="completed"><?php if($post->userJobTask): ?><?php echo e($post->userJobTask->work_prove); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body row work_screenshot">
                                <?php if($post->userJobTask && $post->userJobTask->screenshots): ?>
                                    <?php $__currentLoopData = json_decode($post->userJobTask->screenshots); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $screenshot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="screenshot<?php echo e($i+1); ?>"><span class="label label-inverse"><?php echo e($i+1); ?></span> UPLOAD SCREENSHOT PROVE </label>
                                            <input required type="file" id="screenshot<?php echo e($i+1); ?>" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" data-default-file="<?php echo e(asset('upload/images/jobs/'.$screenshot)); ?>" accept="image/*" name="screenshot[]">
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php for($i=1; $i<=$post->work_screenshots; $i++): ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="screenshot<?php echo e($i); ?>"><span class="label label-inverse"><?php echo e($i); ?></span> UPLOAD SCREENSHOT PROVE </label>
                                            <input required type="file" id="screenshot<?php echo e($i); ?>" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" accept="image/*" name="screenshot[]">
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            	
                            </div>

                            <div class="card-body text-right">
                                <?php if($post->userJobTask): ?>
                                <h3 style="text-align:center;color: red;">Job Already Submited.</h3>
                                <?php else: ?>
                                <button style="width: 100%;" class="btn btn-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Submit Job</span>
                                </button>
                                <?php endif; ?>
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
                                	<img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($post->user && $post->user->photo) ? $post->user->photo : 'default.png'); ?>" class="img-circle" width="150" />
                                    <h4 class="card-title m-t-10"><?php echo e($post->user->name); ?></h4>
                                    <h6 class="card-subtitle"><?php echo e($post->user->user_dsc); ?></h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-12">

                                        	<h6>Since <?php echo e(Carbon\Carbon::parse($post->user->created_at)->format('d M, Y')); ?></h6>
                                        	<h6>Reviews(0) </h6>
                                       		<?php if($post->user->verify): ?> <span class="label label-success"> Verified </span> <?php else: ?> <span class="label label-danger">Unverify</span> <?php endif; ?>
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
    <script src="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/jobs/job-details.blade.php ENDPATH**/ ?>