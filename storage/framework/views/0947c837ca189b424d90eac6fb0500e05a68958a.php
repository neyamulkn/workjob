
<?php $__env->startSection('title', Config::get('siteSetting.title')); ?>
<?php $__env->startSection('metatag'); ?>
    <title><?php echo e(Config::get('siteSetting.title')); ?></title>
    <meta name="title" content="<?php echo e(Config::get('siteSetting.title')); ?>">
    <meta name="description" content="<?php echo e(Config::get('siteSetting.description')); ?>">
    <meta name="keywords" content="<?php echo e(Config::get('siteSetting.meta_keywords')); ?>" />
    <meta name="robots" content="index,follow" />

    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="<?php echo e(Config::get('siteSetting.title')); ?>">
    <meta property="og:description" content="<?php echo e(Config::get('siteSetting.description')); ?>">
    <meta property="og:image" content="<?php echo e(asset('upload/images/'.Config::get('siteSetting.meta_image'))); ?>">
    <meta property="og:url" content="<?php echo e(url()->full()); ?>">
    <meta property="og:site_name" content="<?php echo e(Config::get('siteSetting.site_name')); ?>">
    <meta property="og:locale" content="bd">
    <meta property="og:type" content="e-commerce">
    <!-- Schema.org for Google -->

    <meta itemprop="title" content="<?php echo e(Config::get('siteSetting.title')); ?>">
    <meta itemprop="description" content="<?php echo e(Config::get('siteSetting.description')); ?>">
    <meta itemprop="image" content="<?php echo e(asset('upload/images/'.Config::get('siteSetting.meta_image'))); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?php echo e(Config::get('siteSetting.title')); ?>">
    <meta name="twitter:title" content="<?php echo e(Config::get('siteSetting.title')); ?>">
    <meta name="twitter:description" content="<?php echo e(Config::get('siteSetting.description')); ?>">
    <meta name="twitter:site" content="<?php echo e(url('/')); ?>">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="<?php echo e(asset('upload/images/'.Config::get('siteSetting.meta_image'))); ?>">
    <meta name="twitter:player" content="#">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('frontend')); ?>/css/custom/index.css">
    <style type="text/css">
        .homepage .container{padding: 10px;}
        .category .suggest-card {min-width: 120px;}
        .contentArea{margin: 0;}
        .search-btn{display: none;}
        .header-form{display: block;}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
    $get_ads = App\Models\Addvertisement::whereIn('page', ['homepage', 'all'])->inRandomOrder()->where('status', 1)->get();

    $topOfContent = $middleOfContent = $bottomOfContent = $sitebarTop = $sitebarMiddle = $sitebarBottom = null ;
    foreach ($get_ads as $ads){
        if($ads->position == 'top-content'){
            $topOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }elseif($ads->position == 'middle-content'){
            $middleOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }elseif($ads->position == 'bottom-content'){
            $bottomOfContent = ($ads->adsType == 'image') ? '<a  href="'.$ads->redirect_url.'"><img src="'.asset('upload/marketing/'.$ads->image).'" alt=""></a>' : $ads->add_code;
        }else{
            echo '';
        }
    }
    ?>
    <!--=====================================
                BANNER PART START
    =======================================-->
    <?php if($slider): ?>
    <section class="banner-part" style="background: url(<?php echo e(asset('upload/images/slider/'.$slider->photo)); ?>) no-repeat 50% 50%;">
        <div class="container">
            <div class="banner-content">
                <h1><?php echo e($slider->title); ?></h1>
                <p><?php echo e($slider->subtitle); ?></p>
                <?php if($slider->btn_text): ?>
                <a href="<?php echo e($slider->btn_link); ?>" class="btn btn-outline">
                    <i class="fas fa-eye"></i>
                    <span><?php echo e($slider->btn_text); ?></span>
                </a><?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <div class="container advertising">
        <?php echo $topOfContent; ?>

    </div>
    <div class="homepage" >
        <div id="loadProducts">
            <!-- Load products here -->
        </div>
        <div class="ajax-load  text-center" id="data-loader"><img src="<?php echo e(asset('frontend/images/loading.gif')); ?>"></div>
    </div>
    <div class="container advertising">
        <?php echo $bottomOfContent; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        var page = 1;
        loadMoreProducts(page);
        function loadMoreProducts(page){
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
            .done(function(data)
            {
                $('.ajax-load').hide();
                $("#loadProducts").append(data.html);

                //check section last page
                if(page <= '<?php echo e($sections->lastPage()); ?>' ){
                    page++;
                    loadMoreProducts(page);
                }
                 
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                $('.ajax-load').hide();
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/home.blade.php ENDPATH**/ ?>