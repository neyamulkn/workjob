
<?php $__env->startSection('title', 'Wallet History | '. Config::get('siteSetting.site_name') ); ?>
<?php $__env->startSection('css'); ?>
   	<link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <style type="text/css">
    #content .card{border-radius: 5px; border: 1px solid #ccc;margin-bottom: 5px;}
    	.form-group { margin-bottom: 5px; }
    .icon-box i{font-size: 4rem}
    .ml-auto, .mx-auto {
        margin-left: auto!important;
    }
    .label-default{background: #fff;}
    .user-box{padding: 10px; text-align: center;   margin-bottom: 10px;}
    .card-title, .icon-box{color: #000}
    .user-box a{    font-size: 2rem !important; color: #000}
    #user-dashboard{padding-top: 15px;}
    #user-dashboard section{background: #fff;margin-bottom: 10px;padding: 10px 0;}
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
	                <h4 class="text-themecolor">Job lists</h4>
	            </div>
	            <div class="col-md-7 align-self-center text-right">
	                <div class="d-flex justify-content-end align-items-center">
	                    <ol class="breadcrumb">
	                        <li class="breadcrumb-item"><a href="javascript:void(0)">Job</a></li>
	                        <li class="breadcrumb-item active">lists</li>
	                    </ol>
	                    <a href="<?php echo e(route('post.create')); ?>" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
	                </div>
	            </div>
	        </div>
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
					
					<section class="row">
			            <div class="col-md-3 col-xs-6">
			                <div class="card label-default">
			                    <div class="user-box">
			                        <div class="d-flex   no-block align-items-center">
			                            <a href="<?php echo e(route('user.walletHistory')); ?>" class="link ml-auto"><?php echo e(config('siteSetting.currency_symble') . Auth::user()->wallet_balance); ?></a>
			                        </div>
			                        <h5 class="card-title">Current Balance</h5> 
			                    </div>
			                </div>
			            </div>
			            <div class="col-md-3 col-xs-6">
			                <div class="card label-default">
			                    <div class="user-box">
			                        <div class="d-flex  no-block align-items-center">
			                            <a href="<?php echo e(route('user.walletHistory')); ?>/?withdraw=pending" class="link ml-auto"><?php echo e(config('siteSetting.currency_symble') . $wallets->where('type', 'withdraw')->whereIn('status', ['pending','accepted'])->sum('amount')); ?></a>
			                            
			                        </div>
			                        <h5 class="card-title">Pending withdrawal</h5> 
			                    </div>
			                </div>
			            </div>
			            <div class="col-md-3 col-xs-6">
			                <div class="card label-default">
			                    <div class="user-box">
			                        <div class="d-flex   no-block align-items-center">
			                            <a href="<?php echo e(route('user.walletHistory')); ?>/?withdraw=paid" class="link ml-auto"><?php echo e(config('siteSetting.currency_symble') . $wallets->where('type', 'withdraw')->where('status', 'paid')->sum('amount')); ?></a>
			                        </div>
			                        <h5 class="card-title">Total withdraw</h5> 
			                    </div>
			                </div>
			            </div>
			            
			            <?php if($withdraw_configure): ?>
			            <div class="col-md-3 col-xs-6">
			                <div class="card label-info" style="cursor: pointer;">
			                    <div class="user-box" data-toggle="modal" data-target="#withdraw_request">
			                        <div class="d-flex no-block align-items-center">
			                            <a href="javascript:void(0)" class="link ml-auto"><i class="fa fa-reply-all"></i></a>
			                        </div>
			                         <h5 class="card-title">Send Withdraw Request</h5> 
			                    </div>
			                </div>
			            </div>
			            <?php endif; ?>
			        </section>
			<div class="card">
                 <div class="card-body">	
					
			      	<h4>Wallet history</h4>
					<div class="table-responsive" style="background: #fff;padding: 5px;">
						<table  id="config-table" style="width: 100%" class="table display table-bordered table-striped no-wrap">
							<thead>
								<tr>
									<td class="text-left">SL</td>
									<td class="text-left">Date</td>
									<td class="text-left">Type</td>
									<td class="text-left">Amount</td>
									<td class="text-left">Commission</td>
									<td class="text-left">Payment Info</td>
									<td class="text-center">Status</td>
								</tr>
							</thead>
							<tbody>
								
								<?php if(count($wallets)>0): ?>
							        <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							        <tr>
							        	<td><?php echo e($index+1); ?></td>
							           	<td><?php echo e(\Carbon\Carbon::parse($wallet->created_at)->format(Config::get('siteSetting.date_format'))); ?>

							           (<?php echo e(\Carbon\Carbon::parse($wallet->created_at)->format('h:i:s A')); ?>)
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
							            <td><span class="label label-info">Pay Method: <?php echo e(($wallet->paymentGateway) ?  $wallet->paymentGateway->method_name : $wallet->payment_method); ?></span><br/>
	                                   
	                                    <?php if($wallet->account_no): ?> <?php echo e($wallet->account_no); ?> <br/> <?php endif; ?> 
	                                    <?php if($wallet->transaction_details): ?>  <?php echo e($wallet->transaction_details); ?> <?php endif; ?>
	                                    </td>
							           	
							            <td><?php if($wallet->status == 'paid'): ?> <span class="label label-success"> <?php echo e($wallet->status); ?></span> <?php elseif($wallet->status == 'received'): ?> <span class="label label-primary"> <?php echo e($wallet->status); ?> </span> <?php elseif($wallet->status == 'cancel'): ?> <span class="label label-danger"> <?php echo e($wallet->status); ?> </span> <?php else: ?> <span class="label label-warning"> <?php echo e($wallet->status); ?> </span> <?php endif; ?></td>
							        </tr>
							       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							    <?php endif; ?>
								
							</tbody>
						</table>
					</div>

				</div>
				<!--Middle Part End-->
				
			</div>
		</div>
	</div>
	<!-- //Main Container -->
	<?php if($withdraw_configure): ?>
	<!-- withdraw request Modal -->
	<div class="modal fade" id="withdraw_request" role="dialog" style="display: none;">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Withdraw Request</h4>
                    <button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                	
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
	                
                    <div class="card-body">
                    	<?php if(Auth::user()->wallet_balance >= $withdraw_configure->value2): ?>
                        <form action="<?php echo e(route('user.withdraw_request')); ?>" method="POST" data-parsley-validate>
                            <?php echo e(csrf_field()); ?>

                            <div class="form-body">
                               
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="method_name">Withdraw Amount</label>
                                            <input required="" name="amount" min="<?php echo e($withdraw_configure->value2); ?>" id="amount" value="<?php echo e(old('amount')); ?>" type="number" placeholder="Example <?php echo e(Config::get('siteSetting.currency_symble'). $withdraw_configure->value2); ?>" class="form-control">
                                             <i style="color: red">Minimun withdraw amount <?php echo e(Config::get('siteSetting.currency_symble'). $withdraw_configure->value2); ?></i>
                                            <?php if($errors->has('amount')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?php echo e($errors->first('amount')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="payment_method">Withdrawal Method</label>
                                            <select id="payment_method" name="payment_method" required="" class="form-control select2 m-b-10" style="width: 100%" >
                                                <option value="">Select Withdrawal Method</option>
                                             <?php $__currentLoopData = $paymentGateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentgateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if(old('payment_method') == $paymentgateway->id): ?> selected <?php endif; ?> value="<?php echo e($paymentgateway->id); ?>"><?php echo e($paymentgateway->method_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                             <?php if($errors->has('payment_method')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?php echo e($errors->first('payment_method')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="AccountNumber">
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="details">Notes</label>
                                            <textarea rows="1" name="notes" id="notes"  style="resize: vertical;" placeholder="Write your notes" class="form-control"><?php echo e(old('notes')); ?></textarea>
                                        </div>
                                    </div>
                                 	<div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="password">Password</label>
                                            <input type="password" required name="password" id="password"  placeholder="Enter password" autocomplete="false" class="form-control">
                                             <?php if($errors->has('password')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?php echo e($errors->first('password')); ?>

                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12"><label style="line-height: 1" for="agree">
                                    	<input type="checkbox" id="agree" required name="agree"> If you withdraw wallet balance,  <?php echo e($withdraw_configure->value); ?>% commission will be deducted.</label> 
                                        <div class="modal-footer">
                                            <button type="submit" name="submitType" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Send Request</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <p style="color: red">Insufficent your wallet balance</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>		
<?php $__env->startSection('js'); ?>
   	<script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

     <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
            ordering: false,

        });

        $("#payment_method").change(function(){
        	var account_no = '';
        	if(this.value){
	        	var method_name = $("#payment_method option:selected").text();
	        	account_no =  `<div class="form-group">
	                <label class="required" for="account_no">`+ method_name+` account number</label>
	                <input type="text" value="<?php echo e(old('account_no')); ?>" required name="account_no" id="account_no"  placeholder="Enter account number" class="form-control">
	                 <?php if($errors->has('account_no')): ?>
	                <span class="invalid-feedback" role="alert">
	                    <?php echo e($errors->first('account_no')); ?>

	                </span>
	                <?php endif; ?>
	            </div>`;
	        }
	        document.getElementById('AccountNumber').innerHTML = account_no;
        });
    </script>
<?php $__env->stopSection(); ?>		



<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH H:\xmapp\htdocs\workupjob\resources\views/users/wallet/wallet.blade.php ENDPATH**/ ?>