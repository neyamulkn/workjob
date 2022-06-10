<?php

namespace App\Http\Controllers;

use App\Models\PromoteAds;
use App\Models\Product;
use App\Models\Package;
use App\Models\PackagePurchase;
use App\Models\PackageValue;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\CreateSlug;
use Carbon\Carbon;
use Auth;
class PromoteAdsController extends Controller
{

    use CreateSlug;
    //view ad promote package
    public function adsPromotePackage($adsSlug)
    {
        $user_id =  Auth::id();
        $post = Product::where('slug', $adsSlug)->where('user_id', $user_id)->first();
        if($post){
            $category_id = $post->category_id;
            $subcategory_id = $post->subcategory_id;

            $packageTypes = Package::with([
                    'get_packageVlues' => function($query) use ($category_id, $subcategory_id){
                        $query->whereIn('category_id', [$category_id,$subcategory_id ])->where('ads', 1)->where('status', 1);}, 

                    'get_purchasePackages' => function($query) use ($category_id, $subcategory_id){
                        $query->whereIn('category_id', [$category_id,$subcategory_id ])->where('remaining_ads', '>=', 1)->where('payment_status', 'paid')->where('user_id', Auth::id());}
                    ])->where('status', 1)->get();
            return view('users.post.promoteAds')->with(compact('packageTypes','post', 'adsSlug'));
        }
    }

    //ad promote or direct package payment 
    public function adsPromote(Request $request, $adsSlug)
    {
        $user_id = Auth::id();
        $post = Product::where('slug', $adsSlug)->where('user_id', $user_id)->first();

        if($post){

            if($request->package == 'free'){
                //update post status
                $post->status = ($post->status == 'Not posted' || $post->status == 'draft') ? 'pending' : $post->status;
                $post->save();
            }else{
                $package_id = $request->package;
                $category_id = ($post->subcategory_id) ? $post->subcategory_id : $post->category_id;

                //check whether user package purchase or new package
                if(is_array($request->purchasPackvalue) && array_key_exists($request->package, $request->purchasPackvalue)){
                    $packageValue_id = $request->purchasPackvalue[$request->package];

                    $purchasePackage = PackagePurchase::where('id', $packageValue_id)->where('package_id', $package_id)->where('remaining_ads', '>=', 1)->where('payment_status', 'paid')->where('user_id',  $user_id)->first();

                    $start_date = Carbon::now();
                    $end_date = Carbon::now()->addDays($purchasePackage->duration);

                    $promoteAds = new PromoteAds();
                    $promoteAds->category_id = $category_id;
                    $promoteAds->user_id = $user_id;
                    $promoteAds->package_id = $package_id;
                    $promoteAds->order_id = $purchasePackage->order_id;
                    $promoteAds->ads_id = $post->id;
                    $promoteAds->duration = $purchasePackage->duration;
                    $promoteAds->start_date = $start_date;
                    $promoteAds->end_date = $end_date;
                    $promoteAds->status = 1;
                    $promote = $promoteAds->save();
                    //update post status
                    $post->status = ($post->status == 'Not posted' || $post->status == 'draft') ? 'pending' : $post->status;
                    $post->save();
                    //decrement user purchase remaining ads
                    if($promote){ $purchasePackage->decrement('remaining_ads'); }
                }else{
                    $packageValue_id = $request->packageValue[$request->package];
                    //check package value by selected promote package id
                    $packageValue = PackageValue::where('package_id', $package_id)->where('id', $packageValue_id)->whereIn('category_id', [$post->category_id,$post->subcategory_id ])->first();
                    if($packageValue){
                        $order_id = $this->uniqueOrderId('package_purchases', 'order_id', 'R');
                        //purchase new package
                        $purchasePackage = new PackagePurchase();
                        $purchasePackage->order_id = $order_id;
                        $purchasePackage->user_id = $user_id;
                        $purchasePackage->category_id = $category_id;
                        $purchasePackage->package_id = $package_id;
                        $purchasePackage->total_ads = $packageValue->ads;
                        $purchasePackage->remaining_ads = $packageValue->ads;
                        $purchasePackage->duration = $packageValue->duration;
                        $purchasePackage->price = $packageValue->price;
                        $purchasePackage->currency = config('siteSetting.currency');
                        $purchasePackage->currency_sign = config('siteSetting.currency_symble');
                        $purchasePackage->payment_method = 'pending';
                        $purchasePackage->purchase_for = $post->id;
                        $purchase = $purchasePackage->save();
 
                        if($purchase){
                            //redirect payment page for payment
                            return redirect()->route('ads.promotePayment', [$post->slug, $order_id])->with('success', 'Your ads has been successfully post.');
                        }
                    }
                }
            }
        }
        return redirect()->route('post.list')->with('success', 'Your post has been successfully promoted.');
    }


    //package payment gateway for when ads post 
    public function adsPromotePayment($adsSlug, $orderId)
    {   
      
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

    //view promote ads history by package type
    public function adsPromoteHistory($package_slug){
        $data['package'] = Package::where('slug', $package_slug)->first();
        $data['promoteAds'] = PromoteAds::with('get_adPost')->orderBy('id', 'desc')->where('package_id', $data['package']->id)->get();

        return view('users.post.promoteAdsHistory')->with($data);
    }
}
