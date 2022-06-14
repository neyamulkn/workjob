<input type="hidden" value="<?php echo e($data->id); ?>" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="module_name">Module Name</label>
        <input  name="module_name" id="module_name" value="<?php echo e($data->module_name); ?>" required="" type="text" class="form-control">
    </div>
</div>
<!-- <div class="col-md-12">
    <div class="form-group">
        <label for="route">Route Name</label>
        <input  name="route" id="route" value="<?php echo e($data->route); ?>" type="text" class="form-control">
    </div>
</div> -->

<!-- <div class="col-md-12">
    <div class="form-group">
        <label for="icon">Module Icon</label>
        <input  name="icon" id="icon" value="<?php echo e($data->icon); ?>" type="text" class="form-control">
    </div>
</div> -->

<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" <?php echo e(($data->status == 1 ) ?  'checked' : ''); ?> type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>

<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/module/module-edit.blade.php ENDPATH**/ ?>