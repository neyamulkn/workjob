<div class="modal fade" id="setBanner" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">

          <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New banner</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body form-row">
                <div class="card-body">
                    <form action="<?php echo e(route('banner.store')); ?>" enctype="multipart/form-data" data-parsley-validate method="POST" >
                        <?php echo e(csrf_field()); ?>

                        <div class="form-body">
                            <!--/row-->
                            <div class="row justify-content-md-center">
                                <div class="col-md-12">
                                    <div class="form-group"> 
                                        <label class="dropify_image">Banner Image</label>
                                        <input required="" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="banner1">
                                        <p style="color:red">Banner Size: 1200px * 250px</p>
                                    </div>
                                    <?php if($errors->has('banner1')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?php echo e($errors->first('banner1')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-success">Add New Banner</button>
                            </div>
                            <div class="row justify-content-md-center" id="getCategoryBanner"> </div>
                            
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('perpage-js'); ?>

    <script type="text/javascript">
    
    //get banner image
    function getCategoryBanner(slug){
        $('#getCategoryBanner').html('<div class="loadingData"></div>');
        var  url = '<?php echo e(route("getCategoryBanner", ":slug")); ?>';
        url = url.replace(':slug',slug);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#getCategoryBanner").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            <?php echo $__env->make('common.ajaxError', ['ID' => 'getCategoryBanner'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });
    }

 
    function deleteBanner(id) {
        if(confirm('Are you sure delete banner.?')){
            var link = '<?php echo e(route("banner.delete", ":id")); ?>';
            var link = link.replace(':id', id);
           
                $.ajax({
                url:link,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#banner"+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }

            });
        }
        return false;
    }

</script>
<?php $__env->stopSection(); ?>
<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/category/category-banner-modal.blade.php ENDPATH**/ ?>