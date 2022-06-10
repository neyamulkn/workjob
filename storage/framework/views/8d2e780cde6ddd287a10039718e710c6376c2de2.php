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

        // delete product feature detail
        function deleteDataCommon(table,id, field=''){
            <?php if(env('MODE') == 'demo'): ?>
            toastr.error('Demo mode on delete not working');
            return false;
            <?php endif; ?>
            if(confirm('Are you sure delete.?')) {
                var route = '<?php echo e(route("deleteDataCommon")); ?>';
                route = route.replace(":id", id);
                $.ajax({
                    url:route,
                    method:"get",
                    data:{table:table,id:id,field:field},
                    success:function(data){
                        if(data.status){
                            $("#"+table+id).remove();
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    }
                });
            }else{
                return false;
            }
        }
    </script>    

    <script type="text/javascript">
        //change status by id
        function approveUnapprove(table, id, field = null){
            <?php if(env('MODE') == 'demo'): ?>
            toastr.error('Demo mode on edit/update not working');
            return false;
            <?php endif; ?>
            var  url = '<?php echo e(route("approveUnapprove")); ?>';
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

    <script>
        $(document).ready(function(){
            $( "#positionSorting" ).sortable({
                placeholder : "ui-state-highlight",
                update  : function(event, ui)
                {
                    var ids = new Array();
                    $('#positionSorting tr').each(function(){
                        ids.push($(this).attr("id"));
                    });
                    var table = $(this).attr('data-table');

                    $.ajax({
                        url:"<?php echo e(route('positionSorting')); ?>",
                        method:"get",
                        data:{ids:ids,table:table},
                        success:function(data){
                            toastr.success(data)
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript" src="<?php echo e(asset('js')); ?>/shortcuts.js"></script>
    <script>
    shortcuts.add('alt+u',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/product/upload" 
    })
    shortcuts.add('alt+o',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/order" 
    })
    shortcuts.add('alt+d',function() {
        window.location = "<?php echo e(url('/')); ?>/admin" 
    })
    shortcuts.add('alt+h',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/homepage/section" 
    })
    shortcuts.add('alt+w',function() {
        window.location = "<?php echo e(url('/')); ?>" 
    })
    shortcuts.add('alt+s',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/slider/create" 
    })
    shortcuts.add('alt+c',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/customer/list" 
    })
    shortcuts.add('alt+r',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/product/review" 
    })
    shortcuts.add('alt+b',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/banner/list" 
    })
    shortcuts.add('alt+g',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/general/setting" 
    })
    shortcuts.add('alt+l',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/logo/setting" 
    })
    shortcuts.add('alt+p',function() {
        window.location = "<?php echo e(url('/')); ?>/admin/product" 
    })
    </script>
<!--     <script>
        
        Echo.channel('postBroadcast')
        .listen('PostCreated', (e) => {
            toastr.info(e.post['title']);
        });
    </script> --><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/layouts/partials/frontend/scripts.blade.php ENDPATH**/ ?>