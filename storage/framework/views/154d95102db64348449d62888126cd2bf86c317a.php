
<?php $__env->startSection('title', 'Top 10 Job Poster'); ?>

<?php $__env->startSection('content'); ?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="text-align:center;">
                
               
                <div class="row offset-md-2">

                    <!-- Column -->
                    <div class="col-md-10">
                        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" style="padding:8px 0;font-size: 15px;background: #226c04;color: #fff;"><?php echo $ticket->details; ?></marquee>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Top 10 Job Poster</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Post</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($index+1); ?></td>
                                                <td><?php echo e($user->name); ?></td>
                                                <td><?php echo e($user->jobs_count); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                </div> 
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/jobs/topJobPoster.blade.php ENDPATH**/ ?>