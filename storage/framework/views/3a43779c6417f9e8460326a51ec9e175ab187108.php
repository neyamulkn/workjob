<input type="hidden" name="id" value="<?php echo e($product->id); ?>">
<div class="form-group">
    <label>Status</label>
    <select onchange="postStatus(this.value)" name="status" class="form-control">
        <option value="" >Select Status</option>
        <option value="pending" <?php if($product->status == 'pending'): ?> selected <?php endif; ?> >Pending</option>
        <option value="active" <?php if($product->status == 'active'): ?> selected <?php endif; ?>>Active</option>
        <option value="deactive" <?php if($product->status == 'deactive'): ?> selected <?php endif; ?>>Deactive</option>
       
        <option value="reject" <?php if($product->status == 'reject'): ?> selected <?php endif; ?>>Reject</option>
    </select>
</div>



<div class="form-group" id="rejectReason"><?php if($product->status == 'reject'): ?><div class="form-group"><label>Reject reason</label><textarea name="reject_reason" class="form-control" placeholder="Write post reject reason"><?php echo $product->reject_reason; ?></textarea></div><?php endif; ?></div>

<script type="text/javascript">
     
        function postStatus(status) {
            if(status == 'reject'){
                $('#rejectReason').html(`<div class="form-group">
    <label>Reject reason</label>
    <select name="reason" class="form-control">
        <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($reason->reason); ?>" ><?php echo e($reason->reason); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div><div class="form-group"><label>Write reject issue</label><textarea name="reject_reason" class="form-control" placeholder="Write post reject reason"><?php echo $product->reject_reason; ?></textarea></div>`);
            }else{
                 $('#rejectReason').html('');
            }

        }
</script><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/product/productStatus.blade.php ENDPATH**/ ?>