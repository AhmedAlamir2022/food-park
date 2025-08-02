<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public  function index()
    {
        $sliders = Slider::where('status', 1)->get();
        return view('frontend.home.index', compact('sliders'));
    }
}