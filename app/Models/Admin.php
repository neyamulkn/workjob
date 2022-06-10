<?php

namespace App\Models;
use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];


    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }


}
