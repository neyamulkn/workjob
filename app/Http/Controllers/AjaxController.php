<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\Page;
use App\Models\PredefinedFeature;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductFeature;
use App\Models\ProductFeatureDetail;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\State;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{

    //get sub category by category
    public function get_subcategory($cat_id){
    	$subcategories = Category::where('parent_id', $cat_id)->get();
        $output = '';
        if(count($subcategories)>0){
            $output .= '<option value="">Select Subcategory</option>';
            foreach($subcategories as $subcategory){
                $output .='<option '. (Session::get("subcategory_id") == $subcategory->id ? "selected" : "" ).' value="'.$subcategory->id.'">'.$subcategory->name.'</option>';
            }
        }
        echo $output;
    }

    // get childcategory by category
    public function get_subchild_category($subcat_id){
    	$subchildcategories = Category::with('productsByChildCategory')->where('subcategory_id', $subcat_id)->get();
        $output = '';
        if(count($subchildcategories)>0){
            $output .= '<option value="">Select child category</option>';
            foreach($subchildcategories as $subchildcategory){
                $output .='<option '. (Session::get("childcategory_id") == $subchildcategory->id ? "selected" : "" ).' value="'.$subchildcategory->id.'">'.$subchildcategory->name.'</option>';
            }
        }
        echo $output;
    }

    //get attribute by child category
    public function getAttributeByChildcategory($subcat_id){
    	$subchildcategories = Category::where('subcategory_id', $subcat_id)->get();
        $output = '';
        if(count($subchildcategories)>0){
            $output .= '<option value="">Select Subcategory</option>';
            foreach($subchildcategories as $subchildcategory){
                $output .='<option '. (old("subcategory") == $subchildcategory->id ? "selected" : "" ).' value="'.$subchildcategory->id.'">'.$subchildcategory->name.'</option>';
            }
        }
        echo $output;
    }

    // get attribute by category & sub category
    public function getAttributeByCategory($category_id){
    	$attributes = ProductAttribute::where('category_id', $category_id)->get();
    	$output = '';
    	if(count($attributes)>0){
    		$output = view('admin.product.attributedynamic-fields')->with(compact('attributes'));
    	}

    	echo $output;
    }

    // get city by state
    public function get_state($id=0){
        $states = State::where('country_id', $id)->orderBy('name', 'asc')->where('status', 1)->get();
        $output = '';
        if(count($states)>0){
            $output .= '<option value="">Select state</option>';
            foreach($states as $state){
                $output .='<option '. (Session::get('state') == $state->id ? "selected" : "" ).' value="'.$state->id.'">'.$state->name.'</option>';
            }
        }
       
        echo $output;
    }

    // get city by state
    public function get_city($id=0){
        $cities = City::where('state_id', $id)->orderBy('name', 'asc')->where('status', 1)->get();
        $output = '';
        if(count($cities)>0){
            $output .= '<option value="">Select city</option>';
            foreach($cities as $city){
                $output .='<option '. (Session::get('city') == $city->id ? "selected" : "" ).' value="'.$city->id.'">'.$city->name.'</option>';
            }
        }
        echo $output;
    }

    // get area by city
    public function get_area($id=0){
        $areas = Area::where('city_id', $id)->orderBy('name', 'asc')->where('status', 1)->get();
        $output = '';
        if(count($areas)>0){
            $output .= '<option value="">Select area</option>';
            foreach($areas as $area){
                $output .='<option '. (Session::get('area') == $area->id ? "selected" : "" ).' value="'.$area->id.'">'.$area->name.'</option>';
            }
        }
        echo $output;
    }


    //get sub child category by main category
    public function getSubChildMenu($cat_id){
        $category = Category::with('get_subcategory.get_subcategory')->where('id', $cat_id)->first();

        $output = '';
        if($category){
            return view('layouts.partials.frontend.sub-childcategory')->with(compact('category'));
        }
        return $output;
    }

    // check unique fielde
    public function checkField(Request $request){

        if($request->field == 'email' && !filter_var($request->value, FILTER_VALIDATE_EMAIL)){
            $output = [
                'status' => false,
                'msg' =>  $request->value ." is invalid email."
            ];
            return response()->json($output);
        }

        $check = DB::table($request->table)->where($request->field, $request->value)->first();
        if($check){
            $output = [
                'status' => false,
                'msg' =>  $request->field ." allready used."
            ];
        }else{
            $output = [
                'status' => true,
                'msg' =>  $request->field ." is available."
            ];
        }

        return response()->json($output);

    }

    public function getFeature($category_id){
        $getFeature = PredefinedFeature::where('category_id', $category_id)->get();

        $output = '';
        if(count($getFeature)>0){
            $output = '<div class="row">';
            foreach ($getFeature as $feature) {
                $output .=  '<div style="margin-bottom:10px;" class="col-4 col-sm-2 '.($feature->is_required == null ?: "required").' text-right col-form-label">'.$feature->name.'
                <input type="hidden" value="'.$feature->name.'" class="form-control"  name="features['.$feature->id.']"></div>
                <div class="col-8 col-sm-4">
                    <input type="text" '.($feature->is_required == null ?: "required").' name="featureValue['.$feature->id.']" class="form-control"  placeholder="Input value here">
                </div>';
            }
            $output .= '</div>';
        }
        echo $output;
    }


    // delete Data Common
    public function deleteDataCommon(Request $request)
    {
        $field = ($request->field) ? $request->field : 'id';
        $delete = DB::table($request->table)->where($field, $request->id)->delete();
        if($delete){
            $output = [
                'status' => true,
                'msg' => 'Data deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Data cannot deleted.'
            ];
        }
        return response()->json($output);
    }


    //restore deleted Data Common
    public function restoreDeletedData(Request $request)
    {
        $field = ($request->field) ? $request->field : 'id';
        $model = $request->model;
        $restore = Product::withTrashed()->find($request->id)->restore();
        if($restore){
            $output = [
                'status' => true,
                'msg' => 'Data restore successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Data cannot restore.'
            ];
        }
        return response()->json($output);
    }

    
    //suggest search keywords
    public function search_keyword(Request $request){
        $keyword = request('q');
        $product = Product::selectRaw('title as product,slug,feature_image as image')
        ->where(function ($query) use ($keyword) {
            $query->orWhere('title', 'like', '%' . $keyword . '%');
            $query->orWhere('meta_keywords', 'like', '%' . $keyword . '%');
        })->take(5)->get()->toArray();

        $category = Category::selectRaw('name as category,slug, image')->where('name', 'LIKE', '%'. $request->q .'%')->take(5)->get()->toArray();
       
        $search_result = array_merge($product, $category);

        return $search_result;
    }

    // Status change function
    public function satusActiveDeactive(Request $request){
        $status = DB::table($request->table)->where('id', $request->id)->first();
        $field =  ($request->field) ? $request->field : 'status';
        //check number(1) or string(active)
        $value_type =  is_numeric($status->$field)  ? 1 : 'active';

        if(is_numeric($status->$field)){
            $value =  ($status->$field == 1)  ? 0 : 1;
        }else{
            $value =  ($status->$field == 'active' ? ($request->table == 'products' || $request->table == 'blogs' ? 'deactive' : 'pending') : 'active');
        }
        if($status){
            if($status->$field == $value_type){
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }else{
                DB::table($request->table)->where('id', $request->id)->update([$field => $value]);
            }
            $output = array( 'status' => true, 'message' => $field. ' update successful.');
        }else{
            $output = array( 'status' => false, 'message' => $field. ' can\'t update.!');
        }
        return response()->json($output);
    }

    // Status approve Unapprove function
    public function approveUnapprove(Request $request){
        $status = DB::table($request->table)->where('id', $request->id)->first();

        $field =  ($request->field) ? $request->field : 'status';
        //check number(1) or string(active)
        $value_type =  is_numeric($status->$field)  ? 1 : 'active';

        if(is_numeric($status->$field)){
            $value =  ($status->$field == 1)  ? 0 : 1;
        }else{
            $value =  ($status->$field == 'active')  ? 'pending' : 'active';
        }
        if($status){
            if($value == 'active'){
                DB::table($request->table)->where('id', $request->id)->update([$field => $value, 'approved' => 1]);
                if($request->table == 'products'){
                    $notify = 'Your ad has been approved, Sell faster now!';
                }else{
                    $notify = 'Your '.$request->table.' has been approved';
                }
                //insert notification in database
                Notification::create([
                    'type' => 'post',
                    'fromUser' => null,
                    'toUser' => $status->user_id,
                    'item_id' => $status->id,
                    'notify' => $notify
                ]);
            }else{
                DB::table($request->table)->where('id', $request->id)->update([$field => $value, 'approved' => 0]);
            }

            $output = array( 'status' => true, 'message' => ' Approve successful.');
        }else{
            $output = array( 'status' => false, 'message' => 'Sorry can\'t approve.!');
        }
        return response()->json($output);
    }

    //position sorting
    public function positionSorting(Request $request){

        for($i=0; $i<count($request->ids); $i++)
        {
            $sorting = DB::table($request->table);
            if(isset($request->field)){
                $sorting->where($request->field, $request->value);
            }
            $sorting->where('id', str_replace('item', '', $request->ids[$i]))->update(['position' => $i]);
        }
        echo 'Position sorting has been updated';
    }

    //get products by anyone field
    public function getProductsByField (Request $request, $field){
        $output = '';
        $products = Product::where($field, $request->id)->where('status', 'active')->get();
        if(count($products)>0){
            $output .= ' <option value="">Select Product</option>';
            foreach ($products as $source) {
                $output .= ' <option value="'.$source->id.'">'.$source->title.'</option>';
            }
        }
        echo $output;
    }

}
