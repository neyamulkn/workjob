
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/node_modules')); ?>/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="<?php echo e(asset('css')); ?>/pages/dashboard1.css" rel="stylesheet">
    <style type="text/css">.round{font-size:25px;}.display-5{font-size: 2rem !important;}</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
      <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid dashboard1"><br/>
               
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-success text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-cart-plus"></i> 
                                <a href="<?php echo e(route('admin.product.list')); ?>" class="text-white"><?php echo e($allPosts); ?></a></h1>
                                <h6 class="text-white">Total Jobs</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-info text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-hourglass-half"></i> 
                                <a href="<?php echo e(route('admin.product.list', 'pending')); ?>" class="text-white"><?php echo e($pendingPosts); ?></a></h1>
                                <h6 class="text-white">Pending Jobs</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-warning text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-database"></i> 
                                <a href="javascript:void(0)" class="text-white"><?php echo e($total_task); ?></a></h1>
                                <h6 class="text-white">Total task</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-danger text-center">
                                <h1 class="font-light text-white"> <i class="fa fa-times"></i> 
                                <a href="javascript:void(0)" class="text-white"><?php echo e($pending_task); ?></a></h1>
                                <h6 class="text-white">Pending task</h6>
                            </div>
                        </div>
                    </div>
                </div>
                
              
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-user-plus"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo e($newUser); ?></h3>
                                        <h5 class="text-muted m-b-0">Customer 7 Days</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                    <h3 class="m-b-0"><?php echo e($allUser); ?></h3>
                                    <h5 class="text-muted m-b-0">All Customer</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo e($categories); ?></h3>
                                        <h5 class="text-muted m-b-0">Category</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="icon-people"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo e($allBlogs); ?></h3>
                                        <h5 class="text-muted m-b-0">Blog Post</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Popular Post</h5>
                                <div class="table-responsive">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Views</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($popularProducts)>0): ?>
                                            <?php $__currentLoopData = $popularProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><a target="_blank" href="<?php echo e(route('job_details', $product->slug)); ?>"> <img src="<?php echo e(asset('upload/images/product/thumb/'.$product->feature_image)); ?>" alt="Image" width="42"> <?php echo e(Str::limit($product->title, 30)); ?></a> </td>
                                                 <td><?php if($product->user): ?><a target="_blank" href="<?php echo e(route('customer.profile', $product->user->username)); ?>"> <?php echo e($product->user->name); ?></a><?php else: ?> Seller not found. <?php endif; ?>
                                                    </td>
                                                 <td><?php echo e($product->views); ?></td>
                                                <td><?php echo e(Config::get('siteSetting.currency_symble')); ?><?php echo e($product->price); ?></td>
                                                
                                            </tr>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?> <tr><td colspan="8"> <h1>No products found.</h1></td></tr> <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent blog</h5>
                                <div class="table-responsive ">
                                    <table class="table product-overview">
                                        <thead>
                                            <tr>
                                                <th>Blog</th>
                                                <th>Category</th>
                                                <th>Views</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php if(count($popularBlogs)>0): ?>
                                            <?php $__currentLoopData = $popularBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="item<?php echo e($blog->id); ?>">
                                                <td><a target="_blank" href="<?php echo e(route('blog_details', $blog->slug)); ?>"><img src="<?php echo e(asset('upload/images/blog/thumb/'. $blog->image)); ?>" width="50"> <?php echo e($blog->title); ?> </a></td>
                                                
                                                <td><?php echo e($blog->get_category->name ?? ''); ?></td>
                                              
                                                <td><p style="font-size:10px" class="fa fa-eye">  <?php echo e($blog->views); ?> </p></td>
                                               
                                                <td>
                                                    
                                                    <span class="label label-info"> <?php echo e($blog->status); ?> </span>
                                                    
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
                    </div>
                </div>  
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="<?php echo e(asset('assets/node_modules')); ?>/raphael/raphael-min.js"></script>
    <script src="<?php echo e(asset('assets/node_modules')); ?>/morrisjs/morris.min.js"></script>
    <script src="<?php echo e(asset('assets/node_modules')); ?>/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="<?php echo e(asset('assets/node_modules')); ?>/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
    <script src="<?php echo e(asset('js')); ?>/dashboard1.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>