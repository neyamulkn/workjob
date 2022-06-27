<form  onsubmit="return confirm('Are you sure update this deposit payment info.?')" action="<?php echo e(route('depositPaymentUpdate')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-12">
        	<input type="hidden" name="deposit_id" value="<?php echo e($deposit->id); ?>">
            <table class="">
                <tr><td style="font-weight: bold;">Author Name:</td><td> <?php echo e($deposit->user->name); ?></td></tr>
                <tr><td style="font-weight: bold;">Amount:</td><td>  <?php echo e(config('siteSetting.currency_symble') . $deposit->amount); ?></td>
                </tr>
            </table>
            <span style="font-weight: bold;">Payment Information:</span><br/>
            <?php if($deposit->tnx_id): ?> Trnx Id: <?php echo e($deposit->tnx_id); ?> <br> <?php endif; ?> <?php echo e($deposit->payment_info); ?>

            
        </div>

 

        <div class="col-md-12">
            <label for="notes">Payment Status</label>
            <select name="payment_status" required="" class="form-control" id="status">
                <option value="">Select Status</option>
                <option <?php if($deposit->payment_status== 'pending'): ?> selected <?php endif; ?> value="pending">Pending</option>
                <option <?php if($deposit->payment_status== 'received'): ?> selected <?php endif; ?> value="received">Received</option>
                
                <option <?php if($deposit->payment_status== 'paid'): ?> selected <?php endif; ?> value="paid">Paid</option>
                <option <?php if($deposit->payment_status== 'reject'): ?> selected <?php endif; ?> value="reject">Reject</option>
                
            </select>
        </div>

       
        <div class="col-md-12">
           
            <div class="modal-footer">
                <button type="submit" id="submitBtn" class="btn btn-success"> <i class="fa fa-save"></i> Update payment</button>
            </div>
        </div>
       
    </div>
</form><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/deposit/paymentCheckModal.blade.php ENDPATH**/ ?>