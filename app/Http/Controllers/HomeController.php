<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use App\Models\ProductVariationDetails;
use App\Models\SiteSetting;
use App\Models\State;
use App\Models\City;
use App\Models\Slider;
use App\Models\PromoteAds;
use App\Models\Addvertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Auth;
use Session;
use App\Models\Cart;
class HomeController extends Controller
{
    //home page function
    public function index(Request $request)
    {
        $data = [];
        //get all homepage section
        $data['sections'] = HomepageSection::where('page_name', 'homepage')->where('status', 1)->orderBy('position', 'asc')->paginate(88);

        //check ajax request
        if ($request->ajax()) {
            $view = view('frontend.homepage.homesection', $data)->render();
            return response()->json(['html'=>$view]);
        }
        $data['slider'] = Slider::where('status', 1)->where('type', 'homepage')->orderBy('position', 'asc')->first();
        

        return view('frontend.home')->with($data);
    }

    //product show by category
    public function category(Request $request, string $catslug=null, string $location=null)
    {
        $data['products'] = $data['banners'] = $data['product_variations'] = $data['category'] = $data['filterCategories'] = $data['brands'] = [];
        $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
        $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2);
 
        $category_id = $state_id = $city_id = null;
        $keyword = $request->q;
        

           $data['category'] = Category::with(['get_subcategory' => function($query) use ($ads_duration){
                $query->withCount(['productsBySubcategory']);
            }])->where(function ($query) use ($catslug, $location) {
                $query->where('slug', $catslug)->orWhere('slug', $location);
            })->first();

            if($data['category']){
                $category_id = $data['category']->id;

                //recent views set category id
                $recent_catId = $data['category']->id;
                $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
                $recentViews = array_merge([$recent_catId], $recentViews);
                $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
                Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));
            }

            $data['state'] = City::where(function ($query) use ($catslug, $location) {
                    $query->where('slug', $catslug)->orWhere('slug', $location);
                })->orderBy('name', 'asc')->withCount('productsByCity')->first();

            if($data['state']){
                $city_id = $data['state']->id;
            }else{
                $data['state'] = State::with('get_city')->where(function ($query) use ($catslug, $location) {
                    $query->where('slug', $catslug)->orWhere('slug', $location);
                })->orderBy('name', 'asc')->withCount('productsByState')->first();
                $state_id = ($data['state']) ? $data['state']->id : null;
            }

            $sortby = ($request->sortby) ? $request->sortby : null;
            $price_min = ($request->price_min) ? $request->price_min : null;
            $price_max = ($request->price_max) ? $request->price_max : null;


            //get promote ads by category
            $data['topUps'] = PromoteAds::with(['user','get_adPost', 'get_adPackage'])->where('package_id', 5)->whereHas('get_adPost', function($query) use ($category_id, $state_id, $city_id, $keyword, $sortby, $price_min, $price_max){
                    $query->where('status', 'active');

                    if($category_id){
                    $query->where(function ($q) use ($category_id) { $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);});
                    }

                    if($state_id){
                        $query->where('state_id', $state_id);
                    }if($city_id){
                        $query->where('city_id', $city_id);
                    }

                    if ($keyword) {
                        $query->where('title', 'like', '%' . $keyword . '%');
                    }

                   
                    $field = 'id'; $value = 'desc';
                    if ($sortby) {
                        try {
                            $sort = explode('-', $sortby);
                            if ($sort[0] == 'name') {
                                $field = 'title';
                            } elseif ($sort[0] == 'price') {
                                $field = 'price';
                            } else {
                                $field = 'id';
                            }
                            $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                            $query->orderBy($field, $value);
                        }catch (\Exception $exception){}
                    }else{
                        $query->orderBy($field, $value);
                    }
                   
                    //check price keyword
                    if ($price_min) {
                        $query->where('price', '>=', $price_min);
                    }if ($price_max) {
                        $query->where('price', '<=', $price_max);
                    }

                })->where('start_date', '<=', now())->where('end_date', '>=', now())->inRandomOrder()->take(6)->where('status', 1)->get();
            
        
            //get promote ads by category
            $data['featurePromotePosts'] = PromoteAds::with(['user','get_adPost', 'get_adPackage'])->where('package_id', '!=', 5)->whereHas('get_adPost', function($query) use ($category_id, $state_id, $city_id, $keyword, $sortby, $price_min, $price_max){
                    $query->where('status', 'active');

                    if($category_id){
                    $query->where(function ($q) use ($category_id) { $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);});
                    }

                    if($state_id){
                        $query->where('state_id', $state_id);
                    }if($city_id){
                        $query->where('city_id', $city_id);
                    }

                    if ($keyword) {
                        $query->where('title', 'like', '%' . $keyword . '%');
                    }
                    $field = 'id'; $value = 'desc';
                    if ($sortby) {
                        try {
                            $sort = explode('-', $sortby);
                            if ($sort[0] == 'name') {
                                $field = 'title';
                            } elseif ($sort[0] == 'price') {
                                $field = 'price';
                            } else {
                                $field = 'id';
                            }
                            $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                            $query->orderBy($field, $value);
                        }catch (\Exception $exception){}
                    }else{
                        $query->orderBy($field, $value);
                    }
                   
                    //check price keyword
                    if ($price_min) {
                        $query->where('price', '>=', $price_min);
                    }if ($price_max) {
                        $query->where('price', '<=', $price_max);
                    }
                })->where('start_date', '<=', now())->where('end_date', '>=', now())->inRandomOrder()->take(3)->where('status', 1)->get();

            //get promote ads by category
            $data['topPromotePosts'] = PromoteAds::with(['user','get_adPost', 'get_adPackage'])->where('package_id', '!=', 5)->whereHas('get_adPost', function($query) use ($category_id, $state_id, $city_id, $keyword, $sortby, $price_min, $price_max){
                    $query->where('status', 'active');

                    if($category_id){
                    $query->where(function ($q) use ($category_id) { $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);});
                    }

                    if($state_id){
                        $query->where('state_id', $state_id);
                    }if($city_id){
                        $query->where('city_id', $city_id);
                    }

                    if ($keyword) {
                        $query->where('title', 'like', '%' . $keyword . '%');
                    }

                   
                    $field = 'id'; $value = 'desc';
                    if ($sortby) {
                        try {
                            $sort = explode('-', $sortby);
                            if ($sort[0] == 'name') {
                                $field = 'title';
                            } elseif ($sort[0] == 'price') {
                                $field = 'price';
                            } else {
                                $field = 'id';
                            }
                            $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                            $query->orderBy($field, $value);
                        }catch (\Exception $exception){}
                    }else{
                        $query->orderBy($field, $value);
                    }
                   
                    //check price keyword
                    if ($price_min) {
                        $query->where('price', '>=', $price_min);
                    }if ($price_max) {
                        $query->where('price', '<=', $price_max);
                    }

                })->where('start_date', '<=', now())->where('end_date', '>=', now())->inRandomOrder()->take(6)->where('status', 1)->get();
            
            
            $products = Product::with('author')->where('status', 'active');

            if($ads_duration){
                $products->where('approved', '>=', $ads_duration); 
            }
            
            if($category_id){
                $products->where(function($query) use ($category_id){
                    $query->where('category_id', $category_id)->orWhere('subcategory_id', $category_id )->orWhere('childcategory_id', $category_id);
                });
            }
          
            if($state_id){
                $products->where('state_id', $state_id);
            }if($city_id){
                $products->where('city_id', $city_id);
            }

            //check search keyword
            if ($request->q) {
                $products->where('title', 'like', '%' . $request->q . '%');
            }

            //period ratting
            if ($request->period) {
                if($request->period == 'hour'){
                    $period =  Carbon::parse(now())->subHours(2);
                }else{
                    $period =  Carbon::parse(now())->subDays(3);
                }
                $products->where('approved', '>=', $period);
            }

            //check brand
            if ($request->brand) {
                if (!is_array($request->brand)) { // direct url tags
                    $brand = explode(',', $request->brand);
                } else { // filter by ajax
                    $brand = implode(',', $request->brand);
                }
                $products->whereIn('brand_id', $brand);
            }
            $field = 'id'; $value = 'desc';
            if (isset($request->sortby) && $request->sortby) {
                try {
                    $sort = explode('-', $request->sortby);
                    if ($sort[0] == 'name') {
                        $field = 'title';
                    } elseif ($sort[0] == 'price') {
                        $field = 'price';
                    } else {
                        $field = 'id';
                    }
                    $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                    $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $products->orderBy($field, $value);

            //check price keyword
            if ($request->price_min) {
                $products->where('price', '>=', $request->price_min);
            }if ($request->price_max) {
                $products->where('price', '<=', $request->price_max);
            }

            //check perPage
            $promoteAds = count($data['featurePromotePosts']) + count($data['topPromotePosts']);

            //check perPage
            $perPage = 25 - $promoteAds;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage - $promoteAds;
            }

            $products->selectRaw('id,title,slug,price,brand_id,category_id,state_id,views,sale_type, user_id, feature_image,created_at,approved');
            
            $data['product_variations'] = ProductAttribute::withCount(['get_productVariationDetails', 'get_productVariationDetails as get_product_variation_details_count' => function($query){
                $query->where('get_product_variation_details_count', '>', 0);
            }])->with(['get_attrValues' => function($query) use ($ads_duration,$category_id, $state_id, $city_id){
                $query->withCount(['get_variantProducts'  => function($query) use ($ads_duration, $category_id, $state_id, $city_id){  $query->leftJoin('products', 'product_variation_details.product_id', 'products.id')->where('approved', '>=', $ads_duration); 
                    if($category_id){
                        $query->where(function ($q) use ($category_id) { $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);});
                    }
                    if($state_id){
                        $query->where('state_id', $state_id);
                    }
                    if($city_id){
                        $query->where('city_id', $city_id);
                    }
                }]);
            }])->where('category_id', $category_id)->where('is_filter', 1)->get();

           //check weather ajax request identify filter parameter
            foreach ($data['product_variations'] as $filterAttr) {
                $filter = strtolower(str_replace(' ', '', $filterAttr->name));
            
                if ($request->$filter) {

                    if (!is_array($request->$filter)) { // direct url tags
                        $tags = explode(',', $request->$filter);
                    } else { // filter by ajax
                        $tags = implode(',', $request->$filter);
                    }
                   
                    //get product id from url filter id (size=1,2)
                    $productsFilter = ProductVariationDetails::join('product_attribute_values', 'product_variation_details.attributeValue_name', 'product_attribute_values.id')->whereIn('name', $tags)->groupBy('product_id')->get()->pluck('product_id');

                    $products->whereIn('id', $productsFilter);
                }
            }

            //get product id for Category states count post
            $get_products  = $products->get()->toArray();
            $product_id = array_column($get_products, 'id');
          
            
            $data['products'] = $products->paginate($perPage);

        
        $data['get_ads'] = Addvertisement::whereIn('page', ['category', 'all'])->inRandomOrder()->where('status', 1)->get();

        $data['get_category'] = Category::with(['get_subcategory' => function($query){ $query->withCount('productsBySubcategory');} ])->withCount(['productsByCategory' => function($query) use ($product_id){
                    $query->whereIn('id', $product_id);
                } ])->whereNull('parent_id')->where('status', 1)->get();
               
        $data['brands'] =  Brand::join('products', 'brands.id', 'products.brand_id')->groupBy('brand_id')->where('brands.status', 1)->where('products.category_id', $category_id)->orderBy('brands.position', 'asc')->selectRaw('brands.*')->get();

        $data['states'] =  State::with(['get_city' => function($query) use ($product_id){
        $query->withCount(['productsByCity' => function($query) use ($product_id){
            $query->whereIn('id', $product_id);
        } ]);}])
        ->withCount(['productsByState' => function($query) use ($product_id){
            $query->whereIn('id', $product_id);
        }])->orderBy('name', 'asc')->get();


        if($request->filter){
            return view('frontend.post-filter')->with($data);
        }else{
            
            return view('frontend.category-details')->with($data);
        }
    }

    //product show by category
    public function location(Request $request, $location, string $catslug=null)
    {
        $data['products'] = $data['banners'] = $data['product_variations'] = $data['category'] = $data['filterCategories'] = $data['brands'] = [];

        try {

            $data['state'] = State::with(['get_city' => function($query){
                $query->withCount('productsByCity');}])
                ->withCount('productsByState')->where('states.slug', $location)->leftJoin('cities', 'states.id', 'cities.state_id')->orWhere('cities.slug', $location)->orderBy('states.name', 'asc')->selectRaw('states.*')->first();
            
            $category = Category::with(['get_subcategory' => function($query){
                $query->withCount('productsBySubcategory');
            }]);
            if($catslug){
                $category->where('slug', $catslug);
            }
            $data['category'] = $category->first();

            if(!$data['category']){
                return view('frontend.pages.category-sitemap');
            }
            $category_id = $data['category']->id;
            //get promote ads by category
            $data['promoteAdPosts'] = PromoteAds::with(['get_adPost', 'get_adPackage'])->whereHas('get_adPost', function($query) use ($category_id){
                $query->where('status', 'active')->where(function ($q) use ($category_id) {
                   $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);
                });
            })->where('start_date', '<=', now())->where('end_date', '>=', now())->where('status', 1)->get();
           
            $products = Product::where(function($query) use ($category_id){
            $query->where('category_id', $category_id)
                ->orWhere('subcategory_id', $category_id )
                ->orWhere('childcategory_id', $category_id);
            });

            // $products = Product::where(function($query) use ($category_id){
            // $query->where('state_id', $category_id)
            //     ->orWhere('subcategory_id', $category_id )
            //     ->orWhere('childcategory_id', $category_id);
            // });

        
            //recent views set category id
            $recent_catId = $data['category']->id;
            $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
            $recentViews = array_merge([$recent_catId], $recentViews);
            $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
            Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));

            //check search keyword
            if ($request->q) {
                $products->where('title', 'like', '%' . $request->q . '%');
            }

            //check ratting
            if ($request->ratting) {
                $products->where('avg_ratting', $request->ratting);
            }

            //check brand
            if ($request->brand) {
                if (!is_array($request->brand)) { // direct url tags
                    $brand = explode(',', $request->brand);
                } else { // filter by ajax
                    $brand = implode(',', $request->brand);
                }
                $products->whereIn('brand_id', $brand);
            }
            $field = 'id'; $value = 'desc';
            if (isset($request->sortby) && $request->sortby) {
                try {
                    $sort = explode('-', $request->sortby);
                    if ($sort[0] == 'name') {
                        $field = 'title';
                    } elseif ($sort[0] == 'price') {
                        $field = 'price';
                    } else {
                        $field = 'id';
                    }
                    $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                    $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $products->orderBy($field, $value);

            //check price keyword
            if ($request->price_min) {
                $products->where('price', '>=', $request->price_min);
            }if ($request->price_max) {
                $products->where('price', '<=', $request->price_max);
            }

            //check perPage
            $perPage = 3;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }

            $products->selectRaw('id,title,slug,price,brand_id,category_id,state_id,views,sale_type, feature_image,created_at')->where('status', 'active');
            //get product id for product_variations
            $get_products  = $products->get()->toArray();
            $product_id = array_column($get_products, 'id');
           
            $data['product_variations'] = ProductAttribute::with(['get_attrValues' => function($query){
                $query->withCount('get_variantProducts');
            }])->where('category_id', $category_id)
                ->get();
            
            //check weather ajax request identify filter parameter
            foreach ($data['product_variations'] as $filterAttr) {
                $filter = strtolower(str_replace(' ', '', $filterAttr->name));
               
                if ($request->$filter) {

                    if (!is_array($request->$filter)) { // direct url tags
                        $tags = explode(',', $request->$filter);
                    } else { // filter by ajax
                        $tags = implode(',', $request->$filter);
                    }
                    //get product id from url filter id (size=1,2)
                    $productsFilter = ProductVariationDetails::join('product_attribute_values', 'product_variation_details.variation_id', 'product_attribute_values.id')->whereIn('name', $tags)->groupBy('product_id')->get()->pluck('product_id');

                    $products->whereIn('id', $productsFilter);
                }
            }
           
            $data['products'] = $products->paginate($perPage);

        }catch (\Exception $e){

        }

        if($request->filter){
            return view('frontend.post-filter')->with($data);
        }else{
            if($data['category']){
                $data['banners'] = Banner::where('page_name', $data['category']->slug)->where('status', 1)->get();
                $data['brands'] =  Brand::join('products', 'brands.id', 'products.brand_id')->groupBy('brand_id')->where('brands.status', 1)->where('products.category_id', $data['category']->id)->orderBy('brands.position', 'asc')->selectRaw('brands.*')->get();
            }
            return view('frontend.ads-location')->with($data);
        }
    }
    //search products
    public function search(Request $request)
    {

        $data['products'] = $data['product_variations'] = $data['category']  = $data['brands'] = $brand_id = $childcategory_id = [];
        
        try {
            $products = Product::where('products.status', 'active');
            $keywords = request('q');
            if($request->q) {
                $products->where(function ($query) use ($keywords) {
                    $query->orWhere('title', 'like', '%' . $keywords . '%');
                    $query->orWhere('meta_keywords', 'like', '%' . $keywords . '%');
                });
            }
            
            //check brand
            if ($request->brand) {
                if (!is_array($request->brand)) { // direct url tags
                    $brand = explode(',', $request->brand);
                } else { // filter by ajax
                    $brand = implode(',', $request->brand);
                }
                $products->whereIn('brand_id', $brand);
            }
            $field = 'id'; $value = 'desc';
            if (isset($request->sortby) && $request->sortby) {
                try {
                    $sort = explode('-', $request->sortby);
                    if ($sort[0] == 'name') {
                        $field = 'title';
                    } elseif ($sort[0] == 'price') {
                        $field = 'price';
                    } else {
                        $field = 'id';
                    }
                    $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                    $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $products->orderBy($field, $value);

            //check price keyword
            if ($request->price_min) {
                $products->where('price', '>=', $request->price_min);
            }if ($request->price_max) {
                $products->where('price', '<=', $request->price_max);
            }


            //check perPage
            $perPage = 16;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }

            $products->selectRaw('id,title,slug,price,brand_id,category_id,state_id,views,sale_type, feature_image,created_at')->where('status', 'active');
            //get product id for product_variations
            $get_products  = $products->get()->toArray();

            $product_id = array_column($get_products, 'id');
            $brand_id = array_column($get_products, 'brand_id');
            $childcategory_id = array_column($get_products, 'childcategory_id');
            
            $data['product_variations'] = ProductVariation::with('allVariationValues')
                ->whereIn('product_id', $product_id)
                ->groupBy('attribute_id')
                ->get();
            
            //check weather ajax request identify filter parameter
            foreach ($data['product_variations'] as $filterAttr) {
                $filter = strtolower($filterAttr->attribute_name);
                if ($request->$filter) {
                    if (!is_array($request->$filter)) { // direct url tags
                        $tags = explode(',', $request->$filter);
                    } else { // filter by ajax
                        $tags = implode(',', $request->$filter);
                    }
                    //get product id from url filter id (size=1,2)
                    $productsFilter = ProductVariationDetails::whereIn('attributeValue_name', $tags)->groupBy('product_id')->get()->pluck('product_id');
                    $products = $products->whereIn('products.id', $productsFilter);
                }
            }

            $data['products'] = $products->paginate($perPage);

        }catch (\Exception $e){

        }

        if($request->filter){
            return view('frontend.products.filter_products')->with($data);
        }else{
            $data['categories'] = Category::whereIn('id', $childcategory_id)->get();
            $data['brands'] = Brand::whereIn('id', $brand_id)->where('status', 1)->get();
            return view('frontend.category-details')->with($data);
        }
    }
    
    //display product details by product id/slug
    public function post_details(Request $request, $slug)
    {
        $data['post_detail'] = Product::with(['get_features', 'author', 'get_variations.get_variationDetails.get_attributeValue'])->where('slug', $slug)->first();

        if($data['post_detail']) {
            //recent views set category id
            $recent_catId = ($data['post_detail']->childcategory_id) ? $data['post_detail']->childcategory_id : $data['post_detail']->subcategory_id;
            $recentViews = (Cookie::has('recentViews') ? json_decode(Cookie::get('recentViews')) :  []);
            $recentViews = array_merge([$recent_catId], $recentViews);
            $recentViews = array_values(array_unique($recentViews)); //reindex & remove duplicate value
            Cookie::queue('recentViews', json_encode($recentViews), time() + (86400));

          
            
            $data['post_detail']->increment('views'); // news view count
            $related_products = Product::where('status', 'active');
            if($data['post_detail']->subcategory_id != null){
                $category_feild = 'subcategory_id';
                $category_id = $data['post_detail']->subcategory_id;
            }else{
                $category_feild = 'category_id';
                $category_id = $data['post_detail']->category_id;
            }

            //ads duration
            $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
            $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2); 
            if($ads_duration){
                $related_products->where('approved', '>=', $ads_duration); 
            }

            $data['related_products'] = $related_products->where($category_feild, $category_id)->selectRaw('id,title,slug,feature_image,price,sale_type,brand_id,category_id,state_id,created_at')->where('id', '!=', $data['post_detail']->id)->inRandomOrder()->take(6)->get();

            //get promote ads by category
            $data['featureAds'] = PromoteAds::with(['get_adPost', 'get_adPackage'])->whereHas('get_adPost', function($query) use ($category_id){
                $query->where('status', 'active')->where(function ($q) use ($category_id) {
                   $q->orWhere('category_id', $category_id)->orWhere('subcategory_id', $category_id);
                });
            })->where('start_date', '<=', now())->where('end_date', '>=', now())->where('status', 1)->take(5)->get();
           
            return view('frontend.ads-details')->with($data);
        }else{
            return view('404');
        }
    }

    public function moreProducts($slug)
    {
        $data['section'] = HomepageSection::where('slug', $slug)->where('status', 1)->first();
        if($data['section']){
            if($slug == 'recommended-for-you'){
                $data['products'] = Product::with(['brand_id','offer_discount.offer:id'])->where('status', 'active')->selectRaw('id,title,selling_price,discount,discount_type, slug,brand_id, feature_image')->orderBy('views', 'desc')->paginate(16);
            }else {
                $data['products'] = Product::with('offer_discount.offer:id')->whereIn('id', explode(',', $data['section']->product_id))->orderBy('id', 'desc')->where('status', 'active')->paginate(16);
            }
            return view('frontend.homepage.moreProducts')->with($data);
        }
        return view('frontend.404');
    }

    public function quickview(Request $request, $slug){
        $data['product'] = Product::with('user:id,name','get_category:id,name','get_features')->where('slug', $slug)->first();
        $data['type'] = ($request->type) ? $request->type : 'on';
        $data['offer'] = $request->offer ? $request->offer : null;
        if($data['product']) {
            return view('frontend.products.quickview-iframe')->with($data);
        }else{
            return 'Product not found.';
        }
    }
}
