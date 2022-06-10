<?php

namespace App\Http\Controllers;

use App\Models\PackagePurchase;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Package;
use App\Models\PromoteAds;
use App\Models\PackageValue;
use App\Models\PaymentGateway;
use App\Models\Notification;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use Session;
use Carbon\Carbon;
use App\Traits\Sms;
use App\Traits\CreateSlug;
class PackagePurchaseController extends Controller
{
    use Sms;
    use CreateSlug;
     public function index(Request $request)
    {
        if($request->category || $request->package){
            $data['packageType'] = Package::where('slug', $request->package)->first();
            $data['packageValues'] = PackageValue::where('ads', '>', 1)->where('package_id', $data['packageType']->id)->where('category_id', $request->category)->get();

            return view('frontend.package.package')->with($data);
        }else{
            $data['packages'] = Package::orderBy('id', 'desc')->get();
            $data['get_categories'] = Category::where('parent_id', '=' , null)->orderBy('name', 'asc')->get();
        }
        return view('frontend.package.package-type')->with($data);
    }

    public function packagePurchase(Request $request, $id){

        $package = PackageValue::where('id', $id)->first();

        if($package){
            $user_id = Auth::id();

            $selling_price = $package->price;
            $discount = ($package->discount) ? $package->discount : null;
            $discount_type = '%';
            if($discount){
                $calculate_discount = HelperController::calculate_discount($selling_price, $discount, $discount_type );
            }
            $total_price = round($discount ? $calculate_discount['price'] : $selling_price);
            $order_id = $this->uniqueOrderId('package_purchases', 'order_id', 'R');

            $order = new PackagePurchase();
            $order->order_id = $order_id;
            $order->user_id = $user_id;
            $order->category_id = $package->category_id;
            $order->package_id = $package->package_id;
            $order->total_ads = $package->ads;
            $order->remaining_ads = $package->ads;
            $order->duration = $package->duration;
            $order->price = $total_price;
            $order->currency = config('siteSetting.currency');
            $order->currency_sign = config('siteSetting.currency_symble');
            $order->payment_method = 'pending';
            $order->save();
            //redirect payment method page for payment
            return redirect()->route('packagePurchasePaymentGateway', $order_id);
        }
        Toastr::error('Package not found.');
        return redirect()->back();
    }

    public function packagePurchasePaymentGateway($orderId){
        $data['package'] = PackagePurchase::with(['get_package:id,name','get_boostAd'])
            ->where('user_id', Auth::id())
            ->where('order_id', $orderId)->first();
         
        if($data['package']){
            $data['paymentgateways'] = PaymentGateway::orderBy('position', 'asc')->where('method_for', '!=', 'payment')->where('status', 1)->get();
            return view('frontend.package.packagePurchasePaymentGateway')->with($data);
        }
        Toastr::error('Package not found.');
        return back();
    }


    // process payment gateway & redirect specific gateway
    public function packagePurchasePayment(Request $request, $id){
      
        $user_id = Auth::id();
        $package = PackagePurchase::where('order_id', $id)->where('user_id', $user_id)->first();
        if($package){
            $total_price = $package->price;

            $data = [
                'order_id' => $package->order_id,
                'total_price' => $total_price,
                'currency' => $package->currency,
                'payment_method' => $request->payment_method
            ];
            Session::put('payment_data', $data);
        }else{
            Toastr::error('Payment failed.');
            return redirect()->back();
        }

        if($request->payment_method == 'cash-on-delivery'){
            Session::put('payment_data.status', 'success');
            //redirect payment success method
            return $this->paymentSuccess();
        }elseif($request->payment_method == 'wallet-balance'){
            if(Auth::user()->wallet_balance >= $total_price) {
            
                //minuse wallet balance;
                $user = User::find($order->user_id);
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
        }elseif($request->payment_method == 'reward-points'){
            $reward_points = (Auth::user()->reward_points > 0 ) ? Auth::user()->reward_points/2 : 0.00;
            if($reward_points >= $total_price) {
                //minuse reward points balance;
                $user = User::find($order->user_id);
                $user->reward_points = $user->reward_points - $total_price;
                $user->save();
            
                Session::put('payment_data.status', 'success');
                Session::put('payment_data.payment_status', 'paid');
                //redirect payment success method
                return $this->paymentSuccess();
            }else{
                Toastr::error('Insufficient wallet balance.');
                return redirect()->back();
            }
        }
        elseif($request->payment_method == 'sslcommerz'){
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
            $checkTrnx = PackagePurchase::where('tnx_id', $trnx_id)->first();
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
            $purchasePackage = PackagePurchase::where('order_id', $payment_data['order_id'])->first();
            if ($purchasePackage) {
                $user_id = $purchasePackage->user_id;
                $purchasePackage->payment_method = $payment_data['payment_method'];
                $purchasePackage->tnx_id = (isset($payment_data['trnx_id'])) ? $payment_data['trnx_id'] : null;
                $purchasePackage->order_date = now();
                $purchasePackage->payment_status = (isset($payment_data['payment_status'])) ? $payment_data['payment_status'] : 'pending';
                $purchasePackage->payment_info = (isset($payment_data['payment_info'])) ? $payment_data['payment_info'] : null;
                $purchasePackage->save();


                //check whether post direct promote
                if($purchasePackage->purchase_for && $purchasePackage->payment_status == 'paid'){
                    $start_date = Carbon::now();
                    $end_date = Carbon::now()->addDays($purchasePackage->duration);

                    $promoteAds = new PromoteAds();
                    $promoteAds->category_id = $purchasePackage->category_id;
                    $promoteAds->user_id = $user_id;
                    $promoteAds->package_id = $purchasePackage->package_id;
                    $promoteAds->order_id = $purchasePackage->order_id;
                    $promoteAds->ads_id = $purchasePackage->purchase_for;
                    $promoteAds->duration = $purchasePackage->duration;
                    $promoteAds->start_date = $start_date;
                    $promoteAds->end_date = $end_date;
                    $promoteAds->status = 1;
                    $promote = $promoteAds->save();
                    //update post status
                    $post = Product::find($purchasePackage->purchase_for);
                    $post->status = ($post->status == 'Not posted' || $post->status == 'draft') ? 'pending' : $post->status;
                    $post->save();

                    //decrement user purchase remaining ads
                    if($promote){ $purchasePackage->decrement('remaining_ads'); }
                }

            
                //send mobile notify
                $customer_mobile = Auth::user()->mobile;
                $msg = 'Dear customer, Your package has been successfully purchase.';
                $this->sendSms($customer_mobile, $msg);

               
                //insert notification in database
                Notification::create([
                    'type' => 'purchase',
                    'fromUser' => Auth::id(),
                    'toUser' => null,
                    'item_id' => $payment_data['order_id'],
                    'notify' => 'Package purchase',
                ]);
                Toastr::success('Your package has been successfully purchase.');
                return redirect()->route('user.packageHistory')->with('success', 'Your package has been successfully purchase.');
            }
        }
        Toastr::error('Sorry package purchase failed.');
        return redirect()->route('user.packageHistory')->with('error', 'Sorry package purchase failed.');
    }

    //get all package purchase by user id
    public function packagePurchaseHistory(Request $request)
    {
        $orders = PackagePurchase::with(['get_package', 'get_category'])->where('payment_method', '!=', 'pending')->where('user_id', Auth::id());
        if($request->status && $request->status != 'all'){
            $orders->where('payment_status', $request->status);
        }
        $data['orders'] = $orders->orderBy('id', 'desc')->paginate(16);

        return view('users.package-purchase-history')->with($data);
    }

}
