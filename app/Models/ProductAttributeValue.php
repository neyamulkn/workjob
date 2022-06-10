<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValue extends Model
{
    //use SoftDeletes;
    protected $guarded = [];

    public function get_attribute(){
        return $this->belongsTo(ProductAttribute::class);
    }
    //get attribute value by product
    public function get_variantProducts(){
        return $this->hasMany(ProductVariationDetails::class, 'attributeValue_name', 'id');
    }

    //get attribute variation value by product
    public function get_productVariant(){
        return $this->hasOne(ProductVariationDetails::class, 'attributeValue_name', 'id');
    }

}
