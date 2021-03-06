
<?php $__env->startSection('title', ($category) ? $category->name : 'Find Job' . ' | '. Config::get('siteSetting.site_name') ); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        .filterBtn{text-align: left; border: none; padding: 0px 3px; font-weight: 600;font-size: 14px;}
        .filter{position: fixed;top: 0;background: #fff;z-index: 999;padding: 10px; display: none; overflow-y: scroll;height: 100%;}
        .product-widget-dropitem{padding-left: 5px;}
        .product-meta span{color: var(--gray);font-size: 12px}
        .product-meta {display: flex; flex-direction: column;}
        .product-info{padding: 0;border: none;}
        .page-item.active .page-link{background:#EB5206;}
        @media (max-width: 575px) {
            #filter_product{min-height:150px}
            
        }
        .post-price{font-size: 19px;font-weight: 500;color: #000;letter-spacing: 2px;}
        .post-area{padding: 10px 10px 10px;display: block;margin: 5px;background: #fff; border-radius: 5px;}
        .post-content{display: flex;justify-content: center; text-align: center;}
        .progress{width: 200px;background: #cbcbcb;}
        .post-info{padding-right: 30px;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
           
            <?php
            $topOfContent = $middleOfContent = $bottomOfContent = $sitebarTop = $sitebarMiddle = $sitebarBottom = null ;
            foreach ($get_ads as $ads){
                if($ads->position == 'top-content'){
                    $topOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
                }elseif($ads->position == 'sidebar-top'){
                    $sitebarTop = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>';
                }elseif($ads->position == 'sidebar-middle'){
                    $sitebarMiddle = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>';
                }elseif($ads->position == 'sidebar-bottom'){
                    $sitebarBottom = '<div class="sidebar">'. ($ads->adsType == 'image' ? '<a href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code) . '</div>' ; 
                }else{
                    echo '';
                }
            }
            ?>

                <?php if(!$topOfContent): ?><div style="margin: 5px -20px !important;"><?php echo $topOfContent; ?></div><?php endif; ?>

                <div class="row page-titles">
                    <div class="col-5 col-md-3" style="display: flex;align-items: center;justify-content: center;">
                       <button class="btn filterBtn btn-block" data-toggle="modal" data-target="#selectcatmodal">
                       <i style="color:#EB5206" class="fa fa-tag"></i><?php if($category): ?> <?php echo e($category->name); ?> <?php else: ?> <span class="hidden-xs"> Select </span> Category <?php endif; ?>
                       </button>
                    </div>
                    <div class="col-5 col-md-4" style="display: flex;align-items: center;justify-content: center;padding:0px;padding-left: 5px;<?php if((new \Jenssegers\Agent\Agent())->isMobile()): ?> border-left: 1px solid #ededed;border-right: 1px solid #ededed; <?php endif; ?>">
                       <button class="btn filterBtn btn-block" type="submit" data-toggle="modal" data-target="#locationmodal" >
                       <i style="color:#EB5206" class="fa fa-map-marker"></i> <?php if($state): ?> <?php echo e($state->name); ?> <?php else: ?> <span class="hidden-xs"> Select </span> Location <?php endif; ?>
                       </button>
                    </div>
                   
                    <div class="col-2 col-md-5" style="padding:0px ;padding-left: 5px;">

                        <div class="btn-group">
                            <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="filterBtn "> Sort</span>
                            </button>
                            <div class="dropdown-menu">
                                <a  class="dropdown-item text-inverse" title="Recent Job" href="javascript:void(0)">Recent Job</a>
                                <a  class="dropdown-item text-inverse" title="View product" href="javascript:void(0)">Highest Paying</a>
                                
                            </div>
                        </div> 
                    </div>
                        
                </div>
                <section class="inner-section ad-list-part">
                    <div class="container">
                        
                        <div class="row">
                            <div id="content" class="col-lg-12" >
                                <div id="filter_product">
                                <?php echo $__env->make('users.jobs.job-filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
    </div>

    <div class="modal fade" id="selectcatmodal" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="border: none;padding-bottom: 0;">
                    <h4 class="modal-title">Select Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="product-widget-list">
                        <li><a href="<?php echo e(route('find.jobs')); ?>"> All Categories</a></li>
                        <?php $__currentLoopData = $get_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="product-widget-dropitem" style="margin: 0;padding: 8px; ">
                            <a href="<?php echo e(route('find.jobs', $category->slug)); ?>" class="product-widget-link">
                                 <?php echo e($category->name); ?>

                            </a>
                            <ul class="product-widget-dropdown" >
                                <?php $__currentLoopData = $category->get_subcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('find.jobs', $subcategory->slug)); ?>"> <?php echo e($subcategory->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="locationmodal" role="dialog" style="display: none;">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="border: none;padding-bottom: 0;">
                    <h4 class="modal-title">Select Location</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="product-widget-list">
                        <li><a href="<?php echo e(route('home.category')); ?>"> International</a></li>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('find.jobs')); ?>/<?php echo e(Request::route('category') ?  Request::route('category').'?location='.$state->slug : '?location='. $state->slug); ?>"> <?php echo e($state->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">
    
    function filter_data(page)
    {
        //enable loader
        $('#filter_product').html('<div style="display:block;" id="loadingData"></div>');
        
        window.scrollTo({top: 100, behavior: 'smooth'});
        $('.filter').hide().fadeOut();
        var concatUrl = '?';

        <?php if(Request::route('category')): ?>
            concatUrl += "<?php echo e(Request::route('category')); ?>";
        <?php endif; ?>
        
        
        <?php if(Request::get('location')): ?>
            concatUrl += "location=<?php echo e(Request::get('location')); ?>";
        <?php endif; ?>
        
        var searchKey = $("#searchKey").val();
        if(searchKey != '' ){
            concatUrl += 'q='+searchKey;
        }

    
        var sortby = $("#sortby :selected").val();
        if(typeof sortby != 'undefined' && sortby != ''){
            concatUrl += '&sortby='+sortby;
            //check weather page null or set 
            if(page == null){
                //var active = $('.active .page-link').html();
                var page = 1;
            }
        }

  
        var price_min = $("#price_min").val();
        if(price_min != '' ){
            concatUrl += '&price_min='+price_min;
        }

        var price_max = $("#price_max").val();
        if(price_max != '' ){
            concatUrl += '&price_max='+price_max;
        }

        if(page != null){concatUrl += '&page='+page;}
     
        var link = '<?php echo e(URL::current()); ?>/'+concatUrl;
            history.pushState({id: null}, null, link);

        $.ajax({
            url:link,
            method:"get",
            data:{
                filter:'filter',perPage:showItem
            },
            success:function(data){
               
                if(data){
                    $('#filter_product').html(data);
                    
                    //AD LIST FEATURE SLIDER
                    $('.ad-feature-slider').slick({
                        autoplay: true,
                        infinite: true,
                        arrows: true,
                        centerMode: true,
                        centerPadding: '180px',
                        speed: 800,
                        slidesToShow: 1,
                        prevArrow: '<i class="fas fa-long-arrow-alt-right dandik"></i>',
                        nextArrow: '<i class="fas fa-long-arrow-alt-left bamdik"></i>',
                        responsive: [
                          {
                            breakpoint: 1200,
                            settings: {
                              arrows: true,
                              centerMode: true,
                              centerPadding: '180px',
                              slidesToShow: 1
                            }
                          },
                          {
                            breakpoint: 768,
                            settings: {
                              arrows: true,
                              centerMode: true,
                              centerPadding: '40px',
                              slidesToShow: 1
                            }
                          },
                          {
                            breakpoint: 576,
                            settings: {
                              arrows: false,
                              centerMode: true,
                              centerPadding: '35px',
                              slidesToShow: 1
                            }
                          },
                          {
                            breakpoint: 401,
                            settings: {
                              arrows: false,
                              centerMode: true,
                              centerPadding: '0px',
                              slidesToShow: 1
                            }
                          }
                        ]
                    });
                }else{
                    $('#filter_product').html('Not Found');
                }
            },
            error: function() {
                $('#filter_product').html('<span class="ajaxError">Internal server error.!</span>');
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
       
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    function sortproduct(){
        filter_data();
    }
    function showPeriod(){
        filter_data();
    }

    function searchItem(value){
        if(value != ''){ filter_data(); }
    }

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];

        filter_data(page);
    });

      
        $(window).on('popstate', function() {  
           var page = $('.pagination a').attr('href').split('page=')[1];
           
            if(page != 'undefined' && page>0){
                window.scrollTo({top: 100, behavior: 'smooth'});
                filter_data(page);
            }
       });

    

    $('#resetAll').click(function(){
        $('input:checkbox').removeAttr('checked');
        $('input[type=checkbox]').prop('checked', false);
        $("#searchKey").val('');
        $('input:radio').removeAttr('checked');
         $("#price-range").val('0');
        //call function
        filter_data();
    });

    $(document).ready(function(){

        $(".open-filter").click(function(e){
            e.preventDefault();
            $(".filter").show().fadeIn();
        });
       
        $('.close-filter').click(function() {
          
            $('.filter').hide().fadeOut();
            
        }); 
    });

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/jobs/jobs.blade.php ENDPATH**/ ?>