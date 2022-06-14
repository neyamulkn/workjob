
<?php $__env->startSection('title', 'Banner list'); ?>
<?php $__env->startSection('css'); ?>
  
    <link href="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 180px !important;
        }
        #myTable img{border: 1px solid red;}
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
                        <h4 class="text-themecolor">Banner List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">banner</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <?php if($permission['is_add']): ?>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New banner</button><?php endif; ?>
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

                            <form action="" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="title" placeholder="Banner title or page name" value="<?php echo e(Request::get('title')); ?>" type="text" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="page"  id="page" style="width:100%" id="page" class="select2 form-control custom-select">
                                                       <option value="all">All page</option>
                                                       <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                       <option <?php if(Request::get('page') == $page->slug): ?> selected <?php endif; ?> value="<?php echo e($page->slug); ?>"><?php echo e($page->title); ?></option>
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

                                <div class="table-responsive">
                                    <table id="config-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Page</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="banners">
                                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($banner->id); ?>">
                                                <?php
                                                    $width = 340/$banner->banner_type;
                                                ?>
                                                <td><?php echo e((($banners->perPage() * $banners->currentPage() - $banners->perPage()) + ($index+1) )); ?></td>
                                                <td style="width: 360px;">
                                                    <?php if($banner->banner1): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner1); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?>
                                                    <?php if($banner->banner2): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner2); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?>
                                                    <?php if($banner->banner3): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner3); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?> <?php if($banner->banner4): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner4); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?> <?php if($banner->banner5): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner5); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?> <?php if($banner->banner6): ?>
                                                    <img src="<?php echo asset('upload/images/banner/'. $banner->banner6); ?>" width="<?php echo e($width); ?>">
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($banner->title); ?></td>
                                                <td><?php echo e(str_replace('-', ' ', ($banner->page_title) ? $banner->page_title : $banner->title  )); ?></td>
                                                <td>
                                                    <?php if($banner->btn_link1): ?>
                                                    <small> <?php echo $banner->btn_link1; ?> <br/> </small>
                                                    <?php endif; ?>
                                                    <?php if($banner->btn_link2): ?>
                                                    <small> <?php echo $banner->btn_link2; ?> <br/> </small>
                                                    <?php endif; ?>
                                                    <?php if($banner->btn_link3): ?>
                                                    <small> <?php echo $banner->btn_link3; ?> <br/> </small>
                                                    <?php endif; ?>
                                                    <?php if($banner->btn_link4): ?>
                                                    <small> <?php echo $banner->btn_link4; ?> <br/> </small>
                                                    <?php endif; ?>
                                                    <?php if($banner->btn_link5): ?>
                                                    <small> <?php echo $banner->btn_link5; ?> <br/> </small>
                                                    <?php endif; ?>
                                                    <?php if($banner->btn_link6): ?>
                                                    <small> <?php echo $banner->btn_link6; ?> <br/> </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" <?php if($permission['is_edit']): ?> onclick="satusActiveDeactive('banners', <?php echo e($banner->id); ?>)" <?php endif; ?> type="checkbox" <?php echo e(($banner->status == 1) ? 'checked' : ''); ?>  type="checkbox" class="custom-control-input" id="status<?php echo e($banner->id); ?>">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status<?php echo e($banner->id); ?>"></label>
                                                
                                                    </div>
                                                </td>
                                                <td><?php if($permission['is_edit']): ?>
                                                    <button type="button" onclick="edit('<?php echo e($banner->id); ?>')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> </button><?php endif; ?>
                                                    <?php if($permission['is_delete']): ?>
                                                    <button data-target="#delete" onclick="deleteConfirmPopup('<?php echo e(route("banner.delete", $banner->id)); ?>')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button><?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                       <?php echo e($banners->appends(request()->query())->links()); ?>

                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($banners->firstItem()); ?> to <?php echo e($banners->lastItem()); ?> of total <?php echo e($banners->total()); ?> entries (<?php echo e($banners->lastPage()); ?> Pages)</div>
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
        <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New banner</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="<?php echo e(route('banner.store')); ?>" enctype="multipart/form-data" data-parsley-validate method="POST" >
                                <?php echo e(csrf_field()); ?>

                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="" for="title">Banner Title</label>
                                                <input name="title" id="title" value="<?php echo e(old('title')); ?>"  type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name required">Select Banner Type</label>
                                                <select required onchange="bannerType(this.value)" name="banner_type" class="form-control">
                                                    <option value="">Select Banner</option>
                                                    <option  value="1">Large Banner</option>
                                                    <option  value="2">Two Banner</option>
                                                    <option  value="3">Three Banner</option>
                                                    <option  value="4">Four Banner</option>
                                                    <option  value="5">Five Banner</option>
                                                    <option  value="6">Six Banner</option>
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name required">Select Page</label>
                                                <select required  name="page_name" class="form-control">
                                                    <option value="all">All Page</option>
                                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($page->id); ?>"><?php echo e($page->title); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="showBannerImage"> </div>
                                    
                                         
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
                                                <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add New banner</button>
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
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('banner.update')); ?>" enctype="multipart/form-data"  method="post">
                <?php echo e(csrf_field()); ?>

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update banner</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
          </div>
        <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/dropify/dist/js/dropify.min.js"></script>

   <script>
      
        function removeImage(id, imageNo){
            if ( confirm("Are you sure delete it.?")) {
                       
                $.ajax({
                    url:"<?php echo e(route('bannerImage_delete')); ?>",
                    method:"get",
                    data: {id:id, imageNo:imageNo},
                    success:function(data){
                        if(data){
                            $('.image'+imageNo).html('<input type="file" required accept="image/*" data-type="image" data-allowed-file-extensions="jpg jpeg png gif"  name="banner'+imageNo+'" id="'+imageNo+'" class="dropify" />');
                            $("#image"+imageNo).addClass('dropify');
                            $('.dropify').dropify();
                            toastr.success(data.msg);
                        }
                    }
                }); 
            }
            return false;
        }

    </script>

    <script type="text/javascript">

      function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '<?php echo e(route("banner.edit", ":id")); ?>';
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

    function bannerType(type, edit=''){
        var width = Math.round(1200/type);
        var output = '';
        for(var i=1; i<=type; i++){
            output += '<div class="col-md-'+Math.round(12/type)+'"><div class="form-group"><label class="required dropify_image">Banner '+i+'</label><input type="hidden" name="width" value="'+width+'"><input required type="file" class="dropify" accept="image/*" data-type="image" data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="banner'+i+'" id="input-file-events"><p style="color:red;font-size: 10px">Image Size: '+width+'px * 250px</p> <label class="required" for="btn_link">Link '+i+'</label><input type="text" required id="btn_link" name="btn_link'+i+'" placeholder="Exp: <?php echo e(url("/")); ?>" class="form-control"></div></div>';
        }
        document.getElementById('showBannerImage'+edit).innerHTML = output;
        $('.dropify').dropify();

    }

    // if occur error open model
    <?php if($errors->any()): ?>
        $("#<?php echo e(Session::get('submitType')); ?>").modal('show');
    <?php endif; ?>
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/banners/banner.blade.php ENDPATH**/ ?>