<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageValue extends Model
{
    use HasFactory;

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function get_packageType(){
        return $this->belongsTo(Package::class, 'package_id');
    }
}
