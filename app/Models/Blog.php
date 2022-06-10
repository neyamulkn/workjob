<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Blog extends Model
{
    use HasFactory;

    public  function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }


    public  function comments(){
        return $this->hasMany(BlogComment::class, 'blog_id');
    }
    
}
