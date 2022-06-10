<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class BlogComment extends Model
{
    use HasFactory;

    public  function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public  function replyComments(){
        return $this->hasMany(BlogComment::class, 'comment_id')->where('status', 1);
    }
}
