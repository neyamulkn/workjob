<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Toastr;
use Auth;
class FrontPagesController extends Controller
{
    // all custom page display in
    public function page($slug)
    {
        $data['page'] = Page::where('slug', $slug)->where('status', 1)->first();
        if($data['page']){
            $slug = ($data['page']->is_default == 1) ? $data['page']->slug : 'page';
            //get this site banner
            $data['banners'] = Banner::where('page_name', $data['page']->id)->orderBy('position', 'asc')->where('status', 1)->get();
            return view('frontend.pages.'.$slug)->with($data);
        }
        return view('404');
    }

    public function faq(Request $request){
        $data['page'] = Page::where('slug', 'faq')->where('status', 1)->first();
        if($data['page']){
        $data['banners'] = Banner::where('page_name', $data['page']->id)->orderBy('position', 'asc')->where('status', 1)->get();
        return view('frontend.pages.faq')->with($data);
        }
        return view('404');
    }

    public function blog(Request $request, string $catSlug=null)
    {
        $data['categories'] = Category::withCount('blogsByCategory')->where('parent_id', null)->where('status', 1)->get();
        $blogs = Blog::where('status', 'active');
        $popular_blogs = Blog::where('status', 'active')->orderBy('views', 'desc');


        if ($request->keyword) {
            $blogs->where('title', 'like', '%' . $request->keyword . '%');
        }

        $data['category'] = Category::where('slug', $catSlug)->first();
        if($data['category']){
            $blogs->where('category_id', $data['category']->id);
            $popular_blogs->where('category_id', $data['category']->id);
        }

        $data['blogs'] =  $blogs->paginate(10);
        $data['popular_blogs'] =  $blogs->take(3)->get();
        return view('frontend.blog.blog')->with($data);
    }

    public function blog_details($slug)
    {
        $data['blog'] = Blog::where('status', 'active')->where('slug', $slug)->first();
        if($data['blog']){
            $data['blog']->increment('views'); // news view count
            $data['totalComment'] = BlogComment::where('blog_id', $data['blog']->id)->whereNull('comment_id')->count();
            $data['comments'] = BlogComment::with('replyComments')->where('blog_id', $data['blog']->id)->whereNull('comment_id')->orderBy('id', 'desc')->take(5)->get();


            $data['related_blogs'] = Blog::where('category_id', $data['blog']->category_id)->where('id', '!=', $data['blog']->id)->where('status', 'active')->orderBy('views', 'desc')->take('3')->get();
           
            return view('frontend.blog.blog-details')->with($data);
        }
        Toastr::error('Blog not found.');
        return view('404');
    }

    public function blog_comment_insert(Request $request)
    {
        $user_id = Auth::id();

        $comment = new BlogComment();
        $comment->user_id = $user_id;
        $comment->blog_id = $request->blog_id;
        $comment->comments = $request->comment;
        $comment->save();

        if($comment){
            return view('frontend.blog.comment.show_comment')->with(compact('comment'));
        }

        return back();
    }

    public function blog_comments($slug)
    {
        $data['blog'] = Blog::where('status', 'active')->where('slug', $slug)->first();
        if($data['blog']){
            $data['totalComment'] = BlogComment::where('blog_id', $data['blog']->id)->whereNull('comment_id')->count();
            $data['comments'] = BlogComment::with('replyComments')->where('blog_id', $data['blog']->id)->whereNull('comment_id')->orderBy('id', 'desc')->paginate(5);

            return view('frontend.blog.comment.comments')->with($data);
        }
        Toastr::error('Blog not found.');
        return view('404');
    }

    // get top brand
    public function topBrand ()
    {
        $data['brands'] = Brand::leftJoin('products', 'products.brand_id', 'brands.id')
            ->leftJoin('order_details', 'products.id', 'order_details.product_id')
            ->where('brands.status', 1)
            ->selectRaw('brands.*, count(order_details.product_id)  as total_order')
            ->groupBy('brands.id')
            ->orderBy('total_order', 'desc')
            ->get();

        if($data['brands']){
            $data['page'] = Page::where('slug', \Request::segment(1))->where('status', 1)->first();
            $id = 0;
            if($data['page']){
                $id = $data['page']->id;
            }
            $data['banners'] = Banner::where('page_name', 'all')->orWhere('page_name', $id)->orderBy('position', 'asc')->where('status', 1)->where('status', 1)->get();
            return view('frontend.pages.top-brand')->with($data);
        }
        return view('404');
    }
    // get top brand
    public function brandProducts(Request $request, $slug)
    {
        $data['brand'] = Brand::where('slug', $slug)->first();

        if($data['brand']){
            $products = Product::with('offer_discount.offer:id')->where('brand_id', $data['brand']->id);
            //check search keyword
            if ($request->q) {
                $products->where('title', 'like', '%' . $request->q . '%');
            }
            //check ratting
            if ($request->ratting) {
                $products->where('avg_ratting', $request->ratting);
            }
            $field = 'id'; $value = 'desc';
            if (isset($request->sortby) && $request->sortby) {
                try {
                    $sort = explode('-', $request->sortby);
                    if ($sort[0] == 'name') {
                        $field = 'title';
                    } elseif ($sort[0] == 'price') {
                        $field = 'selling_price';
                    } elseif ($sort[0] == 'ratting') {
                        $field = 'avg_ratting';
                    } else {
                        $field = 'id';
                    }
                    $value = ($sort[1] == 'a' || $sort[1] == 'l') ? 'asc' : 'desc';
                    $products->orderBy($field, $value);
                }catch (\Exception $exception){}
            }
            $products->orderBy($field, $value);

            //check price keyword
            if ($request->price) {
                $price = explode(',', $request->price);
                $products->whereBetween('selling_price', [$price[0], $price[1]]);
            }

            //check perPage
            $perPage = 15;
            if (isset($request->perPage) && $request->perPage) {
                $perPage = $request->perPage;
            }
            $data['products'] = $products->where('status', 'active')->paginate($perPage);

            if($request->filter){
                return view('frontend.products.filter_products')->with($data);
            }else{
                return view('frontend.pages.brandProducts')->with($data);
            }
        }
        return view('404');
    }

    public function error404(){
        return view('404');
    }
}
