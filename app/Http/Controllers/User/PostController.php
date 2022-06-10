<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\ProductFeature;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\Category;
use App\Models\Country;
use App\Models\City;
use App\Models\ReportReason;
use App\Models\Brand;
use App\Models\Package;
use App\Models\PackageValue;
use App\Models\PackagePurchase;
use App\Models\PromoteAds;
use App\Models\PredefinedFeature;
use App\Models\SiteSetting;
use App\Traits\CreateSlug;
use Carbon\Carbon;
class PostController extends Controller
{
    use CreateSlug;
    public function index(Request $request, string $status=null){
        $posts = Product::withCount('jobTasks')->where('user_id', Auth::id())->orderBy('id', 'desc');
        $data['reasons'] = ReportReason::where('type', 'product-delete')->where('status', 1)->get();
        
        if($status){
            if($status == 'image-missing'){
                $posts->where('thumb_image', null);
            }
            else{
                $posts->where('status', $status);
            }
        }

        if(!$status && $request->status && $request->status != 'all'){
            $posts->where('status', $request->status);
        }
        if($request->title){
            $posts->where('title', 'LIKE', '%'. $request->title .'%');
        }
        $data['posts'] = $posts->paginate(15);
        
        return view('users.post.index')->with($data);
    }
 
    public function create(string $category=null, string $subcategory=null){
        //if select ads category
        
        $data['categories'] = Category::whereNull('parent_id')->orderBy('position', 'asc')->where('status', 1)->get();

        $data['subcategories'] = Category::where('parent_id', $data['categories'][0]->id)->orderBy('position', 'asc')->where('status', 1)->get();
      
        $data['locations'] = Country::orderBy('name', 'asc')->where('status', 1)->take(7)->get();
       
        return view('users.post.ad-post')->with($data);
   
    }

    //store new post
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'workstep' => 'required'
        ]);
        $user_id = Auth::id();
        // Insert post
        $post = new Product();
        $post->title = $request->title;
        $post->slug = $this->createSlug('products', $request->title);
        $post->workstep = ($request->workstep) ? json_encode($request->workstep) : null;
        $post->workProve = $request->workProve;
        $post->location = ($request->location) ? json_encode($request->location) : null;
        $post->category_id = $request->category;
        $post->subcategory_id = ($request->subcategory) ? $request->subcategory : null;
       
        $post->job_workers_need = ($request->job_workers_need ? $request->job_workers_need : 0);
        $post->per_workers_earn = ($request->per_workers_earn ? $request->per_workers_earn : 0);
        $post->work_screenshots = ($request->work_screenshots ? $request->work_screenshots : null);
        $post->estimated_time = ($request->estimated_time ? $request->estimated_time : null);
        $post->user_id = $user_id;
        $post->created_by = $user_id;
        //check ads auto active 
        $product_active = SiteSetting::where('type', 'product_activation')->where('status', 1)->first();
        $post->status = ($product_active) ? 'pending' : 'active';
      
        //if feature image set
        if ($request->hasFile('thumb_image')) {
            $image = $request->file('thumb_image');
            $image_name = $this->uniqueImagePath('products', 'thumb_image', $request->title.'.'.$image->getClientOriginalExtension());


            //thumb image Resize
            $img = Image::make($image->getRealPath())->resize(200, null, function($constraint){
                $constraint->aspectRatio();
            })->resizeCanvas(200, 150);
            $img->save(public_path('upload/images/post/thumb/' . $image_name));

            //Resize image
            $img = Image::make($image->getRealPath())->resize(670, 475, function($constraint){
                $constraint->aspectRatio();
            })->resizeCanvas(670, 475, 'center', false, 'e7edee');

            //save image
            $img->save(public_path('upload/images/post/' . $image_name));

            $post->thumb_image = $image_name;
        }

        $store = $post->save();

        if($store) {
         
            Toastr::success('Post create successfully.');
            return redirect()->route('myJobs')->with('success', 'Post create successfully.');
        }else{
            Toastr::error('Post Cannot Create.!');
        }
        return back();
    }

    //edit post
    public function edit($slug)
    {
        $data['post'] = Product::where('slug', $slug)->where('user_id', Auth::id())->first();
        $data['categories'] = Category::whereNull('parent_id')->orderBy('position', 'asc')->where('status', 1)->get();

        $data['subcategories'] = Category::where('parent_id', $data['post']->category_id)->orderBy('position', 'asc')->where('status', 1)->get();
     
        $data['locations'] = Country::orderBy('name', 'asc')->where('status', 1)->take(7)->get();
       
        if($data['post']){
           
            return view('users.post.ad-post-edit')->with($data);
        }

        return view('404');
    }

    //update new post
    public function update(Request $request, int $product_id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'workstep' => 'required'
        ]);
        // update post
        $post = Product::where('id', $product_id)->where('user_id', Auth::id())->first();
        if($post){
            $post->title = $request->title;
            $post->workstep = ($request->workstep) ? json_encode($request->workstep) : null;
            $post->workProve = $request->workProve;
            $post->location = ($request->location) ? json_encode($request->location) : null;
            $post->category_id = $request->category;
            $post->subcategory_id = ($request->subcategory) ? $request->subcategory : null;
           
            $post->job_workers_need = ($request->job_workers_need ? $request->job_workers_need : 0);
            $post->per_workers_earn = ($request->per_workers_earn ? $request->per_workers_earn : 0);
            $post->work_screenshots = ($request->work_screenshots ? $request->work_screenshots : null);
            $post->estimated_time = ($request->estimated_time ? $request->estimated_time : null);
            $post->updated_by = Auth::id();
            
            //if feature image set
            if ($request->hasFile('thumb_image')) {
                $getimage_path = public_path('upload/images/post/'. $post->thumb_image);
                if(file_exists($getimage_path) && $post->thumb_image){
                    unlink($getimage_path);
                    unlink(public_path('upload/images/post/thumb/'. $post->thumb_image));
                }

                $image = $request->file('thumb_image');
                $new_image_name = $this->uniqueImagePath('products', 'thumb_image', $request->title.'.'.$image->getClientOriginalExtension());

                //Resize image
                $img = Image::make($image->getRealPath())->resize(200, null, function($constraint){
                    $constraint->aspectRatio();
                })->resizeCanvas(200, 150);
                $img->save(public_path('upload/images/post/thumb/' . $new_image_name));


                //Resize image
                $img = Image::make($image->getRealPath())->resize(670, 475, function($constraint){
                    $constraint->aspectRatio();
                })->resizeCanvas(670, 475, 'center', false, 'e7edee');

                //save image
                $img->save(public_path('upload/images/post/' . $new_image_name));

                $post->thumb_image = $new_image_name;
            }

            $update = $post->save();

            if($update) {
                
                Toastr::success('Post update success.');
                return redirect()->route('myJobs')->with('success', 'Post update successfully.');
            }else{
                Toastr::error('Post update failed.!');
            }
        }else{
            Toastr::error('Post update failed.!');
        }
        return back();
    }

    // delete product
    public function delete(Request $request)
    {
        $product = Product::where('id',$request->product_id)->where('user_id', Auth::id())->first();
        if($product){
            $output = [
                'status' => true,
                'msg' => 'Post deleted successful.'
            ];

            //force sotf delete
            if($product->approved == null){
                $image_path = public_path('upload/images/post/'. $product->thumb_image);
                if(file_exists($image_path) && $product->thumb_image){
                    unlink($image_path);
                }
               
                $product->forceDelete();
            }else{
                //delete reason
                $product->delete_reason = $request->reason .':<br/>'. $request->reason_details;
                $product->save();
                $product->delete();
            }
            Toastr::success('Post deleted successful.');
        }else{
            Toastr::error('Post delete failed.');
        }
        return back();
    }

    // delete product image
    public function productImageDelete($id)
    {
        $product = Product::find($id);
        if($product){
            $image_path = public_path('upload/images/post/'. $product->thumb_image);
            if(file_exists($image_path) && $product->thumb_image){
                unlink($image_path);
                unlink(public_path('upload/images/post/thumb/'. $product->thumb_image));
            }
            $product->delete();
            $output = [
                'status' => true,
                'msg' => 'Post image deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Post image cannot deleted.'
            ];
        }
        return response()->json($output);
    }

 
    //get sub-category by category
    public function getSubCategory($cat_id){
        $subcategories = Category::where('parent_id', $cat_id)->orderBy('position', 'asc')->where('status', 1)->get();
        $output = '';
        if(count($subcategories)>0){
            foreach($subcategories as $subcategory){
                $output .=
                '<input type="radio" required name="subcategory" value="'.$subcategory->id.'" id="subcategory'.$subcategory->id.'">
                <label for="subcategory'.$subcategory->id.'" class="labelBox">'.$subcategory->name.'</label>';
            }
        }
        echo $output;
    }



}
