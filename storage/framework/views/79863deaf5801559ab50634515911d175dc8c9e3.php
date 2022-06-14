
<?php $__env->startSection('title', ($blog) ? $blog->title : 'not found' . ' | Blog'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('frontend')); ?>/css/custom/blog-details.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">  

                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><?php echo e($blog->title); ?></h4>
                    </div>
                    
                </div>
 
    <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <?php if($blog): ?>
                        <div class="blog-details-title">
                            <h2><a href="#"><?php echo e($blog->title); ?></a></h2>
                        </div>
                        <ul class="blog-details-meta">
                            <?php if($blog->author): ?>
                            <li>
                                <a href="#">
                                    <i class="far fa-user"></i>
                                    <p><?php echo e($blog->author->name); ?></p>
                                </a>
                            </li><?php endif; ?>
                            <li>
                                <a href="#">
                                    <i class="far fa-calendar-alt"></i>
                                    <p><?php echo e(Carbon\Carbon::parse($blog->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                </a>
                            </li>
                            <?php if($blog->get_category): ?>
                            <li>
                                <a href="#">
                                    <i class="far fa-folder-open"></i>
                                    <p><?php echo e($blog->get_category->name); ?></p>
                                </a>
                            </li><?php endif; ?>
                            <li>
                                <a href="#">
                                    <i class="far fa-comments"></i>
                                    <p><?php echo e($totalComment); ?> Comment</p>
                                </a>
                            </li>
                            
                        </ul>
                        <div class="blog-details-image">
                            <img src="<?php echo e(asset('upload/images/blog/'. $blog->image)); ?>" alt="<?php echo e($blog->title); ?>">
                        </div>
                        <div class="blog-details-content">
                            <div class="description">
                                <?php echo $blog->description; ?>

                            </div>
                            
                        </div>
                        <div class="blog-details-widget">
                            <!-- <ul class="tag-list">
                                <li><h4>Tags:</h4></li>
                                <li><a href="#">Crowd</a></li>
                                <li><a href="#">Party</a></li>
                                <li><a href="#">Concert</a></li>
                            </ul> -->
                            <ul class="share-list">
                                <li><h4>Share:</h4></li>
                                <li><a href="https://www.facebook.com/sharer.php?u=<?php echo e(route('blog_details', $blog->slug)); ?>"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/share?url=<?php echo e(route('blog_details', $blog->slug)); ?>&amp;text=<?php echo $blog->title; ?>&amp;hashtags=blog"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo e(route('blog_details', $blog->slug)); ?>?rs=<?php echo e($blog->id); ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="https://web.whatsapp.com/send?text=<?php echo e(route('blog_details', $blog->slug)); ?>&amp;title=<?php echo $blog->title; ?>"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="https://pinterest.com/pin/create/button/?url=<?php echo e(route('blog_details', $blog->slug)); ?>?rs=<?php echo e($blog->id); ?>"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            <?php $__currentLoopData = $related_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related_blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 col-lg-4">
                                <div class="blog-card">
                                    <div class="blog-img">
                                        <img src="<?php echo e(asset('upload/images/blog/thumb/'.$related_blog->image)); ?>" alt="<?php echo e($related_blog->title); ?>">
                                        <div class="blog-overlay">
                                            <span class="marketing"><?php echo e($related_blog->get_category->name); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <?php if($related_blog->author): ?>
                                        <a href="<?php echo e(route('userProfile', $related_blog->author->username)); ?>" class="blog-avatar">
                                            <img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($related_blog->author->photo) ? $related_blog->author->photo : 'defualt.png'); ?>" alt="<?php echo e($related_blog->author->name); ?>">
                                        </a>
                                        <ul class="blog-meta">
                                           
                                            <li>
                                                <i class="fas fa-user"></i>
                                                <p><a href="#"><?php echo e($related_blog->author->name); ?></a></p>
                                            </li>
                                            <li>
                                                <i class="fas fa-clock"></i>
                                                <p><?php echo e(Carbon\Carbon::parse($related_blog->created_at)->format(Config::get('siteSetting.date_format'))); ?></p>
                                            </li>
                                        </ul>
                                        <?php endif; ?>
                                        <div class="blog-text">
                                            <h4><a href="<?php echo e(route('blog_details', $related_blog->slug)); ?>"><?php echo e(Str::limit($related_blog->title, 40)); ?></a></h4>
                                            <p><?php echo Str::limit(strip_tags($related_blog->description), 100); ?></p>
                                        </div>
                                        <a href="<?php echo e(route('blog_details', $related_blog->slug)); ?>" class="blog-read">
                                            <span>read more</span>
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div> 
                        <div class="blog-details-comment">
                            <div class="comment-title">
                                <h3>Comments (<?php echo e($totalComment); ?>)</h3>
                            </div>
                            <ul class="comment-list" id="show_comment">
                                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="comment">
                                        <div class="comment-author">
                                            <a href="<?php echo e(route('userProfile', $comment->author->username)); ?>"><img src="<?php echo e(asset('upload/users')); ?>/<?php echo e(($comment->author->photo) ? $comment->author->photo : 'defualt.png'); ?>" alt="comment"></a>
                                            
                                        </div>
                                        <div class="comment-content">
                                            <h4>
                                                <a href="#"><?php echo e($comment->author->name); ?></a>
                                                <span><?php echo e(Carbon\Carbon::parse($comment->created_at)->diffForHumans()); ?></span>
                                            </h4>
                                            <p id="comment<?php echo e($comment->id); ?>"><?php echo $comment->comments; ?></p>
                                        </div>
                                    </div>
                                    <?php if($blog->replyComments && count($blog->replyComments)>0): ?>
                                    <ul>
                                        <li>
                                            <div class="comment">
                                                <div class="comment-author">
                                                    <a href="#"><img src="<?php echo e(asset('frontend')); ?>/images/avatar/02.jpg" alt="comment"></a>
                                                    <button class="btn btn-inline">
                                                        <i class="fas fa-reply-all"></i>
                                                        <span>reply</span>
                                                    </button>
                                                </div>
                                                <div class="comment-content">
                                                    <h4>
                                                        <a href="#">LabonnoKhan</a>
                                                        <span>02 February 2020</span>
                                                    </h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero ab aperiam corrupti maiores animi nisi ratione maxime quae in doloremque corporis tempore earum ut voluptas exercitationem.</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <ul>
                                <?php if($totalComment > 5 ): ?>
                                <li style="text-align: center;"><a href="<?php echo e(route('blog_comments', $blog->slug)); ?>">See All Comments</a><li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="blog-details-form">
                            <div class="form-title">
                                <h3>Leave Your Comment</h3>
                            </div>
                            <form method="post" id="commentForm">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="blog_id" value="<?php echo e($blog->id); ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" id="comment" placeholder="Your Comment"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                            <button <?php if(Auth::check()): ?> type="submit" <?php else: ?> data-toggle="modal" data-target="#so_sociallogin" type="button" <?php endif; ?>  class="btn btn-inline">
                                                <i class="fas fa-tint"></i>
                                                <span>Drop your comment</span>
                                            </button>
                                            <br>
                                            <br>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php else: ?>
                        <div style="text-align: center;">
                            <h3>Blog Not Found.</h3>
                            
                            <i style="font-size: 10rem;" class="fa fa-search"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script type="text/javascript">
        $(function(){
            $("#commentForm").submit(function(event){
                event.preventDefault();
              
                $.ajax({
                        url:'<?php echo e(route("blog_comment_insert")); ?>',
                        type:'get',
                        data:$(this).serialize(),
                        success:function(result){
                            document.getElementById("comment").value = '';
                            $("#show_comment").append(result);
                             toastr.success('Comment inserted.');
                        }

                });
            });
        }); 
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/blog/blog-details.blade.php ENDPATH**/ ?>