
<?php $__env->startSection('title', $page->title . ' | '. Config::get('siteSetting.site_name') ); ?>

<?php $__env->startSection('metatag'); ?>
    <meta name="title" content="<?php echo e($page->meta_title); ?>">
    <meta name="description" content="<?php echo e($page->meta_description); ?>">
    <meta name="keywords" content="<?php echo e($page->meta_keywords); ?>" />
    
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:description" content="<?php echo e($page->title); ?>">
    <meta property="og:description" content="<?php echo e($page->meta_title); ?>">
    <meta property="og:image" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">
    <meta property="og:url" content="<?php echo e(url()->full()); ?>">
    <meta property="og:site_name" content="<?php echo e(Config::get('siteSetting.site_name')); ?>">
    <meta property="og:locale" content="en">
    <meta property="og:type" content="website">
    <meta property="fb:admins" content="1323213265465">
    <meta property="fb:app_id" content="13212465454">
    <meta property="og:type" content="e-commerce">

    <!-- Schema.org for Google -->

    <meta itemprop="title" content="<?php echo e($page->meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($page->meta_title); ?>">
    <meta itemprop="image" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:title" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:description" content="<?php echo e($page->meta_title); ?>">
    <meta name="twitter:site" content="<?php echo e(url('/')); ?>">
    <meta name="twitter:creator" content="@Neyamul">
    <meta name="twitter:image:src" content="<?php echo e(asset('upload/pages/'.$page->meta_image)); ?>">
  
    <!-- Twitter - Product (e-commerce) -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style type="text/css">


.accordion {
  
  padding: 1.2rem 0;
  border-radius: 1rem;
  background: white;
/*   box-shadow: 0 0 5rem lightgrey; */
}

.accordion__heading {
  text-align: center;
  padding: 0;
}

.accordion__item:not(:last-child) {
  border-bottom: 1px solid lightgrey;
}

.accordion__btn {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 10px 0px;
  background: white;
  border: none;
  outline: none;
  color: var(--color-text);
  font-size: 1rem;
  text-align: left;
  cursor: pointer;
  transition: 0.1s;
}
.accordion__btn:hover {
  color: var(--color-purple);
  background: hsl(248, 53%, 97%);
}

.accordion__item--active .accordion__btn {
  color: var(--color-purple);
  border-bottom: 2px solid var(--color-purple);
  background: hsl(248, 53%, 97%);
}


.accordion__icon {
  border-radius: 50%;
  transform: rotate(0deg);
  transition: 0.3s ease-in-out;
  opacity: 0.9;
}
.accordion__item--active .accordion__icon {
  transform: rotate(135deg);
}

.accordion__content {
  font-weight: 300;
  max-height: 0;
  opacity: 0;
  overflow: hidden;
  color: var(--color-text-muted);
  transform: translateX(16px);
  transition: max-height 0.5s ease, opacity 0.5s, transform 0.5s;
  padding: 5px;
}

.accordion__item--active .accordion__content {
  opacity: 1;
  transform: translateX(0px);
  max-height: 100vh;
}

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container" >
  
        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="accordion" style="padding:15px">
                  <div class="accordion__heading">
                    <?php echo $page->description; ?>

                  </div>
                  <?php $faqs = App\Models\Faq::where('status', 1)->get(); ?>
                  <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="accordion__item">
                    <button class="accordion__btn">

                      <span class="accordion__caption"><?php echo e($index+1); ?>. <?php echo e($faq->question); ?></span>
                      <span class="accordion__icon"><i class="fa fa-plus"></i></span>
                    </button>

                    <div class="accordion__content">
                      <?php echo $faq->answer; ?>

                    </div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                </div>
            </div>
        </div>
    </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script type="text/javascript">
    // select all accordion items
const accItems = document.querySelectorAll(".accordion__item");

// add a click event for all items
accItems.forEach((acc) => acc.addEventListener("click", toggleAcc));

function toggleAcc() {
  // remove active class from all items exept the current item (this)
  accItems.forEach((item) => item != this ? item.classList.remove("accordion__item--active") : null
  );

  // toggle active class on current item
  if (this.classList != "accordion__item--active") {
    this.classList.toggle("accordion__item--active");
  }
}

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/frontend/pages/faq.blade.php ENDPATH**/ ?>