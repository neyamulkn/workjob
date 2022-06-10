<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackagePurchase;
use App\Models\Notification;

use App\Traits\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Toastr;
class PurchasePackageController extends Controller
{
    use Sms;
    //get all package by user id
    public function packageHistory(Request $request, $status='')
    {
        //check role permission
        $data['permission'] = $this->checkPermission('purchase-package');
        if(!$data['permission'] || !$data['permission']['is_view']){ return back(); }
        
        $packages = PackagePurchase::with(['get_package', 'get_category'])
            ->leftJoin('users', 'package_purchases.user_id', 'users.id')
            ->where('package_purchases.payment_method', '!=', 'pending');
        if($request->package_id){
            $packages->where('package_purchases.package_id', $request->package_id);
        }
        if($request->status && $request->status != 'all'){
            $packages->where('payment_status', $request->status);
        }if($request->payment){
            $packages->where('package_purchases.payment_method', $request->payment);
        }
        
        if($request->customer){
            $keyword = $request->customer;
            $packages->where(function ($query) use ($keyword) {
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
                $query->orWhere('users.mobile', 'like', '%' . $keyword . '%');
                $query->orWhere('users.email', 'like', '%' . $keyword . '%');
            });
        }
       
        if($request->from_date){
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d')." 00:00:00";
            $packages = $packages->whereDate('order_date', '>=', $from_date);
        }if($request->end_date){
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d')." 23:59:59";
            $packages = $packages->whereDate('order_date', '<=', $request->end_date);
        }
       
        $data['packages'] = $packages->orderBy('package_purchases.id', 'desc')->selectRaw('package_purchases.*,users.name as customer_name,username,users.mobile')->paginate(15);

        return view('admin.package.purchasePackages')->with($data);
    }

    //show package details by package id
    public function showpackageDetails($packageId){

        $data['package'] = PackagePurchase::where('package_id', $packageId)->first();
        if($data['package']){
            return view('admin.package.package-details')->with($data);
        }
        return false;
    }

    //show package details by package id
    public function packageInvoice($packageId){
        $package = PackagePurchase::with(['package_details.product:id,title,slug,feature_image'])
            ->where('package_id', $packageId)->first();
        if($package){
            return view('admin.package.invoice')->with(compact('package'));
        }
        return view('404');
    }

     // change payment Status function
    public function changePaymentStatus(Request $request){

        $user_id = Auth::guard('admin')->id();
        $order = PackagePurchase::where('order_id', $request->order_id)->first();
        if($order){

            $order->payment_status = $request->payment_status;
            $order->save();
            Toastr::success('Payment status ' . str_replace('-', ' ', $request->payment_status) . ' successful.');

            //insert notification in database
            Notification::create([
                'type' => 'package',
                'fromUser' => null,
                'toUser' => $order->user_id,
                'item_id' => $request->order_id,
                'notify' => 'Your package purchase payment successfully '. $request->payment_status,
            ]);
        }else{
            Toastr::error('Payment status update failed.!');
        }
        return back();
    }

    public function packagePaymentDetails($orderId){

        $order = PackagePurchase::where('order_id', $orderId)->first();
        if($order){
            return view('admin.package.paymentCheckModal')->with(compact('order'));
        }
    }
    

}
