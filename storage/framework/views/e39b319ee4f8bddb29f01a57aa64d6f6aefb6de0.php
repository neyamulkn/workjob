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
</li><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/blog/comment/show_comment.blade.php ENDPATH**/ ?>