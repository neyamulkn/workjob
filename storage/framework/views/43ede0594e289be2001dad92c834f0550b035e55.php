<input type="hidden" value="<?php echo e($data->id); ?>" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="ads_name">Ads Title</label>
            <input type="text" value="<?php echo e($data->ads_name); ?>"  name="ads_name"  id="ads_name" placeholder="Enter ads name" class="form-control" >
        </div>
    </div>

    <div class="col-md-12">
       <div class="form-group"> <label for="redirect_url">Redirect URL</label>  <input type="text" name="redirect_url"  id="redirect_url" value="<?php echo e($data->redirect_url); ?>" class="form-control" > </div>
    </div>

    <div class="col-md-12">
        <div class="form-group labelArea row"> 
            <?php for($i=1; $i<=7; $i++): ?>
            <div class="col-md-6">
            <input type="radio" name="price" <?php if($data->days == $i): ?> checked <?php endif; ?> value="<?php echo e($i); ?>" id="editprice<?php echo e($i); ?>">
            <label for="editprice<?php echo e($i); ?>" class="labelBox"><span> <i class="fab fa-adversal"></i> <?php echo e($i); ?> Day</span> <span><?php echo e(config('siteSetting.currency_symble'). $i); ?></span></label> </div>
            <?php endfor; ?>
        </div>
    </div>

    <div class="col-md-12">
       <div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input data-default-file="<?php echo e(asset('upload/marketing/'.$data->image)); ?>" type="file" name="image" id="input-file-now" class="dropify" /> </div> </div>
    </div>
    

    
</div><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/addvertisement/addvertisement-edit.blade.php ENDPATH**/ ?>