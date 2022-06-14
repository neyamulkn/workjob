<div class="card-body inbox-panel"><a href="<?php echo e(route('adminMessageWrite')); ?>" class="btn btn-danger m-b-20 p-10 btn-block waves-effect waves-light">Write New Message</a>
    <ul class="list-group list-group-full">
        <!-- <li class="list-group-item <?php if(Request::segment(3)  == 'inbox'): ?> active <?php endif; ?>"> <a href="<?php echo e(route('adminMessage', 'inbox')); ?>"><i class="mdi mdi-gmail"></i> Inbox <span class="badge badge-success ml-auto">0</a></span>
        </li> -->
        <li class="list-group-item <?php if(Request::segment(3)  == 'all'): ?> active <?php endif; ?>">
            <a href="<?php echo e(route('adminMessage')); ?>"> <i class="mdi mdi-label"></i> Message list</a>
        </li>
        <li class="list-group-item <?php if(Request::segment(3) == 'draft'): ?> active <?php endif; ?>" >
            <a  href="<?php echo e(route('adminMessage', 'draft')); ?>"> <i class="mdi mdi-send"></i> Draft </a></li>
       
        
    </ul>
</div><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/message/leftsidebar.blade.php ENDPATH**/ ?>