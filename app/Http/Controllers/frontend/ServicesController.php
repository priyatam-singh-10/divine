<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function hypnosis() {
        return view('frontend.' . get_frontend_settings('theme') . '.services.hypnosis');
    }

    public function reiki() {
        return view('frontend.' . get_frontend_settings('theme') . '.services.reiki');
    }

    public function healing() {
        return view('frontend.' . get_frontend_settings('theme') . '.services.healing');
    }

    public function nlp() {
        return view('frontend.' . get_frontend_settings('theme') . '.services.nlp');
    }

    public function yoga() {
        return view('frontend.' . get_frontend_settings('theme') . '.services.yoga');
    }
}


?>