
<?php $__env->startSection('title', 'User list'); ?>
<?php $__env->startSection('css'); ?>

    <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css')); ?>/pages/bootstrap-switch.css" rel="stylesheet">

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
                    <h4 class="text-themecolor">User List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
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
                <div class="col-lg-12">
                    <div class="card" style="margin-bottom: 2px;">

                        <form action="<?php echo e(route('customer.list')); ?>" method="get">

                            <div class="form-body">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="<?php echo e(Request::get('name')); ?>" placeholder="Customer name or mobile or email" name="name" class="form-control">
                                           </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="location" required id="location" style="width:100%" id="location"  class="select2 form-control custom-select">
                                                   <option value="all">All Location</option>
                                                   <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                   <option <?php if(Request::get('location') == $location->id): ?> selected <?php endif; ?> value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                               </select>
                                           </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                
                                                <select name="status" class="form-control">
                                                    <option value="all" <?php echo e((Request::get('status') == "all") ? 'selected' : ''); ?>>All Status</option>
                                                    <option value="pending" <?php echo e((Request::get('status') == 'pending') ? 'selected' : ''); ?> >Pending</option>
                                                    <option value="active" <?php echo e((Request::get('status') == 'active') ? 'selected' : ''); ?>>Active</option>
                                                    <option value="deactive" <?php echo e((Request::get('status') == 'deactive') ? 'selected' : ''); ?>>Deactive</option>
                                                    <option value="band" <?php echo e((Request::get('status') == 'band') ? 'selected' : ''); ?>>Band</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                               
                                               <button type="submit" class="form-control btn btn-success"><i style="color:#fff; font-size: 20px;" class="ti-search"></i> </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                                            <th>Mobile</th>
                                            <th>Email</th>
                                             <th>Posts</th>
                                            <th>Verify</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr id="item<?php echo e($customer->id); ?>">
                                            <td><?php echo e((($customers->perPage() * $customers->currentPage() - $customers->perPage()) + ($index+1) )); ?></td>
                                            <td><img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(( $customer->photo) ? $customer->photo : 'default.png'); ?>" width="40"> <?php echo e($customer->name); ?>

                                            <p><?php echo e(\Carbon\Carbon::parse($customer->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                            </td>
                                            <td><?php echo e($customer->mobile); ?></td>
                                            <td><?php echo e($customer->email); ?></td> 
                                            <td><a href="<?php echo e(route('customer.profile', $customer->username)); ?>" class="label label-info"><?php echo e($customer->posts_count); ?></a></td>
                                            
                                            <td <?php if($permission['is_edit']): ?> onclick="customerStatus(<?php echo e($customer->id); ?>, 'verify')" <?php endif; ?> > <?php if($customer->verify): ?> <span class="label label-success"> Verified </span> <?php else: ?> <span class="label label-danger">Unverify</span> <?php endif; ?></td>
                                            <td>
                                                <span style="cursor:pointer;" class="label <?php if($customer->status == 'active'): ?> label-success <?php elseif($customer->status == 'band'): ?> label-danger <?php elseif($customer->status == 'deactive'): ?> label-warning <?php else: ?> label-info <?php endif; ?>" title="customer Status (pending, active, deactive)" 
                                               <?php if($permission['is_edit']): ?> onclick="customerStatus(<?php echo e($customer->id); ?>)" <?php endif; ?> > <?php echo e($customer->status); ?></span>
                                            </td>
                                          
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       
                                                        <a class="dropdown-item" title="View Customer Profile" data-toggle="tooltip" href="<?php echo e(route('customer.profile', $customer->username)); ?>"><i class="ti-eye"></i> View Profile</a>
                                                        <?php if($permission['is_edit']): ?>
                                                        <a class="dropdown-item" target="_blank" title="Secret login in the customer pannel" data-toggle="tooltip" href="<?php echo e(route('admin.customerSecretLogin', encrypt($customer->id))); ?>"><i class="ti-lock"></i> Customer panel</a>
                                                        <?php endif; ?>
                                                       <!--  <a class="dropdown-item" title="Edit profile" data-toggle="tooltip" href="<?php echo e(route('customer.edit', $customer->id)); ?>"><i class="ti-pencil-alt"></i> Edit</a>
                                                        -->

                                                        <?php if($permission['is_delete']): ?>
                                                        <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("customer.delete", $customer->id)); ?>")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete Customer</button></span>
                                                        <?php endif; ?>
                                                        <?php if($permission['is_edit']): ?>
                                                        <button title="Password Reset" data-toggle="tooltip" onclick='PasswordReset("<?php echo e($customer->id); ?>")' class="dropdown-item" ><i class="fa fa-retweet"></i> Password Reset</button><?php endif; ?>
                                                        
                                                    </div>
                                                </div>                                          
                                            </td>
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
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- update Modal -->
    <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="<?php echo e(route('customer.store')); ?>" enctype="multipart/form-data" method="POST" class="floating-labels">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Customer Name</label>
                                            <input  name="name" id="name" value="<?php echo e(old('name')); ?>" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="photo" id="input-file-events">
                                        </div>
                                        <?php if($errors->has('phato')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?php echo e($errors->first('phato')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="notes">Details</label>
                                            <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="2"><?php echo e(old('notes')); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" <?php echo e((old('status') == 'on') ? 'checked' : ''); ?> id="status">
                                                    <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="<?php echo e(route('customer.update')); ?>" enctype="multipart/form-data" method="post">
            <?php echo e(csrf_field()); ?>

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update customer</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
    </div>

    <!-- reset password Modal -->
    <div class="modal fade" id="PasswordReset" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="<?php echo e(route('admin.resetPassword')); ?>" enctype="multipart/form-data" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" id="userId" name="id">
            <input type="hidden" name="table" value="users">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Password Reset</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="col-md-12">
                        <label for="password"><span style="font-weight: bold">Enter new password</span></label>
                        <input type="text" required id="password" name="password" placeholder="Enter password" class="form-control">
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Password Reset</button>
                </div>
              </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="customerStatus_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Customer Status</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                                <form action="<?php echo e(route('customerStatusUpdate')); ?>" method="POST">
                                <?php echo e(csrf_field()); ?>

                               <div id="highlight_form"></div>
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
    <!-- delete Modal -->
    <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>



    <script type="text/javascript">
    
    function customerStatus(id, verify=null){
        $('#highlight_form').html('<div class="loadingData"></div>');
        $('#customerStatus_modal').modal('show');
        var  url = '<?php echo e(route("customerStatus", ":id")); ?>';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            data:{verify:verify},
            success:function(data){
                if(data){
                    $("#highlight_form").html(data);
                }
            },
            // $ID = Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'highlight_form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

    function PasswordReset(userId) {
       $('#PasswordReset').modal('show');
       $('#userId').val(userId);
    }

</script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/customer/customer.blade.php ENDPATH**/ ?>