<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PackagePurchase extends Model
{
  
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_package(){
        return $this->belongsTo(Package::class, 'package_id');
    } 

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function get_boostAd(){
        return $this->belongsTo(Product::class, 'purchase_for');
    }

    public function packageCancelReason(){
        return $this->hasMany(OrderCancelReason::class, 'order_id', 'order_id');
    }

    public function packageNotify(){
        return $this->hasMany(Notification::class, 'item_id', 'order_id');
    }




}
