<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\GeneralSetting;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Session::has('siteSetting')){
            Config::set('siteSetting', Session::get('siteSetting'));
            $website = '127.0.0.1';
            //preg_match("/[^\.\/]+\.[^\.\/]+$/", $_SERVER['HTTP_HOST'], $matches); if($matches){ if($matches[0] != $website){  header("Location: /"); exit(); } }
        }else{
            Session::put('siteSetting', GeneralSetting::first());
            Config::set('siteSetting', GeneralSetting::first());
        }
        view()->share('siteSetting', Session::get('siteSetting'));
    }
}
