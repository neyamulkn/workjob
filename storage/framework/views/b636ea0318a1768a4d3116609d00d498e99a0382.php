
<?php $__env->startSection('title', 'Subcategory list'); ?>
<?php $__env->startSection('css-top'); ?>
    <link href="<?php echo e(asset('assets')); ?>/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
   
    <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 150px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered{height: 100px!important}
   
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
                        <h4 class="text-themecolor">Subcategory List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Subcategory</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <?php if($permission['is_add']): ?>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New Category</button><?php endif; ?>
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
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="category"  id="category" style="width:100%" id="seller" class="select2 form-control custom-select">
                                                       <option value="all">All Category</option>
                                                       <?php $__currentLoopData = $get_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                       <option <?php if(Request::get('category') == $category->id): ?> selected <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   </select>
                                               </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <select class="form-control" name="show">
                                                        <option <?php if(Request::get('show') == 15): ?> selected <?php endif; ?> value="15">15</option>
                                                        <option <?php if(Request::get('show') == 25): ?> selected <?php endif; ?> value="25">25</option>
                                                        <option <?php if(Request::get('show') == 50): ?> selected <?php endif; ?> value="50">50</option>
                                                        <option <?php if(Request::get('show') == 100): ?> selected <?php endif; ?> value="100">100</option>
                                                        <option <?php if(Request::get('show') == 255): ?> selected <?php endif; ?> value="250">250</option>
                                                        <option <?php if(Request::get('show') == 500): ?> selected <?php endif; ?> value="500">500</option>
                                                        <option <?php if(Request::get('show') == 750): ?> selected <?php endif; ?> value="750">750</option>
                                                        <option <?php if(Request::get('show') == 1000): ?> selected <?php endif; ?> value="1000">1000</option>
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
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <i class="drag-drop-info">Drag & drop sorting position</i>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Subcategory Name</th>
                                                <th>Category</th>
                                                <?php if($permission['is_edit']): ?>
                                                <th>Free Ads Limit</th><?php endif; ?>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categoryPositionSorting">
                                            <?php $__currentLoopData = $get_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($data->id); ?>">
                                                <td><?php echo e((($get_data->perPage() * $get_data->currentPage() - $get_data->perPage()) + ($index+1) )); ?></td>
                                                <td><img src="<?php echo e(asset('upload/images/category/thumb/'. $data->image)); ?>" width="50" alt=""></td>
                                                <td><?php echo e($data->name); ?></td>
                                                
                                                <td><?php echo e(($data->get_category->name ) ?? 'Not found'); ?></td>
                                                <?php if($permission['is_edit']): ?>
                                                <td><input style="width: 100px;" value="<?php echo e($data->free_ads_limit); ?>" onkeyup ="freeAdsLimit(<?php echo e($data->id); ?>, this.value )" type="number" class="form-control" name=""></td><?php endif; ?>
                                                <td><?php echo e($data->notes); ?></td>
                                                <td> 
                                                     <?php if($permission['is_edit']): ?>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('categories', <?php echo e($data->id); ?>)"  type="checkbox" <?php echo e(($data->status == 1) ? 'checked' : ''); ?>  type="checkbox" class="custom-control-input" id="status<?php echo e($data->id); ?>">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status<?php echo e($data->id); ?>"></label>
                                                    </div>
                                                    <?php else: ?>
                                                    <label><?php echo e(($data->status == 1) ? 'Active' : 'Deactive'); ?></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($permission['is_edit']): ?>
                                                    <button type="button" onclick="getCategoryBanner('<?php echo e($data->slug); ?>')"  data-toggle="modal" data-target="#setBanner" class="btn btn-success btn-sm"><i class="ti-plus" aria-hidden="true"></i> Banner</button>
                                                    <button type="button" onclick="edit('<?php echo e($data->id); ?>')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button><?php endif; ?>
                                                    <?php if($permission['is_delete']): ?>
                                                    <button data-target="#delete" onclick="deleteConfirmPopup('<?php echo e(route("subcategory.delete", $data->id)); ?>')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> Delete</button><?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                       <?php echo e($get_data->appends(request()->query())->links()); ?>

                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($get_data->firstItem()); ?> to <?php echo e($get_data->lastItem()); ?> of total <?php echo e($get_data->total()); ?> entries (<?php echo e($get_data->lastPage()); ?> Pages)</div>
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
        <!-- update Modal -->
        <div class="modal fade" id="add" role="dialog" style="display: none;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create subcategory</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="<?php echo e(route('subcategory.store')); ?>" enctype="multipart/form-data" method="POST" class="floating-labels">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-body">
                                    <!--/row-->

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Subcategory Name</label>
                                                <textarea style="resize: vertical;padding-top: 15px;" rows="1" name="name" id="name" value="<?php echo e(old('name')); ?>" required="" type="text" placeholder="Electronics * Fashion" class="form-control"></textarea>
                                                <i style="color:red">At once upload multiple category separated by Star[*]</i> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <span for="name">Categroy</span>
                                                <select required name="parent_id" class="select2 form-control custom-select">
                                                    <option value="">Select Category</option>
                                                    <?php $__currentLoopData = $get_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if(Session::get('autoSelectId') == $category->id): ?> selected <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="dropify_image">Feature Image</label>
                                                <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
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
        <div class="modal fade" id="edit" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <form action="<?php echo e(route('subcategory.update')); ?>"  enctype="multipart/form-data" method="post">
                      <?php echo e(csrf_field()); ?>

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update subcategory</h4>
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

    
        <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- banner modal -->
        <?php echo $__env->make('admin.category.category-banner-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;


<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
   
    <script src="<?php echo e(asset('assets')); ?>/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(".select2").select2();
    </script>

    <script src="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });

        // free Ads Limit
        function freeAdsLimit(category, adslimit){
            
            var  url = '<?php echo e(route("admin.setAdsLimit")); ?>';
            if(adslimit){
            $.ajax({
                url:url,
                method:"get",
                data:{adslimit:adslimit,category:category},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                },
                error: function(jqXHR, exception) {
                    toastr.error('Internal server error.');
            }
            });
        }
        }
    </script>


    <script type="text/javascript">

      function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '<?php echo e(route("subcategory.edit", ":id")); ?>';
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

        // if occur error open model
        <?php if($errors->any()): ?>
            $("#<?php echo e(Session::get('submitType')); ?>").modal('show');
        <?php endif; ?>
    </script>
  
     
    <script>
        $(document).ready(function(){
            $( "#categoryPositionSorting" ).sortable({
                placeholder : "ui-state-highlight",
                update  : function(event, ui)
                {
                    var ids = new Array();
                    $('#categoryPositionSorting tr').each(function(){
                        ids.push($(this).attr("id"));
                    });
                    $.ajax({
                        url:"<?php echo e(route('categorySorting')); ?>",
                        method:"get",
                        data:{ids:ids,operator:'!=',operator2:'='},
                        success:function(data){
                            toastr.success(data)
                        }
                    });
                }
            });
        });
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/category/subcategory.blade.php ENDPATH**/ ?>