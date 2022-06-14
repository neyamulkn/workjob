
<?php $__env->startSection('title', 'Blog Post' ); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css')); ?>/pages/bootstrap-switch.css" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                   
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">blog</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <?php if($permission['is_view']): ?>
                        <a href="<?php echo e(route('admin.blog.list')); ?>" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> blog List</a><?php endif; ?>
                    </div>
                </div>
            </div>
               <div class="row">
                        <div class="col-lg-12">
                            <form action="" method="get">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <input name="title" placeholder="Title" value="<?php echo e(Request::get('title')); ?>" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <select name="status" class="form-control">
                                                <option value="all" <?php echo e((Request::get('status') == "all") ? 'selected' : ''); ?>>All Status</option>
                                                <option value="pending" <?php echo e((Request::get('status') == 'pending') ? 'selected' : ''); ?> >Pending</option>
                                                <option value="active" <?php echo e((Request::get('status') == 'active') ? 'selected' : ''); ?>>Active</option>
                                                <option value="deactive" <?php echo e((Request::get('status') == 'deactive') ? 'selected' : ''); ?>>Deactive</option>
                                                <option value="reject" <?php echo e((Request::get('status') == 'reject') ? 'selected' : ''); ?>>Reject</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                               <button type="submit" class="form-control btn btn-success">Search</button>
                                            </div>
                                        </div>
                                        <?php if($permission['is_add']): ?>
                                        <div class="col-md-3"><a style="color: #fff" class="btn btn-primary" href="<?php echo e(route('admin.blog.upload')); ?>">Write New Blog</a></div><?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        
                        <table id="config-table" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Blog Title</th>
                                    <th>Category</th>
                                    <th>Comments</th>
                                    <th>Views</th>
                                    <th>Date</th>
                                    <th>Publish</th>
                                    <th>Status</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php if(count($blogs)>0): ?>
                                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="item<?php echo e($blog->id); ?>">
                                    <td><?php echo e($index+1); ?></td>
                                    <td><a target="_blank" href="<?php echo e(route('blog_details', $blog->slug)); ?>"><img src="<?php echo e(asset('upload/images/blog/thumb/'. $blog->image)); ?>" width="50"> </a></td>
                                    <td><a target="_blank" href="<?php echo e(route('blog_details', $blog->slug)); ?>"> <?php echo e($blog->title); ?> </a></td>
                                    
                                    <td><?php echo e($blog->get_category->name ?? ''); ?></td>
                                  
                                    <td><?php echo e($blog->comments_count); ?></td>
                                    <td><p style="font-size:10px" class="fa fa-eye">  <?php echo e($blog->views); ?> </p></td>
                                    <td><?php echo e(Carbon\Carbon::parse($blog->created_at)->format(Config::get('siteSetting.date_format'))); ?></td>
                                    <td>
                                        <div class="bt-switch">
                                            <input <?php if($permission['is_edit']): ?> onchange="approveUnapprove('blogs', '<?php echo e($blog->id); ?>')" <?php endif; ?> type="checkbox" <?php echo e(($blog->status != 'pending') ? 'checked' : ''); ?> data-on-color="success" data-off-color="danger" data-on-text="Approved" data-off-text="Pending">
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($blog->status != 'pending'): ?>
                                        <div class="custom-control custom-switch">
                                          <input  name="status" <?php if($permission['is_edit']): ?> onclick="satusActiveDeactive('blogs', <?php echo e($blog->id); ?>)" <?php endif; ?> type="checkbox" <?php echo e(($blog->status == 'active') ? 'checked' : ''); ?>  type="checkbox" class="custom-control-input" id="status<?php echo e($blog->id); ?>">
                                          <label style="padding: 5px 12px" class="custom-control-label" for="status<?php echo e($blog->id); ?>"></label>
                                        </div>
                                        <?php else: ?>
                                            <span class="label label-warning"> Pending </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                       
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <a target="_blank" class="dropdown-item text-inverse" title="View product" href="<?php echo e(route('blog_details', $blog->slug)); ?>"><i class="ti-eye"></i> View Blog</a>
                                                <?php if($permission['is_edit']): ?>
                                                <a class="dropdown-item" title="Edit product" href="<?php echo e(route('admin.blog.edit', $blog->slug)); ?>"><i class="ti-pencil-alt"></i> Edit Blog</a><?php endif; ?>
                                                <?php if($permission['is_delete']): ?>
                                                <span title="Delete"><button   data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("admin.blog.delete", $blog->id)); ?>")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete blog</button></span><?php endif; ?>
                                            </div>
                                        </div>                                     
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr style="text-align: center;"><td colspan="8">Blog not found.!</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                

        </div>
    </div>
    <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

        <!-- bt-switch -->
    <script src="<?php echo e(asset('assets')); ?>/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>
  <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            <?php if(env('MODE') == 'demo'): ?>
            toastr.error('Demo mode on edit/update not working');
            return false;
            <?php endif; ?>
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
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/blog/index.blade.php ENDPATH**/ ?>