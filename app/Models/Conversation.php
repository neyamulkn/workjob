<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
class Conversation extends Model
{
    use HasFactory;

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'conversion_id')->orderBy('id', 'desc');
    }

    public function unreadMessages(){
        return $this->hasMany(Message::class, 'conversion_id')->orderBy('id', 'desc')->where('is_seen', 0);
    }

    public function last_message(){
        return $this->hasOne(Message::class, 'conversion_id')->orderBy('id', 'desc');
    }
    
}
