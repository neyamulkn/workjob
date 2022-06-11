 
<?php $__env->startSection('title', 'Job lists' ); ?>
<?php $__env->startSection('css'); ?>
<style type="text/css">
.progress{background-color: #dddedf;}
.clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
.count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
.count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
.count_d span { text-align: center; font-size: 14px; font-weight: 800;}
.count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}

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
                    <div class="col-lg-12">
                        <?php if(Session::has('success')): ?>
                        <div class="alert alert-success">
                          <strong>Success! </strong> <?php echo e(Session::get('success')); ?>

                        </div>
                        <?php endif; ?>
                        <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger">
                          <strong>Error! </strong> <?php echo e(Session::get('error')); ?>

                        </div>
                        <?php endif; ?>
                        <form action="" method="get">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <input name="title" placeholder="Title" value="<?php echo e(Request::get('title')); ?>" type="text" class="form-control">
                                    </div>
                                    <div class="col-6 col-md-3" style="margin-bottom: 5px;">
                                        <select name="status" class="form-control">
                                            <option value="all" <?php echo e((Request::get('status') == "all") ? 'selected' : ''); ?>>All Status</option>
                                            <option value="pending" <?php echo e((Request::get('status') == 'pending') ? 'selected' : ''); ?> >Pending</option>
                                            <option value="active" <?php echo e((Request::get('status') == 'active') ? 'selected' : ''); ?>>Active</option>
                                            <option value="deactive" <?php echo e((Request::get('status') == 'deactive') ? 'selected' : ''); ?>>Deactive</option>
                                            <option value="reject" <?php echo e((Request::get('status') == 'reject') ? 'selected' : ''); ?>>Reject</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group" >
                                           <button type="submit" class="form-control btn btn-success">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                     <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                        
                                    <table id="config-table" class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Job Name</th>
                                                <th>Progress</th>
                                                <th>Cost</th>
                                                <th>Views</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <?php if(count($posts)>0): ?>
                                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($post->id); ?>">
                                                <td><?php echo e($index+1); ?></td>
                                                
                                                <td><a target="_blank" href="<?php echo e(route('job_details', $post->slug)); ?>"> <?php echo e($post->title); ?> </a></td>
                                                <td style="text-align:center;">
                                                    <a target="_blank"  href="<?php echo e(route('jobApplicants', $post->slug)); ?>"><i class="ti-eye"></i> 
                                                    <span> <?php echo e($post->job_tasks_count); ?> OF <?php echo e($post->job_workers_need); ?> </span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: <?php echo e(\App\Http\Controllers\HelperController::workerProgress($post->job_tasks_count, $post->job_workers_need)); ?>%; height:6px;" role="progressbar"> </div>
                                                    </div></a>
                                                </td>
                                                <td><?php echo e($post->job_workers_need * $post->per_workers_earn); ?></td>
                                                <td><p style="font-size:12px" class="fa fa-eye">  <?php echo e($post->views); ?> </p></td>
                                                <td><?php echo e(Carbon\Carbon::parse($post->created_at)->format(Config::get('siteSetting.date_format'))); ?></td>
                                                <td>
                                                    <?php if($post->status != 'pending'): ?>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('posts', <?php echo e($post->id); ?>)"  type="checkbox" <?php echo e(($post->status == 'active') ? 'checked' : ''); ?>  type="checkbox" class="custom-control-input" id="status<?php echo e($post->id); ?>">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status<?php echo e($post->id); ?>"></label>
                                                    </div>
                                                    <?php else: ?>
                                                        <span class="label label-warning"> Pending </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                   
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a target="_blank" class="dropdown-item text-inverse" title="View Applicants" href="<?php echo e(route('jobApplicants', $post->slug)); ?>"><i class="ti-eye"></i> Applicants </a>

                                                            <a target="_blank" class="dropdown-item text-inverse" title="View " href="<?php echo e(route('job_details', $post->slug)); ?>"><i class="ti-eye"></i> View job</a>
                                                            <a class="dropdown-item" title="Edit product" href="<?php echo e(route('post.edit', $post->slug)); ?>"><i class="ti-pencil-alt"></i> Edit job</a>
                                                            <span title="Delete"><button   data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("post.delete", $post->id)); ?>")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete job</button></span>
                                                        </div>
                                                    </div>                                     
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <tr style="text-align: center;"><td colspan="8">post not found.!</td></tr>
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
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Job Delete</h4>
                    <button class="fas fa-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('post.delete')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" id="product_id">
                         
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="reason">Delete Reason</label>
                                    <select required name="reason" class="form-control">
                                        <option value="">Select reason</option>
                                    <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($reason->reason); ?>"><?php echo e($reason->reason); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="reason_details">Please describe delete reason.</label>
                                    <textarea class="form-control" required minlength="6" rows="2" id="reason_details" placeholder="Write reason details" name="reason_details"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger"> Delete Now</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    function deleteModal(product_id){
        $('#deleteModal').modal('show');
        $('#product_id').val(product_id);
    }
    document.addEventListener('readystatechange', event => {
        if (event.target.readyState === "complete") {
            var clockdiv = document.getElementsByClassName("clockdiv");
          var countDownDate = new Array();
            for (var i = 0; i < clockdiv.length; i++) {
                countDownDate[i] = new Array();
                countDownDate[i]['el'] = clockdiv[i];
                countDownDate[i]['time'] = new Date(clockdiv[i].getAttribute('data-date')).getTime();
                countDownDate[i]['days'] = 0;
                countDownDate[i]['hours'] = 0;
                countDownDate[i]['seconds'] = 0;
                countDownDate[i]['minutes'] = 0;
            }
          
            var countdownfunction = setInterval(function() {
                for (var i = 0; i < countDownDate.length; i++) {
                    var now = new Date().getTime();
                    var distance = countDownDate[i]['time'] - now;
                    countDownDate[i]['days'] = Math.floor(distance / (1000 * 60 * 60 * 24));
                    countDownDate[i]['hours'] = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    countDownDate[i]['minutes'] = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    countDownDate[i]['seconds'] = Math.floor((distance % (1000 * 60)) / 1000);

                    if (distance < 0) {
                        countDownDate[i]['el'].querySelector('.days').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = 0;
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = 0;
                    }else{
                        countDownDate[i]['el'].querySelector('.days').innerHTML = countDownDate[i]['days'];
                        countDownDate[i]['el'].querySelector('.hours').innerHTML = countDownDate[i]['hours'];
                        countDownDate[i]['el'].querySelector('.minutes').innerHTML = countDownDate[i]['minutes'];
                        countDownDate[i]['el'].querySelector('.seconds').innerHTML = countDownDate[i]['seconds'];
                    } 
                }
            }, 1000);
        }
    });
</script>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/post/index.blade.php ENDPATH**/ ?>