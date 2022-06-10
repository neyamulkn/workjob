<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class PromoteAds extends Model
{
    use HasFactory;

    public function get_adPackage(){
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function get_packagePurchase(){
        return $this->belongsTo(PackagePurchase::class, 'order_id', 'order_id');
    }

    public function get_adPost(){
        return $this->belongsTo(Product::class, 'ads_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
