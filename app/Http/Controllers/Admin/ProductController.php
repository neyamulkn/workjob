<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\SiteSetting;
use App\Models\Brand;
use App\Models\Country;

use App\Models\Category;
use App\Models\HomepageSection;
use App\Models\PredefinedFeature;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\State;
use App\Models\FavoriteSeller;
use App\Models\PromoteAds;
use App\Models\City;
use App\Models\RejectReason;
use App\Models\Notification;
use App\User;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Mockery\Exception;

class ProductController extends Controller
{
    use CreateSlug;
    // get product lists function
    public function index(Request $request, $status='')
    {

        if($status == 'reject' || $status == 'active' || $status == 'deactive'){
            $check_status = 'all';
        }else{
            $check_status = $status;
        }
        //check role permission
        $data['permission'] = $this->checkPermission($check_status);
        if(!$data['permission'] || !$data['permission']['is_view']){ Toastr::error(env('PERMISSION_MSG')); return back(); }

        $products = Product::withCount('jobTasks')->orderBy('updated_at', 'desc')->whereNotIn('status', ['draft','Not Posted']);
        if($status && $status != 'trash' && $status != 'promoted' && $status != 'all'){
            $products->where('status', $status);
        }
        //deleted post
        if($status == 'trash'){
            $products->onlyTrashed();
        }

        //promoted post
        if($status == 'promoted'){
            $promotePosts =  PromoteAds::where('start_date', '<=', now())->where('end_date', '>=', now())->where('status', 1)->pluck('ads_id');
            $products->whereIn('id', $promotePosts);
        }

        if($request->status && $request->status != 'all'){
            $products->where('status', $request->status);
        }
        if($request->brand && $request->brand != 'all'){
        $products->where('brand_id', $request->brand);
        }if($request->seller && $request->seller != 'all'){
            $products->where('user_id', $request->seller);
        }
        if($request->title){
            $products->where('title', 'LIKE', '%'. $request->title .'%');
        }
        $data['products'] = $products->paginate(15);

        $data['all_products'] = Product::count();
       
        $data['active_products'] = Product::where('status', 'active')->count();
        $data['deactive_products'] = Product::where('status', 'deactive')->count();
        $data['pending_products'] = Product::where('status', 'pending')->count();
        $data['rejected'] = Product::where('status', 'reject')->count();
       
        $data['brands'] = Brand::orderBy('position', 'asc')->where('status', 1)->get();
        $data['authors'] = User::orderBy('name', 'asc')->where('status', 'active')->get();

        return view('admin.product.product-lists')->with($data);
    }

    // Add new product
    public function upload()
    {
       
        $data['regions'] = State::orderBy('name', 'asc')->get();
        $data['brands'] = Brand::orderBy('name', 'asc')->where('status', 1)->get();
        $data['categories'] = Category::with('productsByCategory')->where('parent_id', '=', null)->orderBy('name', 'asc')->where('status', 1)->get();
      
        $data['attributes'] = ProductAttribute::where('category_id', 'all')->get();
        $data['features'] = PredefinedFeature::where('category_id', 'all')->get();
        return view('admin.product.product')->with($data);
    }

    //store new product
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'selling_price' => 'required',
            'feature_image' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        // Insert product
        $data = new Product();
        $data->title = $request->title;
        $data->slug = $this->createSlug('products', $request->title);
        $data->sku = $request->main_sku;
        $data->summery = $request->summery;
        $data->description = $request->description;
        $data->size_chart = $request->size_chart;
        $data->category_id = $request->category;
        $data->subcategory_id = $request->subcategory;
        $data->childcategory_id = ($request->childcategory) ? $request->childcategory : null;
        $data->brand_id = ($request->brand ? $request->brand : null);
        $data->purchase_price = $request->purchase_price;
        $data->selling_price = $request->selling_price;
        $data->discount = ($request->discount) ? $request->discount : null;
        $data->discount_type = ($request->discount_type) ? $request->discount_type : null;
        $data->stock = ($request->stock) ? $request->stock : 0;
        $data->total_stock = ($request->stock) ? $request->stock : 0;
        $data->manufacture_date = $request->manufacture_date;
        $data->expired_date = $request->expired_date;
        $data->video = ($request->product_video) ? 1 : null;
        $data->unit = ($request->unit) ? $request->unit : null;
        $data->link = ($request->link) ? $request->link : null;
        if($request->shipping_method){
            $data->shipping_method = ($request->shipping_method) ? $request->shipping_method : null;
            $data->order_qty = ($request->order_qty) ? $request->order_qty : null;
            $data->free_shipping = ($request->free_shipping) ? 1 : null;
            $data->shipping_cost = ($request->shipping_cost) ? $request->shipping_cost : null;
            $data->discount_shipping_cost = ($request->discount_shipping_cost) ? $request->discount_shipping_cost : null;
            $data->ship_region_id = ($request->ship_region_id) ? $request->ship_region_id : null;

            $data->other_region_cost = ($request->other_region_cost) ? $request->other_region_cost : null;
            $data->shipping_time = ($request->shipping_time) ? $request->shipping_time : null;
        }
        $data->cash_on_delivery = ($request->cash_on_delivery) ? $request->cash_on_delivery : null;

        
        $data->meta_title = ($request->meta_title) ? $request->meta_title : null;
        $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
        $data->meta_description = ($request->meta_description) ? $request->meta_description : null;
        $data->status = ($request->status ? 'active' : 'deactive');
        $data->created_by = Auth::guard('admin')->id();

        //if feature image set
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image_path = public_path('upload/images/product/thumb/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(200, 200);
            $image_resize->save($image_path);
            $image->move(public_path('upload/images/product'), $new_image_name);
            $data->feature_image = $new_image_name;
        }

        //if meta image set
        if ($request->hasFile('meta_image')) {
            $image = $request->file('meta_image');
            $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/images/product/meta_image'), $new_image_name);
            $data->meta_image = $new_image_name;
        }

        $data->product_type = ($request->product_type ? $request->product_type : 'add-to-cart');
        $data->file_link = $request->file_link ?? null;
        //if file set
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $new_file_name = $this->uniqueImagePath('products', 'file', $request->title.'.'.$image->getClientOriginalExtension());
            $file->move(public_path('upload/file/product'), $new_file_name);
            $data->file = $new_file_name;
        }
        $store = $data->save();

        if($store) {
            $total_qty = 0;
            //insert variation
            if ($request->attribute) {

                foreach ($request->attribute as $attribute_id => $attr_value) {
                    //insert product feature name in feature table
                    $feature = new ProductVariation();
                    $feature->product_id = $data->id;
                    $feature->attribute_id = $attribute_id;
                    $feature->attribute_name = $attr_value;
                    $feature->in_display = 1;
                    $feature->save();
                    if(isset($request->attributeValue) && array_key_exists($attribute_id, $request->attributeValue)) {
                        for ($i = 0; $i < count($request->attributeValue[$attribute_id]); $i++) {
                            
                            //check weather attribute value set
                            if (array_key_exists($i, $request->attributeValue[$attribute_id]) && $request->attributeValue[$attribute_id][$i]) {
                                //insert feature attribute details in ProductFeatureDetail table
                                $quantity = (isset($request->qty[$attribute_id]) && array_key_exists($i, $request->qty[$attribute_id]) ? $request->qty[$attribute_id][$i] : 0);
                                $feature_details = new ProductVariationDetails();
                                $feature_details->product_id = $data->id;
                                $feature_details->attribute_id = $attribute_id;
                                $feature_details->variation_id = $feature->id;
                                $feature_details->attributeValue_name = $request->attributeValue[$attribute_id][$i];
                                $feature_details->sku = (isset($request->sku[$attribute_id]) && is_array($request->sku[$attribute_id]) && array_key_exists($i, $request->sku[$attribute_id]) ? $request->sku[$attribute_id][$i] : 0);
                                $feature_details->quantity = $quantity;
                                $feature_details->price = (isset($request->price[$attribute_id]) && is_array($request->price[$attribute_id]) && array_key_exists($i, $request->price[$attribute_id]) ? $request->price[$attribute_id][$i] : 0);
                                $feature_details->color = (isset($request->color[$attribute_id]) && is_array($request->color[$attribute_id]) && array_key_exists($i, $request->color[$attribute_id]) ? $request->color[$attribute_id][$i] : null);

                                //if attribute variant image set
                                if (isset($request->image[$attribute_id]) && array_key_exists($i, $request->image[$attribute_id])) {
                                    $image = $request->image[$attribute_id][$i];
                                    $new_variantimage_name = $this->uniqueImagePath('product_variation_details', 'image', $request->title.'.'.$image->getClientOriginalExtension());

                                    $image_path = public_path('upload/images/product/varriant-product/thumb/' . $new_variantimage_name);
                                    $image_resize = Image::make($image);
                                    $image_resize->resize(200, 200);
                                    $image_resize->save($image_path);

                                    $image->move(public_path('upload/images/product/varriant-product'), $new_variantimage_name);
                                    $feature_details->image = $new_variantimage_name;
                                }
                                $feature_details->save();
                            }
                            //count total stock quantity
                            $total_qty += $quantity;
                        }
                    }
                }
            }
            //insert additional Feature data
            if ($request->features) {
                try {
                    foreach ($request->features as $feature_id => $feature_name) {
                        if ($request->featureValue[$feature_id]) {
                            $extraFeature = new ProductFeature();
                            $extraFeature->product_id = $data->id;
                            $extraFeature->feature_id = $feature_id;
                            $extraFeature->name = $feature_name;
                            $extraFeature->value = $request->featureValue[$feature_id];
                            $extraFeature->save();
                        }
                    }
                } catch (Exception $exception) {

                }
            }
            // gallery Image upload
            if ($request->hasFile('gallery_image')) {
                $gallery_image = $request->file('gallery_image');
                foreach ($gallery_image as $image) {
                    $new_image_name = uniqid().'.'.$image->getClientOriginalExtension();
                    $image_path = public_path('upload/images/product/gallery/thumb/' . $new_image_name);
                    $image_resize = Image::make($image);
                    $image_resize->resize(200, 200);
                    $image_resize->save($image_path);
                    $image->move(public_path('upload/images/product/gallery'), $new_image_name);

                    ProductImage::create([
                        'product_id' => $data->id,
                        'image_path' => $new_image_name
                    ]);
                }
            }
            //video upload
            if (isset($request->video_provider)) {
                for ($i = 0; $i < count($request->video_provider); $i++) {
                    ProductVideo::create(['product_id' => $data->id,
                        'provider' => $request->video_provider[$i],
                        'link' => $request->video_link[$i]
                    ]);
                }
            }
            //update total quantity
            if ($total_qty != 0){
                $productStock = Product::find($data->id);
                $productStock->stock = ($total_qty != 0) ? $total_qty : $request->stock;
                $productStock->total_stock = ($total_qty != 0) ? $total_qty : $request->stock;
                $productStock->save();
            }

            Toastr::success('Product Create Successfully.');
        }else{
            Toastr::error('Product Cannot Create.!');
        }
        return back();
    }

    //edit product
    public function edit($slug)
    {

       $data['product'] = Product::with('get_galleryImages')->where('slug', $slug)->first();
        $product_id = $data['product']->id;
        
        if($data['product']){
            if($data['product']->category_id) {
                $category_id = $data['product']->category_id;
            }
            if($data['product']->subcategory_id) {
                $subcategory_id = $data['product']->subcategory_id;
            }

            $data['attributes'] = ProductAttribute::with(['get_attrValues.get_productVariant' => function($query) use ($product_id){$query->where('product_id', $product_id);}])->whereIn('category_id', ['all',$category_id,$subcategory_id ])->where('status', 1)->get();

            $data['features'] = PredefinedFeature::with(['featureValue' => function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            }])->whereIn('category_id', ['all',$category_id, $subcategory_id ])->where('status', 1)->get();
            $data['regions'] = State::orderBy('name', 'asc')->where('status', 1)->get();
            $data['cities'] = City::where('state_id', $data['product']->state_id)->orderBy('name', 'asc')->where('status', 1)->get();
            $data['brands'] = Brand::orderBy('name', 'asc')->where('status', 1)->get();
            $data['chilcategories'] = Category::where('parent_id', $subcategory_id)->where('status', 1)->get();

        return view('admin.product.product-edit')->with($data);
    }
    }

    //update post
    public function update(Request $request, $product_id)
    {
        $request->validate([
            'title' => 'required',
            'state_id' => 'required',
            'price' => 'required',
        ]);

        // update post
        $data = Product::where('id', $product_id)->first();
        if($data){
            $data->title = $request->title;
            $data->description = $request->description;
            $data->childcategory_id = ($request->childcategory_id ? $request->childcategory_id : null);
            $data->state_id = ($request->state_id ? $request->state_id : 0);
            $data->city_id = ($request->city_id ? $request->city_id : 0);
            $data->brand_id = ($request->brand ? $request->brand : null);
            $data->price = $request->price;
            $data->negotiable = ($request->negotiable ? 1 : 0);
            $data->sale_type = ($request->sale_type ? $request->sale_type : null);
            $data->contact_name = ($request->contact_name) ? $request->contact_name : null;
            $data->contact_mobile = ($request->contact_mobile) ? $request->contact_mobile : null;
            $data->contact_email = ($request->contact_email) ? $request->contact_email : null;
            $data->contact_hidden = ($request->contact_hidden) ? 1 : 0;
            $data->meta_keywords = ($request->meta_keywords) ? implode(',', $request->meta_keywords) : null;
            
            //if feature image set
            if ($request->hasFile('feature_image')) {
                $getimage_path = public_path('upload/images/product/'. $data->feature_image);
                if(file_exists($getimage_path) && $data->feature_image){
                    unlink($getimage_path);
                    unlink(public_path('upload/images/product/thumb/'. $data->feature_image));
                }

                $image = $request->file('feature_image');
                $new_image_name = $this->uniqueImagePath('products', 'feature_image', $request->title.'.'.$image->getClientOriginalExtension());

                $image_path = public_path('upload/images/product/thumb/' . $new_image_name);
                $image_resize = Image::make($image);
                $image_resize->resize(200, 150);
                $image_resize->save($image_path);


                $image_path = public_path('upload/images/product/' . $new_image_name);
                $image_resize = Image::make($image);
                $image_resize->resize(670, 475);
                $image_resize->save($image_path);

                $data->feature_image = $new_image_name;
            }

            $update = $data->save();

            if($update) {

                //insert variation
                if ($request->attribute) {
                    foreach ($request->attribute as $attribute_id => $attr_value) {
                        //insert product feature name in feature table
                       
                        if(isset($request->attributeValue) && array_key_exists($attribute_id, $request->attributeValue)) {
                            for ($i = 0; $i < count($request->attributeValue[$attribute_id]); $i++) {
                               
                                //check weather attribute value set
                                if (array_key_exists($i, $request->attributeValue[$attribute_id]) && $request->attributeValue[$attribute_id][$i]) {
                                    
                                    //insert or update feature attribute details in ProductVariationDetails table
                                    $feature_details = ProductVariationDetails::where('attribute_id', $attribute_id)->where('product_id', $product_id)->first();

                                    if (!$feature_details) {
                                        $feature_details = new ProductVariationDetails();
                                    }
                                   
                                    $feature_details->product_id = $data->id;
                                    $feature_details->attribute_id = $attribute_id;
                                    $feature_details->variation_id = $request->attributeValue[$attribute_id][$i];
                                    $feature_details->attributeValue_name = $request->attributeValue[$attribute_id][$i];
                                    $feature_details->save();
                                }
                            
                            }
                        }
                    }
                }

                //insert or update product feature
                if($request->features){
                    try {
                        foreach($request->features as $feature_id => $feature_name) {

                            $extraFeature = ProductFeature::where('product_id', $product_id)->where('feature_id', $feature_id)->first();
                            if(!$extraFeature){
                                $extraFeature = new ProductFeature();
                            }
                            $extraFeature->product_id = $product_id;
                            $extraFeature->feature_id = $feature_id;
                            $extraFeature->name = $feature_name;
                            $extraFeature->value = ($request->featureValue[$feature_id]) ? $request->featureValue[$feature_id] : null;
                            $extraFeature->save();

                        }
                    }catch (Exception $exception){

                    }
                }

                // gallery Image upload
                if ($request->hasFile('gallery_image')) {
                    $gallery_image = $request->file('gallery_image');
                    foreach ($gallery_image as $image_id => $image) {
                        $productImage = ProductImage::where('product_id', $product_id)->where('id', $image_id)->first();

                        if($productImage){
                            //delete image from folder
                            $image_path = public_path('upload/images/product/gallery/'. $productImage->image_path);
                            if(file_exists($image_path) && $productImage->image_path){
                                unlink($image_path);
                            }
                        }else{
                            $productImage = new ProductImage();
                        }

                        $new_image_name = $this->uniqueImagePath('product_images', 'image_path',$request->title.'.'.$image->getClientOriginalExtension());
                        $image_path = public_path('upload/images/product/gallery/'.$new_image_name);
                       
                        $image_resize = Image::make($image);
                        $image_resize->resize(670, 475);
                     
                        $image_resize->save($image_path);
                        //$image->move(public_path('upload/images/product/gallery'), $new_image_name);
                        
                        $productImage->product_id = $data->id;
                        $productImage->image_path = $new_image_name;
                        $productImage->title = $new_image_name;
                        $productImage->save();
                    }
                }
                Toastr::success('Post update success.');
            }else{
                Toastr::error('Post update failed.!');
            }
        }else{
            Toastr::error('Post update failed.!');
        }
        return back();
    }

    // delete product
    public function delete($id)
    {
        $product = Product::withTrashed()->find($id);

        if($product){
           
            $gallery_images = ProductImage::where('product_id',  $product->id)->get();
            foreach ($gallery_images as $gallery_image) {
                $image_path = public_path('upload/images/product/gallery/'. $gallery_image->image_path);
                if(file_exists($image_path) && $gallery_image->image_path){
                    unlink($image_path);
                    unlink(public_path('upload/images/product/gallery/thumb/'. $gallery_image->image_path));
                }
                $gallery_image->delete();
            }
            
            $output = [
                'status' => true,
                'msg' => 'Post deleted successful.'
            ];
            //softdelete
            if($product->deleted_at){
                $image_path = public_path('upload/images/product/'. $product->feature_image);
                if(file_exists($image_path) && $product->feature_image){
                    unlink($image_path);
                }
                ProductVariation::where('product_id',  $product->id)->delete();
                ProductVariationDetails::where('product_id',  $product->id)->delete();
                ProductFeature::where('product_id',  $product->id)->delete();
                $product->forceDelete();
            }else{
                $product->delete();
            }
            
        }else{
            $output = [
                'status' => false,
                'msg' => 'Post cannot delete.'
            ];
        }
        return response()->json($output);
    }
    
 
    //get product Status popup
    public function productStatus($product_id){
        $data['product'] = Product::withTrashed()->find($product_id);
        $data['reasons'] = RejectReason::where('type','reason')->get();
        if($data['product']){
            return view('admin.product.productStatus')->with($data);
        }
        return false;
    }

    //product Status Update
    public function productStatusUpdate(Request $request){

        $product = Product::find($request->id);
        if($request->status && $product->status != $request->status){
            $product->status = $request->status;
           
            if($request->status == 'active'){
                if($product->approved == null){
                    $product->approved = now();

                    //insert notification follower user
                    $followers = FavoriteSeller::where('follower_id', $product->user_id)->get();
                    if(count($followers)>0){
                        foreach($followers as $follower){
                        $data[] = [
                            'type' => 'post',
                            'fromUser' => $follower->follower_id,
                            'toUser' => $follower->user_id,
                            'item_id' => $product->id,
                            'notify' => 'added a new post',
                            'created_at' => now(),
                            'updated_at' => now()
                            ];
                        }
                       
                        Notification::insert($data);

                    }
                }
                $notify = 'Your ad has been approved';
            }elseif($request->status == 'reject'){
                $notify = 'This ad has been rejected, Edit it and go live';
            }else{
                $notify = 'This ad has been '.$request->status;
            }
            //insert notification in database
            Notification::create([
                'type' => 'post',
                'fromUser' => null,
                'toUser' => $product->user_id,
                'item_id' => $product->id,
                'notify' => $notify,
            ]);
        }
        $product->reject_reason = ($request->reject_reason) ? $request->reason .' '. $request->reject_reason : $request->reason;
        $product->save();
        Toastr::success('Post status update success.');
        return back();
    } 


    public function promoteAdPosts(){
        PromoteAds::where('start_date', '<=', now())->where('end_date', '>=', now())->where('status', 1)->get();
    }

}
