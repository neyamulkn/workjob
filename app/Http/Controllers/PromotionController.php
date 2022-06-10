<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function boostPlan(){
        return view('users.boost-plan');
    } 
}
