<?php

namespace App\Http\Controllers;

use App\Models\Banner;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\State;
use App\Models\FavoriteSeller;
use App\User;
use Auth;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function userProfile($username){
        $data['user'] = User::where('username', $username)->first();
        if($data['user']){
            $data['sections'] = HomepageSection::where('page_name', $username)->where('status', 1)->orderBy('position', 'asc')->get();
            $data['follower'] = FavoriteSeller::where('follower_id', $data['user']->id)->count();

            $data['following'] = FavoriteSeller::where('user_id', $data['user']->id)->count();

            $data['total_blogs'] = Blog::where('user_id', $data['user']->id)->where('status', 'active')->count();
            $data['posts'] = Product::where('user_id', $data['user']->id)->where('status', 'active')->orderBy('views', 'desc')->paginate(10);
            return view('frontend.user.user_profile')->with($data);
        }
       

        return view('404');
    }

    public function follower(Request $request)
    {
        $user_id = Auth::user()->id;
        $follow = FavoriteSeller::where('user_id', $user_id)->where('follower_id', $request->follower_id)->first();

        if($user_id != $request->follower_id){
            if(!$follow){
                $follow = new FavoriteSeller();
                $follow->user_id = $user_id;
                $follow->follower_id = $request->follower_id;
                $follow->save();
                $output = [
                    'status' => true,
                    'msg' => '<i class="fa fa-thumbs-down"></i> Unfollow'
                ];
            }else{
                $follow->delete();
                $output = [
                    'status' => true,
                    'msg' => '<i class="fa fa-thumbs-up"></i> Follow'
                ];
            }
        }else{
            $output = [
                'status' => false,
            ];  
        }

        return response()->json($output);
    }
}
