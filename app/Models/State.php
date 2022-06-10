<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class State extends Model
{
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function get_city(){
        return $this->hasMany(City::class, 'state_id')->where('status', 1);
    }

    public function productsByState(){
        $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
        $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2);
        return $this->hasMany(Product::class, 'state_id')->orderBy('id', 'desc')->where('status', '=', 'active')->where('status', '=', 'active')->where('approved', '>=', $ads_duration);
    }
    

    public $timestamps = false;
}
