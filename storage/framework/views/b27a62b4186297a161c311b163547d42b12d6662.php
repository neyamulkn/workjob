
<?php $__env->startSection('title', 'Role Permission'); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        .module{background: #f7f7f7; font-weight: bold;}
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
                        <h4 class="text-themecolor"><?php echo e((ucfirst($role->name))); ?> : Role Permission</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Role</a></li>
                                <li class="breadcrumb-item active">Permission</li>
                            </ol>
                            <a href="<?php echo e(route('role.list')); ?>" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-arrow-left"></i> Back Role List</a>
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
                                    <form action="<?php echo e(route('role.permission.store')); ?>"  method="post">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="role_id"  value="<?php echo e($role->id); ?>" />
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th style="width: 135px">Module Name</th>
                                                <th>Sub Module</th>
                                                <th>View <input type="checkbox" id ="is_view"></th>
                                                <th>Add <input type="checkbox" id ="is_add"></th>
                                                <th>Edit <input type="checkbox" id ="is_edit"></th>
                                                <th>Delete <input type="checkbox" id ="is_delete"></th>
                                            </tr>
                                        </thead> 
                                        <tbody id="RolePositionSorting">
                                    <?php if(count($modules)>0): ?>
                                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $permission = $module['role_permission']; ?>
                                            <tr class="module"> 
                                                <td style="width: 50px;"><?php echo e($index+1); ?></td>
                                                <td <?php if(count($module['sub_modules'])>0): ?> colspan="7" <?php else: ?> colspan="2" <?php endif; ?>>  
                                                    <?php echo e($module['module_name']); ?>  
                                                    
                                                    <?php if(count($module['sub_modules'])>0): ?> <i class="fa fa-arrow-down"> <?php endif; ?></td> 
                                                    <?php if(count($module['sub_modules'])<=0): ?>
                                                    <input type="hidden" name="modules[<?php echo e($module['id']); ?>]"  value="<?php echo e($module['id']); ?>" >
                                                    <input type="hidden" name="permission_id[<?php echo e($module['id']); ?>]"  value="<?php echo e((isset($permission['id'])) ? $permission['id'] : ''); ?>" >

                                                    <td><?php if($module['is_view_vissible']): ?>
                                                            <input type="checkbox"  value="1" class="is_view" name="is_view[<?php echo e($module['id']); ?>]" <?php if(isset($permission['is_view']) && $permission['is_view'] == 1): ?> checked <?php endif; ?>>
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($module['is_add_vissible']): ?>
                                                            <input type="checkbox" value="1" class="is_add" name="is_add[<?php echo e($module['id']); ?>]" <?php if(isset($permission['is_add']) && $permission['is_add'] == 1): ?> checked <?php endif; ?>> 
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($module['is_edit_vissible']): ?>
                                                            <input type="checkbox" value="1" class="is_edit" name="is_edit[<?php echo e($module['id']); ?>]" <?php if(isset($permission['is_edit']) && $permission['is_edit'] == 1): ?> checked <?php endif; ?>>
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($module['is_delete_vissible']): ?>
                                                            <input type="checkbox" value="1" class="is_delete" name="is_delete[<?php echo e($module['id']); ?>]" <?php if(isset($permission['is_delete']) && $permission['is_delete'] == 1): ?> checked <?php endif; ?>>
                                                            <?php endif; ?>
                                                        </td> 
                                                        <?php endif; ?>
                                            </tr>
                                            <?php if(count($module['sub_modules'])>0): ?>
                                                <?php $__currentLoopData = $module['sub_modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submoduleIndex => $submodule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $permission = $submodule['role_permission']; ?>
                                                    <tr> 
                                                        <td style="width: 45px;"><?php echo e($index+1); ?>. <?php echo e($submoduleIndex+1); ?></td>
                                                        <td style="padding-left: 140px" colspan="2"> 
                                                            <?php echo e($submodule['module_name']); ?> 
                                                            <input type="hidden" name="modules[<?php echo e($submodule['id']); ?>]"  value="<?php echo e($submodule['id']); ?>" >
                                                            <input type="hidden" name="permission_id[<?php echo e($submodule['id']); ?>]"  value="<?php echo e((isset($permission['id'])) ? $permission['id'] : ''); ?>" >
                                                        </td> 
                                                        <td><?php if($submodule['is_view_vissible']): ?>
                                                            <input type="checkbox" <?php if(isset($permission['is_view']) && $permission['is_view'] == 1): ?> checked <?php endif; ?> value="1" class="is_view" name="is_view[<?php echo e($submodule['id']); ?>]">
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($submodule['is_add_vissible']): ?>
                                                            <input type="checkbox" <?php if(isset($permission['is_add']) && $permission['is_add'] == 1): ?> checked <?php endif; ?> value="1" class="is_add" name="is_add[<?php echo e($submodule['id']); ?>]">
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($submodule['is_edit_vissible']): ?>
                                                            <input type="checkbox" <?php if(isset($permission['is_edit']) && $permission['is_edit'] == 1): ?> checked <?php endif; ?> value="1" class="is_edit" name="is_edit[<?php echo e($submodule['id']); ?>]">
                                                            <?php endif; ?>
                                                        </td> 
                                                        <td><?php if($submodule['is_delete_vissible']): ?>
                                                            <input type="checkbox" <?php if(isset($permission['is_delete']) && $permission['is_delete'] == 1): ?> checked <?php endif; ?> value="1" class="is_delete" name="is_delete[<?php echo e($submodule['id']); ?>]">
                                                            <?php endif; ?>
                                                        </td> 
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <div class="form-actions pull-right" style="float: right;">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Permission </button>

                                        <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                        <a href="<?php echo e(url()->previous()); ?>" class="btn waves-effect waves-light btn-secondary">Cancel</a>
                                    </div>
                                    </form>
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
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- This is data table -->
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

   <script>
       // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>

    <script type="text/javascript">
        //on click select all products
        $('#is_view').on('click', function() {
            if (this.checked == true){
                $(".is_view").prop("checked", true);
            }
            else{
                $(".is_view").prop('checked', false);
            }
        }); $('#is_add').on('click', function() {
            if (this.checked == true){
                $(".is_add").prop("checked", true);
            }
            else{
                $(".is_add").prop('checked', false);
            }
        }); $('#is_edit').on('click', function() {
            if (this.checked == true){
                $(".is_edit").prop("checked", true);
            }
            else{
                $(".is_edit").prop('checked', false);
            }
        }); $('#is_delete').on('click', function() {
            if (this.checked == true){
                $(".is_delete").prop("checked", true);
            }
            else{
                $(".is_delete").prop('checked', false);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/role/rolePermission.blade.php ENDPATH**/ ?>