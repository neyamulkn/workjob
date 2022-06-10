<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function get_packageVlues(){
        return $this->hasMany(PackageValue::class, 'package_id');
    }

    public function get_purchasePackages(){
        return $this->hasMany(PackagePurchase::class, 'package_id');
    }
}
