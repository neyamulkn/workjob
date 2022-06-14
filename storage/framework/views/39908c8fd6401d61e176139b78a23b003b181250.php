
<?php $__env->startSection('title', 'Messages'); ?>

<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- page css -->
    <link href="<?php echo e(asset('css')); ?>/pages/inbox.css" rel="stylesheet">
  
    <style type="text/css">
    tbody p{padding: 0;margin: 0}
    tbody a{color: #000;}
    .userList{white-space: nowrap; 
  width: 100px; 
  overflow: hidden;
  text-overflow: ellipsis; 
  }
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
                        <h4 class="text-themecolor">Message list</h4>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xlg-2 col-lg-3 col-md-4">
                                    <?php echo $__env->make('admin.message.leftsidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left sticky-conent">
                                    
                                    <div class="card-body p-t-0">
                                        <div class="card b-all shadow-none">
                                            <div class="table-responsive" style="padding-top:0">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px;">#</th>
                                                            
                                                            <th style="max-width: 150px;">Subject</th>
                                                            <th>Description</th>
                                                            <th style="width: 90px;">Date</th>
                                                            <th style="width: 50px;">Action</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr id="item<?php echo e($message->id); ?>">
                                                            <td><?php echo e($index+1); ?></td>
                                                           
                                                            <td> <?php echo e(Str::limit($message->subject, '50')); ?></td>
                                                            <td><?php echo Str::limit(strip_tags($message->details), 60); ?> </td>
                                                          
                                                            <td><p><?php echo e(Carbon\Carbon::parse($message->start_date)->format('d M, y')); ?></p><p> <?php echo e(Carbon\Carbon::parse($message->start_date)->format('h:i A')); ?></p></td>
                                                            <?php if($permission['is_edit']): ?>
                                                            <td><a title="Edit" href="<?php echo e(route('adminMessage.edit', $message->slug)); ?> "> <i class="fa fa-reply"></i> </a><?php endif; ?>
                                                            <?php if($permission['is_delete']): ?>
                                                            <a style="color:red" title="Delete" data-target="#delete" onclick="deleteConfirmPopup('<?php echo e(route("adminMessage.delete", $message->id)); ?>')" data-toggle="modal" href="javascript:void(0)"> <i class="ti-trash"></i> </a><?php endif; ?> </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                                       <?php echo e($messages->appends(request()->query())->links()); ?>

                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($messages->firstItem()); ?> to <?php echo e($messages->lastItem()); ?> of total <?php echo e($messages->total()); ?> entries (<?php echo e($messages->lastPage()); ?> Pages)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
   	<!-- delete Modal -->
   
    <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/message/message.blade.php ENDPATH**/ ?>