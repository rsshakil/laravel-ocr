<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiocrController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $active = 'dashboard';
        return view('frontend.home',compact('title','active'));

    }
}
