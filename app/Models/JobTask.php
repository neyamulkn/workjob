<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTask extends Model
{
    use HasFactory;

    public  function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public  function job(){
        return $this->belongsTo(Product::class, 'job_id');
    }
}
