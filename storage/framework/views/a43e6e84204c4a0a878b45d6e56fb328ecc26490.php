
<?php $__env->startSection('title', 'Report list'); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
                <!-- Page wrapper  -->
        <!-- ============================================================== -->
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
                        <h4 class="text-themecolor">Report Reason List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Report </a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Report By</th>
                                                <th>Report For</th>
                                                <th>Reason</th>
                                                <th>Reason Details</th>
                                                
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting">
                                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($report->id); ?>">
                                                <td><?php echo e($index+1); ?></td>
                                                <td style="display: flex;">
                                                    <a href="<?php echo e(route('userProfile', $report->user->username)); ?>" class="author-img active">
                                                    <img width="80" src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($report->user->photo) ? $report->user->photo : 'defualt.png'); ?>">
                                                    </a>
                                                    <p style="padding-left: 5px;">
                                                    <?php echo e($report->user->name); ?><br/>
                                                    <?php echo e($report->user->mobile); ?><br/>
                                                    <?php echo e(\Carbon\Carbon::parse($report->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                                </td>
                                                <td>
                                                    <?php if($report->product): ?>
                                                    <a class="inbox-header-img" style="display: flex;" target="_blank" href="<?php echo e(route('post_details',$report->product->slug )); ?>">
                                                        <img width="80" src="<?php echo e(asset('upload/images/product/thumb/'.$report->product->feature_image)); ?>" alt="avatar">
                                                        <p style="padding-left: 5px;"><?php echo e($report->product->title); ?></p>
                                                    </a>
                                                    <?php endif; ?>
                                                    <?php if($report->seller): ?>
                                                   
                                                    <a style="display:flex;" href="<?php echo e(route('userProfile', $report->seller->username)); ?>" class="author-img active">
                                                    <img width="80" src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($report->seller->photo) ? $report->seller->photo : 'defualt.png'); ?>">

                                                     <p style="padding-left: 5px;">
                                                    <?php echo e($report->seller->name); ?><br/>
                                                    <?php echo e($report->seller->mobile); ?></p>
                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($report->reason); ?></td>
                                                <td><?php echo e($report->reason_details); ?></td>
                                                
                                                
                                               
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr><td colspan="7"><?php echo e($reports->appends(request()->query())->links()); ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- This is data table -->
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
            $('#myTable').DataTable({"ordering": false});
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/report/report-list.blade.php ENDPATH**/ ?>