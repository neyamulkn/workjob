    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.min.js')); ?>"></script>
  
    <?php echo $__env->yieldContent('js'); ?>
    <?php echo $__env->yieldContent('perpage-js'); ?>
    <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            <?php if(env('MODE') == 'demo'): ?>
            toastr.error('Demo mode on edit/update not working');
            return false;
            <?php endif; ?>
            var  url = '<?php echo e(route("statusChange")); ?>';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>     

    <script type="text/javascript">
           function getNotification(type){
            $.ajax({
            url:'<?php echo e(route("getNotifications")); ?>',
            type:'get',
            data:{type:type},
            success:function(data){
                if(data){
                    $('.'+type).html(data.notifications);
                }
            }
          });
        }
        function deleteConfirmPopup(route, item='') {
            $('#deleteModal').modal('show');
            document.getElementById('deleteItemRoute').value = route;
            //hide delete item
            document.getElementById('item').value = item;
        }

        function deleteItem(route) {
            <?php if(env('MODE') == 'demo'): ?>
            toastr.error('Demo mode on delete not working');
            return false;
            <?php endif; ?>
            //separate id from route
            var id = route.split("/").pop();
            var item = $('#item').val();
            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#item"+item+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }


    </script>    



    <?php echo Toastr::message(); ?>

    <script>
        <?php if($errors->any()): ?>
            
            <?php if(Session::get('submitType')): ?>
                // if occur error open model
                $("#<?php echo e(Session::get('submitType')); ?>").modal('show');
                //open edit modal by id
                <?php if(Session::get('submitType')=='edit'): ?>
                    edit(<?php echo e(old('id')); ?>);
                <?php endif; ?>
            <?php endif; ?>

            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error("<?php echo e($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </script>

<?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/partials/frontend/scripts.blade.php ENDPATH**/ ?>