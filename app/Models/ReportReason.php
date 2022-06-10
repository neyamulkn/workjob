<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class ReportReason extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    } 

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
