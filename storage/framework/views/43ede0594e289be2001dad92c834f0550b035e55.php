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
       <div class="form-group"><label class="dropify_image_area required">Add Images</label> <div class="form-group"> <input data-default-file="<?php echo e(asset('upload/marketing/'.$data->image)); ?>" type="file" name="image" id="input-file-now" class="dropify" /> </div> </div>
    </div>
    

    
</div><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/addvertisement/addvertisement-edit.blade.php ENDPATH**/ ?>