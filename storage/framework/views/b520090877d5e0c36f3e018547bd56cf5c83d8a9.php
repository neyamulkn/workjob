 
<?php $__env->startSection('title', $post->title); ?>
<?php $__env->startSection('css'); ?>
<style type="text/css">
.progress{background-color: #dddedf;}
.clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { text-align: center; font-size: 14px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}
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
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><?php echo e($post->title); ?></h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Applicants</a></li>
                                <li class="breadcrumb-item active">lists</li>
                            </ol>
                            <a href="<?php echo e(route('admin.product.list')); ?>" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Job list</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                     <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                        
                        <table id="config-table" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Earn</th>
                                    <th>Submit Date</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead> 
                            <tbody>
                                <?php if(count($jobApplicants)>0): ?>
                                <?php $__currentLoopData = $jobApplicants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $applicant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="item<?php echo e($post->id); ?>">
                                    <td><?php echo e($index+1); ?></td>
                                    
                                    <td><a target="_blank" href="<?php echo e(route('jobApplicantDetails',[$applicant->id, $applicant->user->username])); ?>"> <?php echo e($applicant->user->name); ?> </a></td>
                                    <td><?php echo e(Config::get('siteSetting.currency_symble').$applicant->amount); ?></td>
                                    
                                    <td><?php echo e(Carbon\Carbon::parse($applicant->created_at)->format(Config::get('siteSetting.date_format'))); ?></td>
                                    <td>
                                        <span style="cursor:pointer;" class="label <?php if($applicant->status == 'accepted'): ?> label-success <?php elseif($applicant->status == 'reject'): ?> label-danger <?php else: ?> label-info <?php endif; ?>" title="Applicant Status (pending, active, reject)" 
                                         > <?php echo e($applicant->status); ?></span>
                                    </td>
                                   
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr style="text-align: center;"><td colspan="8">Applicant not found.!</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/jobs/job-applicants.blade.php ENDPATH**/ ?>