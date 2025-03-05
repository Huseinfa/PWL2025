<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function foodBeverage()
    {
        return view('foodbeverage');
    }

    public function beautyhealth()
    {
        return view('beautyhealth');
    }

    public function homeCare()
    {
        return view('homecare');
    }

    public function babyKid()
    {
        return view('babykid');
    }
}
