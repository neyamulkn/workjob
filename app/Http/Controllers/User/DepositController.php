<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\User;
use App\Models\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use Session;
use Carbon\Carbon;
use App\Traits\Sms;
use App\Traits\CreateSlug;
class DepositController extends Controller
{
    use Sms;
    use CreateSlug;
    
    // admin deposit history
    public function adminDepositHistory(){
        $deposits = Deposit::orderBy('id', 'desc')->paginate(25);
        return view('admin.deposit.deposit-history')->with(compact('deposits'));
    }
    
    public function depositPaymentDetails($id){

        $deposit = Deposit::where('id', $id)->first();
        if($deposit){
            return view('admin.deposit.paymentCheckModal')->with(compact('deposit'));
        }
    }

    // change deposit payment Status
    public function depositPaymentUpdate(Request $request){

        $user_id = Auth::guard('admin')->id();
        $deposit = Deposit::where('id', $request->deposit_id)->first();
        if($deposit){

            
            Toastr::success('Payment status ' . str_replace('-', ' ', $request->payment_status) . ' successful.');
            if($deposit->payment_status != 'paid' && $request->payment_status == 'paid'){

                //insert user transaction
                $transaction = new Transaction();
                $transaction->type = 'deposit';
                $transaction->item_id = $deposit->id;
                $transaction->payment_method = $deposit->payment_method;
                $transaction->amount = $deposit->amount;
                $transaction->transaction_details = $deposit->payment_info .'<br>'. $deposit->tnx_id;
                $transaction->notes = 'Deposit balance added.';
                $transaction->customer_id = $deposit->user_id;
                $transaction->seller_id = Auth::id();
                $transaction->created_by = $user_id;
                $transaction->status = 'paid';
                $transaction->save();

                //update user wallet balance
                $user = $deposit->user;
                $user->deposit_balance = $user->deposit_balance + $deposit->amount;
                $user->save();

                $notify = 'Your deposit has been accepted';
            }elseif($request->status == 'reject'){
                $notify = 'Deposit has been rejected.';
            }else{
                $notify = 'Deposit has been '.$request->status;
            }
            
            $deposit->payment_status = $request->payment_status;
            $deposit->status = $request->payment_status;
            $deposit->save();
            
            //insert notification in database
            Notification::create([
                'type' => 'deposit',
                'fromUser' => null,
                'toUser' => $deposit->user_id,
                'item_id' => $request->deposit_id,
                'notify' => 'Your deposit payment successfully '. $request->payment_status,
            ]);
        }else{
            Toastr::error('Payment status update failed.!');
        }
        return back();
    }


    // user deposit history
    public function depositHistory(){
        $user_id = Auth::id();
        $deposits = Deposit::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(25);
        return view('users.deposit.deposit-history')->with(compact('deposits'));
    }


    //deposit payment gatways
    public function depositBalance()
    {
        $data['paymentgateways'] = PaymentGateway::orderBy('position', 'asc')->where('method_for', '!=', 'payment')->where('status', 1)->get();

        return view('users.deposit.deposit')->with($data);
    }

    //deposit payment
    public function depositPayment(Request $request)
    {

        $deposit_config = SiteSetting::where('type', 'discount_config')->first();

        if($request->amount < $deposit_config->value2){
            Toastr::error('Minimum deposit amount '. config('siteSetting.currency_symble') . $deposit_config->value2);
            return redirect()->back()->withInput()->with('error', 'Minimum deposit amount '. config('siteSetting.currency_symble') . $deposit_config->value2);
        }

        $commission = ($request->amount * $deposit_config->value) / 100;

        $user_id = Auth::id();
        $deposit = new Deposit();
        $deposit->user_id = $user_id;
        $deposit->amount = $request->amount;
        $deposit->commission = $commission;
        $deposit->payment_method = $request->payment_method;
        $deposit->payment_info = $request->payment_info;
        $deposit->status = 'pending';
        $deposit->save();

        if($deposit){
            $total_price = $request->amount;

            $data = [
                'deposit_id' => $deposit->id,
                'total_price' => $total_price,
                'currency_symble' => config('siteSetting.currency_symble'),
                'payment_method' => $request->payment_method
            ];
            Session::put('payment_data', $data);
        }else{
            Toastr::error('Payment failed.');
            return redirect()->back();
        }

        if($request->payment_method == 'wallet-balance'){
            if(Auth::user()->wallet_balance >= $total_price) {
            
                //minuse wallet balance;
                $user = User::find($user_id);
                $user->wallet_balance = $user->wallet_balance - $total_price;
                $user->save();
            
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.payment_status', 'paid');
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('Insufficient wallet balance.');
                return redirect()->back();
            }
        }elseif($request->payment_method == 'sslcommerz'){
            //redirect SslCommerzPaymentController for payment process
            $sslcommerz = new SslCommerzPaymentController;
            return $sslcommerz->sslCommerzPayment();
        }elseif($request->payment_method == 'nagad'){
            //redirect PaypalController for payment process
            $nagad = new NagadPaymentController;
            return $nagad->nagadPayment();
        }elseif($request->payment_method == 'shurjopay'){
            //redirect shurjopayController for payment process
            $shurjopay = new ShurjopayController();
            return $shurjopay->shurjopayPayment();
        }elseif($request->payment_method == 'paypal'){
            //redirect PaypalController for payment process
            $paypal = new PaypalController;
            return $paypal->paypalPayment();
        }
        elseif($request->payment_method == 'masterCard'){
            //redirect StripeController for payment process
            Session::put('payment_data.stripeToken', $request->stripeToken);
            $stripe = new StripeController();
            return $stripe->masterCardPayment();
        }
        elseif($request->payment_method == 'manual'){
            $trnx_id = ($request->manual_method_name == 'cash') ? 'cash'.rand(000, 999) : $request->trnx_id;
            $checkTrnx = Deposit::where('tnx_id', $trnx_id)->first();
            if(!$checkTrnx){
                Session::put('payment_data.payment_method', $request->manual_method_name);
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.trnx_id', $request->trnx_id);
                Session::put('payment_data.payment_info', $request->payment_info);
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('This transaction is invalid.');
                return redirect()->back()->withInput()->with('error', 'This transaction is invalid.');
            }
        }else{
            Toastr::error('Please select payment method');
        }
        return back();
    }

    //payment status success then update payment status
    public function paymentSuccess(){

        $payment_data = Session::get('payment_data');
        //clear session payment data
        //Session::forget('payment_data');
        if($payment_data && $payment_data['status'] == 'success') {
            $deposit = Deposit::where('id', $payment_data['deposit_id'])->first();
            if ($deposit) {
                $user_id = $deposit->user_id;
                $deposit->payment_method = $payment_data['payment_method'];
                $deposit->tnx_id = (isset($payment_data['trnx_id'])) ? $payment_data['trnx_id'] : null;
              
                $deposit->payment_status = (isset($payment_data['payment_status'])) ? $payment_data['payment_status'] : 'pending';
                $deposit->payment_info = (isset($payment_data['payment_info'])) ? $payment_data['payment_info'] : null;
                $deposit->save();


                //check whether post direct promote
                if($deposit->payment_status == 'paid'){
                    $user = User::find($user_id);
                    $user->deposit_balance = $user->deposit_balance + $deposit->amount;
                    $user->save();
                }

                //send mobile notify
                $customer_mobile = Auth::user()->mobile;
                $msg = 'Dear customer, Your deposit has been successfully completed.';
                $this->sendSms($customer_mobile, $msg);

               
                //insert notification in database
                Notification::create([
                    'type' => 'deposit',
                    'fromUser' => Auth::id(),
                    'toUser' => null,
                    'item_id' => $payment_data['deposit_id'],
                    'notify' => 'Deposit payment',
                ]);
                Toastr::success('Your deposit has been successfully completed.');
                return redirect()->route('depositHistory')->with('success', 'Your deposit has been successfully completed.');
            }
        }
        Toastr::error('Sorry deposit payment failed.');
        return redirect()->route('depositHistory')->with('error', 'Sorry deposit payment failed.');
    }
}
