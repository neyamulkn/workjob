
<?php $__env->startSection('title', 'Page list'); ?>
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
                        <h4 class="text-themecolor">Page List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Page</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <?php if($permission['is_add']): ?>
                            <a href="<?php echo e(route('page.create')); ?>" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New Page</a><?php endif; ?>
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
                                                <th>Page Title</th>
                                                <th>Page Link</th>
                                                <th>Is Default</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="pages">
                                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($data->id); ?>">
                                                <td><?php echo e($data->title); ?></td>

                                                <td>
                                                    <a href="<?php echo e(url(($data->slug == 'homepage') ? '/' :  $data->slug)); ?>" target="_blank">Copy Link <i class="fas fa-external-link-alt"></i> </a>
                                                   </td>
                                               
                                                <td><?php if($data->is_default ==1): ?><span class="label label-warning">Default</span><?php else: ?><span class="label label-info">Custom</span><?php endif; ?></td>
                                                <td>
                                                    <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                                                      <input name="status"  <?php if($permission['is_edit']): ?> onclick="satusActiveDeactive('pages', <?php echo e($data->id); ?>)" <?php endif; ?> type="checkbox" <?php echo e(($data->status == 1) ? 'checked' : ''); ?> class="custom-control-input" id="status<?php echo e($data->id); ?>">
                                                      <label class="custom-control-label" for="status<?php echo e($data->id); ?>"></label>
                                                    </div>
                                                </td>
                                                 
                                                <td>
                                                    <?php if($permission['is_edit']): ?>
                                                    <a href="<?php echo e(route('page.edit', $data->slug)); ?>"  class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</a>
                                                    <?php endif; ?>
                                                    <?php if($permission['is_add']): ?>
                                                    <?php if($data->slug == 'faq'): ?>
                                                    <a href="<?php echo e(route('faq.list')); ?>"  class="btn btn-success btn-sm"><i class="ti-plus" aria-hidden="true"></i> Add FAQ</a>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if($permission['is_delete']): ?>
                                                    <?php if($data->is_default !=1): ?>
                                                    <button data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("page.delete", $data->id)); ?>")' class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
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

       <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
   <script src="<?php echo e(asset('assets')); ?>/node_modules/jqueryui/jquery-ui.min.js"></script>
    <!-- This is data table -->
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
   <script>
        $(function () {
           $('#myTable').dataTable({
                "ordering": false
            });
        });
        
        function copyURI(evt) {
            evt.preventDefault();
            navigator.clipboard.writeText(evt.target.getAttribute('href')).then(() => {
             alert('link copy success');
            }, () => {
              /* clipboard write failed */
            });
        }

        </script>

    <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            var  url = '<?php echo e(route("statusChange")); ?>';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>  
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/pages/page-lists.blade.php ENDPATH**/ ?>