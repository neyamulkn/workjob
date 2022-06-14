
<?php $__env->startSection('title', 'Post lists'); ?>
<?php $__env->startSection('css-top'); ?>
    <link href="<?php echo e(asset('assets')); ?>/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
    svg{width: 20px}
    .clockdiv{ display: inline-flex; margin: 0 auto; text-align: center; align-items: center;}
    .count_d {position: relative;width: 28px;padding: 0;overflow: hidden;color: #46b700;}
    .count_d:before{ content: '';  position: absolute;top: 0;left: 0;width: 100%;height: 50%;}
    .count_d span { text-align: center; font-size: 14px; font-weight: 800;}
    .count_d h2 { display: block; text-align: center; font-size: 8px; font-weight: 800; margin: 0;}

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
                        <h4 class="text-themecolor">Total Posts (<?php echo e($all_products); ?>)</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Post</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <!-- <a class="btn btn-info d-none d-lg-block m-l-15" href="<?php echo e(route('admin.product.upload')); ?>"><i class="fa fa-plus-circle"></i> Add New Ads</a> -->
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                
                <div class="row">
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-bolt"></i></span>
                                <a href="<?php echo e(route('admin.product.list', 'pending')); ?>" class="link display-5 ml-auto"><?php echo e($pending_products); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active </h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-thumbs-up"></i></span>
                                <a href="<?php echo e(route('admin.product.list', 'active')); ?>" class="link display-5 ml-auto"><?php echo e($active_products); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deactive </h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-thumbs-down"></i></span>
                                <a href="<?php echo e(route('admin.product.list', 'deactive')); ?>" class="link display-5 ml-auto"><?php echo e($deactive_products); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                
                   
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Rejected</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-file-image"></i></span>
                                <a href="<?php echo e(route('admin.product.list', 'reject')); ?>" class="link display-5 ml-auto"><?php echo e($rejected); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="title" placeholder="Title" value="<?php echo e(Request::get('title')); ?>" type="text" class="form-control">
                                                </div>
                                            </div>
                                           
                                           

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <select name="seller" required id="seller" style="width:100%" id="seller"  class="select2 form-control custom-select">
                                                       <option value="all">All Seller</option>
                                                       <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                       <option <?php if(Request::get('seller') == $seller->id): ?> selected <?php endif; ?> value="<?php echo e($seller->id); ?>"><?php echo e($seller->name); ?></option>
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
                                                        <option value="reject" <?php echo e((Request::get('status') == 'reject') ? 'selected' : ''); ?>>Reject</option>
                                                        
                                                        
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

                <!-- Start Page Content -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
 
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table  class="table table-striped" >
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
                                            <?php if(count($products)>0): ?>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($product->id); ?>">
                                                <td><?php echo e($index+1); ?></td>
                                                
                                                <td><a target="_blank" href="<?php echo e(route('job_details', $product->slug)); ?>"> <?php echo e($product->title); ?> </a></td>
                                                <td style="text-align:center;">
                                                    <a target="_blank"  href="<?php echo e(route('jobApplicants', $product->slug)); ?>"><i class="ti-eye"></i> 
                                                    <span> <?php echo e($product->job_tasks_count); ?> OF <?php echo e($product->job_workers_need); ?> </span>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: <?php echo e(\App\Http\Controllers\HelperController::workerProgress($product->job_tasks_count, $product->job_workers_need)); ?>%; height:6px;" role="progressbar"> </div>
                                                    </div></a>
                                                </td>
                                                <td><?php echo e($product->job_workers_need * $product->per_workers_earn); ?></td>
                                                <td><p style="font-size:12px" class="fa fa-eye">  <?php echo e($product->views); ?> </p></td>
                                                <td><?php echo e(Carbon\Carbon::parse($product->created_at)->format(Config::get('siteSetting.date_format'))); ?></td>
                                               
                                                    <?php if(Request::route('status') == 'trash'): ?>
                                                    <td><?php echo $product->delete_reason; ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        

                                                        <span style="cursor:pointer;" class="label <?php if($product->status == 'active'): ?> label-success <?php elseif($product->status == 'deactive'): ?> label-warning <?php elseif($product->status == 'reject'): ?> label-danger <?php else: ?> label-info <?php endif; ?>" title="Product Status (pending, active, reject)" 
                                                        onclick="productStatus(<?php echo e($product->id); ?>)" > <?php echo e($product->status); ?></span>
                                                    </td>
                                                    
                                                    <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a target="_blank" class="dropdown-item text-inverse" title="View product" href="<?php echo e(route('job_details', $product->slug)); ?>"><i class="ti-eye"></i> View post</a>
                                                            <?php if($permission['is_edit']): ?>
                                                            <a class="dropdown-item" title="Edit product" href="<?php echo e(route('admin.product.edit', $product->slug)); ?>"><i class="ti-pencil-alt"></i> Edit post</a><?php endif; ?>
                                                            <a target="_blank" class="dropdown-item text-inverse" title="View Applicants" href="<?php echo e(route('jobAllApplicants', $product->slug)); ?>"><i class="ti-eye"></i> Applicants </a>
                                                            <?php if(Request::route('status') == 'trash'): ?>
                                                            <a onclick="restoreDeletedData('Product', <?php echo e($product->id); ?>)"  class="dropdown-item" href="javascript:void(0)"><i class="fa fa-undo"></i> Restore post</a>
                                                            <?php endif; ?>
                                                            <?php if($permission['is_delete']): ?>
                                                            <span title="Delete"><button   data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("admin.product.delete", $product->id)); ?>")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete post</button></span><?php endif; ?>
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
                    <!-- Column -->
                </div>
                <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       <?php echo e($products->appends(request()->query())->links()); ?>

                      </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($products->firstItem()); ?> to <?php echo e($products->lastItem()); ?> of total <?php echo e($products->total()); ?> entries (<?php echo e($products->lastPage()); ?> Pages)</div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- Gallery Modal -->
        <div class="modal fade" id="GallerryImage" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Gallery Image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="<?php echo e(route('product.storeGalleryImage')); ?>" enctype="multipart/form-data" method="POST" class="floating-labels">
                                <?php echo e(csrf_field()); ?>

                               
                                <div class="form-body">
                                   
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Select Multiple Image</label>
                                                <input  type="file" multiple class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="gallery_image[]" id="input-file-events">
                                            </div>
                                            <?php if($errors->has('gallery_image')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <?php echo e($errors->first('gallery_image')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-12" id="showGallerryImage"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Upload</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        <!-- HightLight Modal -->
        <!-- Gallery Modal -->
        <div class="modal fade" id="productStatus_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Product Status</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                                <form action="<?php echo e(route('productStatusUpdate')); ?>" method="POST">
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
        <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(".select2").select2();

    function setGallerryImage(id) {
       
        $('#showGallerryImage').html('<div class="loadingData"></div>');
        var  url = '<?php echo e(route("product.getGalleryImage", ":id")); ?>';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#showGallerryImage").html(data);
                }
            },
            // $ID = Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'showGallerryImage'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        });
    }


    function deleteGallerryImage(id) {
       
        if (confirm("Are you sure delete this image.?")) {
           
            var url = '<?php echo e(route("product.deleteGalleryImage", ":id")); ?>';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $('#gelImage'+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }
        return false;
    }    


    function restoreDeletedData(model, id) {
       
        if (confirm("Are you sure restore this post.?")) {
           
            var url = '<?php echo e(route("restoreDeletedData")); ?>';
            $.ajax({
                url:url,
                method:"get",
                data:{model:model,id:id},
                success:function(data){
                    if(data){
                        $('#item'+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }
        return false;
    }


    function productStatus(id){
        $('#highlight_form').html('<div class="loadingData"></div>');
        $('#productStatus_modal').modal('show');
        var  url = '<?php echo e(route("productStatus", ":id")); ?>';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#highlight_form").html(data);
                }
            },
            // $ID = Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'highlight_form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        });
    }

    </script>
 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/product/product-lists.blade.php ENDPATH**/ ?>