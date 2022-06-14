
<?php $__env->startSection('title', 'Verify request list'); ?>
<?php $__env->startSection('css'); ?>

    <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
  
    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
    </style>
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
                    <h4 class="text-themecolor">Verify request List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Verify request</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <!-- <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button> -->
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

                    <div class="card ">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Mobile & Email</th>
                                           
                                            <th>Posts</th>
                                            
                                            <th style="width: 100px;">Card Info</th>
                                          
                                            <th>Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr id="item<?php echo e($customer->id); ?>">
                                            <td><?php echo e((($customers->perPage() * $customers->currentPage() - $customers->perPage()) + ($index+1) )); ?></td>
                                            <td>
                                                <a style="display:flex;" class="dropdown-item" title="View Profile" href="<?php echo e(route('customer.profile', $customer->username)); ?>"><img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(( $customer->photo) ? $customer->photo : 'default.png'); ?>" width="60"> 

                                                <p style="padding-left: 3px"><?php echo e($customer->shop_name); ?><br>
                                                <?php echo e($customer->name); ?></p>
                                                </a>
                                            </td>
                                            <td><?php echo e($customer->mobile); ?> <br/> <?php echo e($customer->email); ?></td> 
                                            <td><a href="<?php echo e(route('customer.profile', $customer->username)); ?>" class="label label-info"><?php echo e($customer->posts_count); ?></a></td>
                                            <td>
                                                <p>Card Type: <?php echo e($customer->cardType); ?></p>
                                                <a class="popup-gallery" href="<?php echo e(asset('upload/users/'.$customer->nid_front)); ?>"><img width="50" src="<?php echo e(asset('upload/users/'.$customer->nid_front)); ?>"></a>
                                                <a class="popup-gallery" href="<?php echo e(asset('upload/users/'.$customer->nid_back)); ?>"><img width="50" src="<?php echo e(asset('upload/users/'.$customer->nid_back)); ?>"></a>
                                            </td>
                                            
                                            <td><?php echo e($customer->address); ?></td>
                                            <td onclick="customerStatus(<?php echo e($customer->id); ?>, 'verify')"> <?php if($customer->verify): ?> <span class="label label-success"> Verified </span> <?php else: ?> <span class="label label-danger">Unverify</span> <?php endif; ?></td>
                                           
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   <?php echo e($customers->appends(request()->query())->links()); ?>

                  </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($customers->firstItem()); ?> to <?php echo e($customers->lastItem()); ?> of total <?php echo e($customers->total()); ?> entries (<?php echo e($customers->lastPage()); ?> Pages)</div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
 
    <div class="modal fade" id="customerStatus_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Verify Status</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                                <form action="<?php echo e(route('customerStatusUpdate')); ?>" method="POST">
                                <?php echo e(csrf_field()); ?>

                               <div id="verify_form"></div>
                               <div class="modal-footer">
                                    <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Change Status</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-inverse">Close</button>
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script type="text/javascript">
    function customerStatus(id, verify){
        $('#verify_form').html('<div class="loadingData"></div>');
        $('#customerStatus_modal').modal('show');
        var  url = '<?php echo e(route("customerStatus", ":id")); ?>';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            data:{verify:verify},
            success:function(data){
                if(data){
                    $("#verify_form").html(data);
                }
            },
            // $ID = Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'verify_form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        });
    }
    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '<?php echo e(route("customer.edit", ":id")); ?>';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'edit_form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        });
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/customer/verifyRequest.blade.php ENDPATH**/ ?>