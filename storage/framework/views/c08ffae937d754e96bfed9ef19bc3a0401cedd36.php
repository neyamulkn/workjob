<input type="hidden" name="id" value="<?php echo e($customer->id); ?>">
<div class="form-group">
    <label>Status</label>
    <select required onchange="postStatus(this.value)" name="status" class="form-control">
        <option value="" >Select Status</option>
        
        <?php if($verify): ?>
        <option value="verify" <?php if($customer->verify): ?> selected <?php endif; ?>>Verify</option>
        <option value="unverify" <?php if($customer->verify == null): ?> selected <?php endif; ?>>Unverify</option>
        <?php else: ?>
        <option value="pending" <?php if($customer->status == 'pending'): ?> selected <?php endif; ?> >Pending</option>
        <option value="active" <?php if($customer->status == 'active'): ?> selected <?php endif; ?>>Active</option>
        <option value="deactive" <?php if($customer->status == 'deactive'): ?> selected <?php endif; ?>>Deactive</option>
       
        <option value="band" <?php if($customer->status == 'band'): ?> selected <?php endif; ?>>Band</option>
        <?php endif; ?>
    </select>
</div>



<!-- <div class="form-group" id="bandReason"><?php if($customer->status == 'band'): ?><div class="form-group"><label>Band reason</label><textarea name="band_reason" class="form-control" placeholder="Write band reason"><?php echo $customer->band_reason; ?></textarea></div><?php endif; ?></div>
 -->
<script type="text/javascript">
     
        function postStatus(status) {
            if(status == 'band'){
                $('#bandReason').html(`<div class="form-group">
    <label>band reason</label>
    <select name="reason" class="form-control">
        
    </select>
</div><div class="form-group"><label>Write band issue</label><textarea name="band_reason" class="form-control" placeholder="Write post band reason"><?php echo $customer->band_reason; ?></textarea></div>`);
            }else{
                 $('#bandReason').html('');
            }

        }
</script><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/customer/customerStatus.blade.php ENDPATH**/ ?>