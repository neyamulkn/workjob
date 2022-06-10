<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class City extends Model
{
    protected $guarded = [];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function productsByCity(){
        $ads_duration = SiteSetting::where('type', 'free_ads_limit')->first();
        $ads_duration =  Carbon::parse(now())->subDays($ads_duration->value2);
        return $this->hasMany(Product::class, 'city_id')->orderBy('id', 'desc')->where('status', '=', 'active')->where('status', '=', 'active')->where('approved', '>=', $ads_duration);
    }

    public $timestamps = false;
}
