
<?php $__env->startSection('title', 'Deposit Balance'); ?>
<?php $__env->startSection('css'); ?>
<style type="text/css">
.progress{background-color: #dddedf;}
    .details{padding: 10px;}
    a.active{border: 1px solid #ddd; border-bottom: none; }
    .custom-checkbox{margin: 10px 0 5px;padding: 0;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                        <h4 class="text-themecolor">Deposit Balance</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Deposit</a></li>
                                <li class="breadcrumb-item active">Deposit</li>
                            </ol>
                            <a href="<?php echo e(route('depositHistory')); ?>" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Deposit Balance</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if(Session::has('success')): ?>
                                <div class="alert alert-success">
                                  <strong>Success! </strong> <?php echo e(Session::get('success')); ?>

                                </div>
                                <?php endif; ?>
                                <?php if(Session::has('error')): ?>
                                <div class="alert alert-danger">
                                  <strong>Error! </strong> <?php echo e(Session::get('error')); ?>

                                </div>
                                <?php endif; ?>
                                <h5>Select Payment Method</h5>
                                <div style="background: #fff; padding-bottom: 0 10px 10px;">
                                    <div class="box-inner">          
                                        <div id="process"></div>  
                                        <ul class="nav nav-tabs">
                                          <?php $__currentLoopData = $paymentgateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li ><a onclick="paymentGateway(<?php echo e($method->id); ?>)" <?php if($index == 0): ?> class="active" <?php endif; ?> style="display:block;padding: 10px;background: #fff;" data-toggle="tab" href="#paymentgateway<?php echo e($method->id); ?>"><img <?php if($method->method_slug == 'shurjopay'): ?> width = "190" height="45" <?php else: ?> width="90" <?php endif; ?> src="<?php echo e(asset('upload/images/payment/'.$method->method_logo)); ?>"></a></li>
                                        
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <div class="tab-content col-md-5" style="padding:10px">
                                            
                                            <label>Amount</label>
                                            <div class="wallet" id="wallet">
                                                <input type="number" name="amount" class="amount form-control" form="form<?php echo e($method->id); ?>">
                                            </div>
                                            <p style="color:#726a6a;">*Minimum Deposit $1</p>
                                            <?php $__currentLoopData = $paymentgateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                              <?php if($method->is_default == 1): ?>
                                              <div id="paymentgateway<?php echo e($method->id); ?>" class="tab-pane fade <?php if($index == 0): ?> active show <?php endif; ?>">
                                                  <form action="<?php echo e(route('depositPayment')); ?>" name="form<?php echo e($method->id); ?>" id="form<?php echo e($method->id); ?>" method="post" <?php if($method->method_slug == 'masterCard'): ?> class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo e($method->public_key); ?>"  <?php endif; ?> >
                                                      <?php echo csrf_field(); ?>
                                                      <input type="hidden"  name="payment_method" value="<?php echo e($method->method_slug); ?>">
                                                      
                                                      <?php echo $method->method_info; ?>

                                                      
                                                      <?php if($method->method_slug == 'wallet-balance'): ?>
                                                         Your wallet balance: <?php echo e(config('siteSetting.currency_symble').Auth::user()->wallet_balance); ?>

                                                      <?php endif; ?>

                                                      <?php if($method->method_slug == 'masterCard'): ?>
                                                        <div class="form-row">                                    
                                                            <div id="card-element" style="width: 100%">
                                                                 <div class="display-td" >                            
                                                                    <img class="img-responsive pull-right" src="https://i76.imgup.net/accepted_c22e0.png">
                                                                  </div>
                                                               
                                                                  <div class="row">
                                                                    <div class="col-lg-8 col-md-8">
                                                                    <div class='col-lg-12 col-md-12 col-xs-12 card '> <span class='control-label required'>Card Number</span> <input  autocomplete='off' placeholder='Enter card number' class='form-control card-number' required size='20' type='text'> </div> <div class='col-xs-3  cvc '> <span class='control-label required'>CVC</span> <input autocomplete='off' class='form-control card-cvc' maxlength="3" placeholder='ex. 311' required size='4' type='text'> </div> <div class='col-xs-4 expiration '> <span class='required control-label'>Month</span>  <input maxlength="2" required class='form-control card-expiry-month' placeholder='MM' size='2' type='text'> </div> <div class='col-xs-5 expiration '> <span class='control-label required'>Expiration Year</span> <input class='form-control card-expiry-year' placeholder='YYYY' required size='4' maxlength="4" type='text'> </div>
                                                                  </div>
                                                                </div>
                                          
                                                                <div class='row'>
                                                                    <div class='col-md-12 error form-group hide'>
                                                                        <div style="padding: 5px;margin-top: 10px;" class='alert-danger alert'>Please correct the errors and try again.</div>
                                                                    </div>
                                                                </div>          
                                                            </div>
                                                          <!-- Used to display Element errors. -->
                                                          <div id="card-errors" role="alert"></div>
                                                        </div>
                                                      <?php endif; ?>
                                                    
                                                    <div>
                                                    <?php if($method->method_slug == 'wallet-balance'): ?>
                                                        <?php if(Auth::user()->wallet_balance >= 0): ?>
                                                        <div class="custom-control custom-checkbox">
                                                              
                                                              <label class=""><input type="checkbox"class=""  required=""> I agree to all Terms of Service and all Policy.</label>
                                                              
                                                            </div>
                                                          <button  class="btn btn-block btn-dribbble payButton"><span><i class="fa fa-money" aria-hidden="true"></i> Pay with wallet balance </span></button>


                                                       
                                                        <?php else: ?>
                                                         <button title="Insufficient wallet balance" disabled  class="btn btn-block btn-dribbble payButton"><span><i class="fa fa-money" aria-hidden="true"></i> Insufficient wallet balance </span></button>
                                                        <?php endif; ?>
                                                      <?php else: ?>
                                                       

                                                    <div class="custom-control custom-checkbox">
                                                      
                                                      <label class=""><input type="checkbox" class=""  required=""> I agree to all Terms of Service and all Policy.</label>
                                                      
                                                    </div>
                                                    <button type="submit" name="payment_method" value="manual" class="btn btn-block btn-dribbble">Continue to payment</button> 
                                              
                                                      <?php endif; ?>
                                                      </div>
                                                  </form>
                                              </div>
                                              <?php else: ?>
                                              <div id="paymentgateway<?php echo e($method->id); ?>" class="tab-pane fade <?php if($index == 0): ?> active show <?php endif; ?>">
                                                
                                                <?php echo $method->method_info; ?>

                                                <form action="<?php echo e(route('depositPayment')); ?>" name="form<?php echo e($method->id); ?>" id="form<?php echo e($method->id); ?>" data-parsley-validate method="post">
                                                  <?php echo csrf_field(); ?>
                                                  <strong style="color: green;">Pay with <?php echo e($method->method_name); ?>.</strong><br/>
                                                  <input type="hidden"  name="manual_method_name" value="<?php echo e($method->method_slug); ?>">
                                                  <?php if($method->method_slug != 'cash'): ?>
                                                  <strong>Payment Transaction Id</strong>
                                                  <p><input type="text" required data-parsley-required-message = "Transaction Id is required" placeholder="Enter Transaction Id" value="<?php echo e(old('trnx_id')); ?>" class="form-control" name="trnx_id"></p>
                                                  <?php endif; ?>
                                                  <strong>Write Your <?php echo e($method->method_name); ?> Payment Information below.</strong>
                                                  <textarea required data-parsley-required-message = "Payment Information is required" name="payment_info" style="margin: 0;" rows="2" placeholder="Write Payment Information" class="form-control"><?php echo e(old('payment_info')); ?></textarea>
                                                  
                                                  <div class="custom-control custom-checkbox">
                                                      
                                                      <label class=""><input type="checkbox" class=""  required=""> I agree to all Terms of Service and all Policy.</label>
                                                      
                                                    </div>
                                                    <button type="submit" name="payment_method" value="manual" class="btn btn-block btn-dribbble">Continue to payment</button> 
                                              
                                                </form>
                                              </div>
                                              <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </div>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
    
    //Allow checkbox check/uncheck handle
    function paymentGateway(id){
    var amount = $('.amount').val();
    $("#wallet").html('<input type="number" class="amount form-control" style="padding: 0 7px;border: 1px solid #ccc;" form="form'+id+'" required placeholder="Enter amount" min="0" max="<?php echo e(Auth::user()->wallet_balance); ?>" value="<?php echo e(Auth::user()->wallet_balance); ?>" name="amount">');
        
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/deposit/deposit.blade.php ENDPATH**/ ?>