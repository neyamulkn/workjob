
<?php $__env->startSection('title'); ?>
<?php if($category): ?> <?php echo e($category->name); ?> |  <?php endif; ?> Blog 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Blogs</h4>
                    </div>
                    
                </div>
     <section class="blog-part">
            <div class="container">
                <div class="row content-reverse">
                    <div class="col-lg-4">
                        <div class="row">

                            <!-- SEARCH BAR -->
                            <div class="col-lg-12">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Search</h5>
                                    </div>
                                    <form class="blog-src">
                                        <input type="text" name="keyword" value="<?php echo e(Request::get('keyword')); ?>" placeholder="Search...">
                                        <button><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- TOP CATEGORY -->
                            <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Top categories</h5>
                                    </div>
                                    <ul class="blog-cate">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <h5><a href="<?php echo e(route('blog', $category->slug)); ?>"><?php echo e($category->name); ?></a></h5>
                                            <p><?php echo e($category->blogs_by_category_count); ?></p>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- POPULAR POST -->
                            <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>popular post</h5>
                                    </div>
                                    <ul class="blog-suggest">
                                        <?php $__currentLoopData = $popular_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popular_blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <div class="suggest-img">
                                                <a href="<?php echo e(route('blog_details', $popular_blog->slug)); ?>"><img src="<?php echo e(asset('upload/images/blog/thumb/'.$popular_blog->image)); ?>" alt="<?php echo e($popular_blog->title); ?>"></a>
                                            </div>
                                            <div class="suggest-content">
                                                <div class="suggest-title">
                                                    <h4><a href="<?php echo e(route('blog_details', $popular_blog->slug)); ?>"><?php echo e(Str::limit($popular_blog->title, 40)); ?></a></h4>
                                                </div>
                                                <div class="suggest-meta">
                                                    <div class="suggest-date">
                                                        <i class="far fa-calendar-alt"></i>
                                                        <p><?php echo e(Carbon\Carbon::parse($popular_blog->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                                    </div>
                                                    <div class="suggest-comment">
                                                        <i class="far fa-comments"></i>
                                                        <p>0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>

                            

                            <!-- BEST TAGS -->
                            <!-- <div class="col-md-8 col-lg-12 m-auto">
                                <div class="blog-sidebar">
                                    <div class="blog-sidebar-title">
                                        <h5>Best tags</h5>
                                    </div>
                                    <ul class="blog-tag">
                                        <li><a href="#">domain</a></li>
                                        <li><a href="#">cloud</a></li>
                                        <li><a href="#">web</a></li>
                                        <li><a href="#">offer</a></li>
                                        <li><a href="#">support</a></li>
                                        <li><a href="#">payment</a></li>
                                        <li><a href="#">E-commerce</a></li>
                                        <li><a href="#">Sequerity</a></li>
                                        <li><a href="#">solution</a></li>
                                        <li><a href="#">knowladge</a></li>
                                    </ul>
                                </div>
                            </div>
 -->
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <?php if(count($blogs)>0): ?>
                            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-6">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <img src="<?php echo e(asset('upload/images/blog/thumb/'.$blog->image)); ?>" alt="<?php echo e($blog->title); ?>">
                                        <div class="blog-overlay">
                                            <span class="marketing"><?php echo e($blog->get_category->name); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <?php if($blog->author): ?>
                                        <a href="#" class="blog-avatar">
                                            <img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($blog->author->photo) ? $blog->author->photo : 'defualt.png'); ?>" alt="<?php echo e($blog->author->name); ?>">
                                        </a>
                                        <ul class="blog-meta">
                                           
                                            <li>
                                                <i class="fas fa-user"></i>
                                                <p><a href="#"><?php echo e($blog->author->name); ?></a></p>
                                            </li>
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <p><?php echo e(Carbon\Carbon::parse($blog->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                            </li>
                                        </ul>
                                        <?php endif; ?>
                                        <div class="blog-text">
                                            <h4><a href="<?php echo e(route('blog_details', $blog->slug)); ?>"><?php echo e(Str::limit($blog->title, 40)); ?></a></h4>
                                            <p><?php echo Str::limit(strip_tags($blog->description), 100); ?></p>
                                        </div>
                                        <a href="<?php echo e(route('blog_details', $blog->slug)); ?>" class="blog-read">
                                            <span>read more</span>
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div style="text-align: center;">
                                <h3>Search Result Not Found.</h3>
                                <p>We're sorry. We cannot find any matches for your search term</p>
                                <i style="font-size: 10rem;" class="fa fa-search"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo e($blogs->appends(request()->query())->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div></div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/blog/blog.blade.php ENDPATH**/ ?>