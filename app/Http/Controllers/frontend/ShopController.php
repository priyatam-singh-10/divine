<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop() {
        return view('frontend.' . get_frontend_settings('theme') . '.shop.shop');
    }

    public function detail() {
        return view('frontend.' . get_frontend_settings('theme') . '.shop.detail');
    }
}


?>