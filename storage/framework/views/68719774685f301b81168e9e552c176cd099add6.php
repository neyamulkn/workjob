
<?php $__env->startSection('title', 'FAQ list'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('assets')); ?>/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
      
        svg{width: 20px}
        .faq_section{padding:1px 15px; border-radius: 5px;  background: #fff; margin-bottom: 10px; list-style: none;}
        .action_btn{ margin-top: 5px;}
        .deactive_faq{background-color: #e8dada9c;}
        .panel-title>a, .panel-title>a:active{ display:block;padding:12px 0;color:#555;font-size:14px;font-weight:bold;}
        .panel-heading a:after { padding-right: 7px !important;  font-family: 'Font Awesome 5 Free';  content: "\f107"; float: left; }
        .panel-heading.active a:after { padding-left: 7px !important;  -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); transform: rotate(180deg); padding-right: 0px !important; } 

    </style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
       
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">FAQ list</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">FAQ</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <?php if($permission['is_add']): ?>
                           <button data-toggle="modal" data-target="#addfaqModal" class="btn btn-sm btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New FAQ </button><?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->

                    <?php if(count($faqs)>0): ?>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <ul id="faqPositionSorting" data-table="faqs" style="padding: 0">
                              
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secIndex => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li id="item<?php echo e($faq->id); ?>" class="faq_section <?php if($faq->status == 0): ?> deactive_faq <?php endif; ?>"  <?php if($faq->status == 0): ?> title="Deactive this faq" <?php endif; ?> >
                                    <div class="panel panel-default">
                                        <div class="row panel-heading <?php if($secIndex == 0): ?> active <?php endif; ?>" role="tab" >
                                            <div class="col-11">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faqSection<?php echo e($faq->id); ?>" aria-expanded="true" aria-controls="faqSection<?php echo e($faq->id); ?>"> <?php echo e($secIndex+1); ?>. <?php echo e($faq->question); ?>

                                                </a>
                                              </h4>
                                            </div>
                                            <div class="col-1" style="float: right;">
                                                <div class="action_btn">
                                                    <?php if($permission['is_edit']): ?>
                                                    <button onclick="faqEdit(<?php echo e($faq->id); ?>)" title="Edit Section" class="btn btn-info btn-sm"> <i class="ti-pencil-alt"></i></button><?php endif; ?>
                                                    <?php if($permission['is_delete']): ?>
                                                    <button title="Delete Section"  data-target="#delete" onclick='deleteConfirmPopup("<?php echo e(route("faq.delete", $faq->id)); ?>", "section")'  data-toggle="modal" class="btn btn-danger btn-sm"> <i class="ti-trash"></i></button><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="faqSection<?php echo e($faq->id); ?>" class="panel-collapse collapse <?php if($secIndex == 0): ?> in <?php endif; ?>" role="tabpanel">
                                            <div class="panel-body">
                                                <?php echo $faq->answer; ?>

                                            </div>
                                        </div>
                                       
                                    </div>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               
                                </ul>
                        </div>

                    <?php else: ?>
                    <h3>FAQ not found. <button data-toggle="modal" data-target="#addfaqModal" class="btn btn-sm btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New FAQ </button></h3>
                    <?php endif; ?>        
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
      
        <!-- add Modal -->
        <div class="modal fade" id="addfaqModal" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add FAQ</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <form action="<?php echo e(route('faq.store')); ?>" method="post" >
                            <?php echo e(csrf_field()); ?>

                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="question">Question</label>
                                            <input placeholder="Write Question" name="question" id="question" value="<?php echo e(old('question')); ?>" required="" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="route">Answer</label>
                                            <textarea name="answer" rows="3" placeholder="Write Answer" class="form-control summernote"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" <?php echo e((old('status') == 'on') ? 'checked' : ''); ?> id="sectionstatus">
                                                    <label  class="custom-control-label" for="sectionstatus">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add faq</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- faq edit modal -->
        <div class="modal fade" id="faqEdit" style="display: none;">
            <div class="modal-dialog">
                <form action="<?php echo e(route('faq.update')); ?>" enctype="multipart/form-data" method="post">
                <?php echo e(csrf_field()); ?>

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit FAQ</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="faq_edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update faq</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

    
        <?php echo $__env->make('admin.modal.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('assets')); ?>/node_modules/jqueryui/jquery-ui.min.js"></script>
  
    <script type="text/javascript">

        function faqEdit(id){
            $('#faqEdit').modal('show');
            $('#faq_edit_form').html('<div class="loadingData"></div>');
            var  url = '<?php echo e(route("faq.edit", ":id")); ?>';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#faq_edit_form").html(data);
                       $('.summernote').summernote();
                    }
                },
                // $ID Error display id name
                <?php echo $__env->make('common.ajaxError', ['ID' => 'faq_edit_form'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });
        }         

  
    </script>

    <script type="text/javascript">
        $('.panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
      });

      $('.panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
      });
    </script>

       <script src="<?php echo e(asset('assets')); ?>/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    //section sorting
    $(document).ready(function(){
        $( "#faqPositionSorting" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var ids = new Array();
                $('#faqPositionSorting li').each(function(){
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
 

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/faq/faq.blade.php ENDPATH**/ ?>