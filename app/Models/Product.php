<?php

namespace App\Models;

use App\User;
use App\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function get_subcategory(){
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function get_childcategory(){
        return $this->belongsTo(Category::class, 'childcategory_id');
    }


    public  function author(){
        return $this->belongsTo(User::class, 'user_id');
    }public  function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public  function jobTasks(){
        return $this->hasMany(JobTask::class, 'job_id')->where('status', '!=', 'reject');
    }

    public  function userJobTask(){
        return $this->hasOne(JobTask::class, 'job_id');
    }

    public  function get_country(){
        return $this->belongsTo(State::class, 'location');
    }
    public  function get_state(){
        return $this->belongsTo(State::class, 'state_id');
    }
    public  function get_city(){
        return $this->belongsTo(City::class, 'city_id');
    }


    public function reviews(){
        return $this->hasMany(Review::class)->where('status', 1);
    }

    public function videos(){
        return $this->hasMany(ProductVideo::class);
    }




}
