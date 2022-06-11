<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use App\Models\Notification;
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
    //deposit payment gatways
    public function depositHistory(){
        $user_id = Auth::id();
        $deposits = Deposit::where('user_id', $user_id)->paginate(25);
        return view('users.deposit.deposit-history')->with(compact('deposits'));
    }


    public function depositBalance()
    {
        $data['paymentgateways'] = PaymentGateway::orderBy('position', 'asc')->where('method_for', '!=', 'payment')->where('status', 1)->get();

        return view('users.deposit.deposit')->with($data);
    }

    //deposit payment
    public function depositPayment(Request $request)
    {

        $user_id = Auth::id();
        $deposit = new Deposit();
        $deposit->user_id = $user_id;
        $deposit->amount = $request->amount;
        $deposit->payment_method = $request->payment_method;
        $deposit->payment_info = $request->payment_info;
        $deposit->status = 'pending';
        $deposit->save();

        if($deposit){
            $total_price = $request->amount;;

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
                return redirect()->route('userDeposit')->with('success', 'Your deposit has been successfully completed.');
            }
        }
        Toastr::error('Sorry deposit payment failed.');
        return redirect()->route('userDeposit')->with('error', 'Sorry deposit payment failed.');
    }
}
