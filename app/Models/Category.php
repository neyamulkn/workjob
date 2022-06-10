<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Category extends Model
{
    //use SoftDeletes;
    protected $guarded = [];



    public function get_category(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function get_singleSubcategory(){
        return $this->hasOne(Category::class, 'id','parent_id')->where('status', 1);
    }

    public function get_subcategory(){
        return $this->hasMany(Category::class, 'parent_id')->where('status', 1);
    }

    public function get_singleChildCategory(){
        return $this->hasOne(Category::class, 'id', 'subcategory_id')->where('status', 1);
    }

    public function get_subchild_category(){
        return $this->hasMany(Category::class, 'subcategory_id')->where('status', 1);
    }
    public function products(){
        return $this->hasMany(Product::class, 'category_id');
    }

    


    public function productsByCategory(){
        $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
        $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2);
        return $this->hasMany(Product::class, 'category_id')->orderBy('id', 'desc')->where('status', '=', 'active')->where('approved', '>=', $ads_duration);
    }
    public function productsBySubcategory(){
        $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
        $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2);
        return $this->hasMany(Product::class, 'subcategory_id')->orderBy('id', 'desc')->where('status', '=', 'active')->where('approved', '>=', $ads_duration);
    }
    public function productsByChildCategory(){
        return $this->hasMany(Product::class, 'childcategory_id')->orderBy('id', 'desc')->where('status', '=', 'active');
    }

    public function banners(){
        return $this->hasMany(Banner::class, 'page_name', 'slug')->where('status', 1);
    }    

    public function blogsByCategory(){
        return $this->hasMany(Blog::class, 'category_id')->orderBy('id', 'desc')->where('status', '=', 'active');
    }

    public function get_banner(){
        return $this->hasOne(Banner::class, 'page_name', 'slug')->where('status', 1);
    }
}
