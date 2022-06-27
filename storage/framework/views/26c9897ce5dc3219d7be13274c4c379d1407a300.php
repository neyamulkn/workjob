<input type="hidden" value="<?php echo e($data->id); ?>" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="module_name">Module Name</label>
        <input  name="module_name" id="module_name" value="<?php echo e($data->module_name); ?>" required="" type="text" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="route">Route Name</label>
        <input  name="route" id="route" value="<?php echo e($data->route); ?>" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="sidebar"> <input name="is_hidden_sidebar" <?php if($data->is_hidden_sidebar == 1): ?> checked <?php endif; ?>  id="sidebar" value="1" type="checkbox"  > Hidden is sidebar</label><br/>
        <label for="role_permission"> <input <?php if($data->is_hidden_role_permission == 1): ?> checked <?php endif; ?> name="is_hidden_role_permission" id="role_permission" value="1" type="checkbox"  > Hidden is role permission</label>
    </div>
</div>

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

<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/module/submodule-edit.blade.php ENDPATH**/ ?>