
<?php $__env->startSection('title', 'Wallet History'); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
        #Wallet_recharge p{padding:0; margin: 0;}
        #Wallet_recharge label{margin: 5px 0 ;}
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
                        <h4 class="text-themecolor">Wallet History</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">

                            <button data-toggle="modal" data-target="#Wallet_recharge" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Wallet Recharge</button>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
             
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Balance</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-purple"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto"><?php echo e(Config::get('siteSetting.currency_symble'). $totalBalance); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total withdraw</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto"><?php echo e(Config::get('siteSetting.currency_symble'). round($totalWithdraw,2)); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Available Wallet</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-donate"></i></span>
                                <a href="javscript:void(0)" class="link display-5 ml-auto"><?php echo e(Config::get('siteSetting.currency_symble'). ($totalBalance - $totalWithdraw)); ?></a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card" data-toggle="modal" data-target="#Wallet_recharge">
                        <div class="card-body " style="text-align: center;cursor: pointer;">
                            
                            <div class="align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-plus-circle"></i></span>
                            </div>
                            <h5 class="card-title">Wallet Recharge</h5>
                        </div>
                    </div>
                    </div>
                </div>


                <div class="row">
                   
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <div class="table-responsive">
                                       <table id="config-table" class="table display table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Commission</th>
                                                    <th>Payment Info</th>
                                                    <th>Notes</th>
                                                    <th>Added By</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php if(count($allWallets)>0): ?>
                                                <?php $__currentLoopData = $allWallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e((($allWallets->perPage() * $allWallets->currentPage() - $allWallets->perPage()) + ($index+1) )); ?></td>
                                                   <td>
                                                    <?php if($wallet->customer): ?><a title="View Customer Profile" data-toggle="tooltip" href="<?php echo e(route('customer.profile', $wallet->customer->username)); ?>"><?php echo e($wallet->customer->name); ?> </a><br/><?php endif; ?>
                                                    <?php echo e(\Carbon\Carbon::parse($wallet->created_at)->format(Config::get('siteSetting.date_format'))); ?>

                                                   (<?php echo e(\Carbon\Carbon::parse($wallet->created_at)->diffForHumans()); ?>)
                                                   </td>
                                                   <td><?php echo e($wallet->type); ?></td>
                                                    
                                                   
                                                    <td>
                                                     <?php if($wallet->amount<0 || $wallet->type == 'withdraw'): ?>  <span class="label label-danger">
                                                      - <?php echo e(Config::get('siteSetting.currency_symble').  str_replace('-', '', $wallet->amount)); ?></span>
                                                    <?php else: ?>
                                                    <span class="label label-info">
                                                       <?php echo e(Config::get('siteSetting.currency_symble'). str_replace('+', '', $wallet->amount)); ?></span>
                                                    <?php endif; ?>
                                                    </td>
                                                     <td><?php echo e(Config::get('siteSetting.currency_symble'). $wallet->commission); ?></td>
                                                     <td><?php if($wallet->paymentGateway): ?><?php echo e($wallet->paymentGateway->method_name); ?> 
                                                    <br/>
                                                    <?php else: ?>
                                                    <?php echo e($wallet->payment_method); ?>

                                                     <br/>
                                                    <?php endif; ?>
                                                   
                                                    <?php if($wallet->account_no): ?><?php echo e($wallet->account_no); ?>  <br/> <?php endif; ?>
                                                    <?php if($wallet->transaction_details): ?><?php echo e($wallet->transaction_details); ?> <?php endif; ?>
                                                    </td>
                                                     <td><?php echo e($wallet->notes); ?></td>
                                                     <td> <?php echo e(($wallet->addedBy) ? $wallet->addedBy->name : 'customer'); ?></td>
                                                   
                                                    <td><?php if($wallet->status == 'paid'): ?> <span class="label label-success"> <?php echo e($wallet->status); ?></span> <?php elseif($wallet->status == 'received'): ?> <span class="label label-primary"> <?php echo e($wallet->status); ?> </span> <?php elseif($wallet->status == 'cancel'): ?> <span class="label label-danger"> <?php echo e($wallet->status); ?> </span> <?php else: ?> <span class="label label-info"> <?php echo e($wallet->status); ?> </span> <?php endif; ?></td>
                                                </tr>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?> <tr><td colspan="8"> <h1>No Wallet found.</h1></td></tr><?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       <?php echo e($allWallets->appends(request()->query())->links()); ?>

                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing <?php echo e($allWallets->firstItem()); ?> to <?php echo e($allWallets->lastItem()); ?> of total <?php echo e($allWallets->total()); ?> entries (<?php echo e($allWallets->lastPage()); ?> Pages)</div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
    <!-- add Modal -->
        <div class="modal fade" id="Wallet_recharge" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Wallet Recharge</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="<?php echo e(route('customer.walletRecharge')); ?>" data-parsley-validate method="POST" >
                                <?php echo e(csrf_field()); ?>

                                <div class="form-body">
                                    <div class="row">
                                        
                                        <div class="col-md-8 col-10">
                                            <input value="<?php echo e(old('customer')); ?>" type="text" id="customer" class="form-control" name="customer" placeholder="Customer name or mobile or email">
                                            <span style="color: red" id="error"></span>
                                        </div>
                                        <div class="col-md-4 col-2">
                                            <div><button style="padding: 6px;" type="button" id="getCustomerDetails" class="btn btn-info"><i class="fa fa-search"></i> <span class="hidden-md-down"> Find Customer</span></button></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div id="showCustomerDetails"> </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

       
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('js'); ?>
    <script type="text/javascript">
        // get customer Details by search
       $('#getCustomerDetails').on('click', function(){
            var customer = $('#customer').val();

            $("#error").html('');
            if(customer != ''){
              
                $('#showCustomerDetails').html('<div class="loadingData"></div>');
                var  url = '<?php echo e(route("customer.walletInfo")); ?>';
                
                $.ajax({
                    url:url,
                    method:"get",
                    data:{customer:customer},
                    success:function(data){
                        
                        if(data){
                            $("#showCustomerDetails").html(data);
                           
                        }else{
                            $("#showCustomerDetails").html('<div style="color:red">Customer not found.</div>');
                        }
                    },
                    error: function(jqXHR, exception) {
                        toastr.error('Internal server error.');
                        $("#showCustomerDetails").html('<div style="color:red">Customer not found.</div>');
                }
                });
            }else{
                $("#error").html('This field is required');
                 $("#showCustomerDetails").html('');
            }
        });
    </script>
    <?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/admin/wallet/wallet.blade.php ENDPATH**/ ?>