<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isOnline(){
        return Cache::has('UserOnline-'.$this->id);
    }

    public function get_country(){
        return $this->hasOne(Country::class, 'id','country');
    }

    public function jobs(){
        return $this->hasMany(Product::class, 'user_id');
    }

    public function get_state(){
        return $this->hasOne(State::class, 'id', 'region');
    }
    public function get_city(){
        return $this->hasOne(City::class, 'id', 'city');
    }
    public function get_area(){
        return $this->hasOne(Area::class, 'id','area');
    }

    public function get_p_state(){
        return $this->hasOne(State::class, 'id', 'p_region');
    }
    public function get_p_city(){
        return $this->hasOne(City::class, 'id', 'p_city');
    }
    public function get_p_area(){
        return $this->hasOne(Area::class, 'id','p_area');
    }
}
