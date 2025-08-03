<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FrontendController extends Controller
{
    public  function index()
    {
        $sectionTitles = $this->getSectionTitles();
        $sliders = Slider::where('status', 1)->get();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        return view('frontend.home.index', compact('sliders', 'whyChooseUs', 'sectionTitles'));
    }

    function getSectionTitles() : Collection {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            // 'daily_offer_top_title',
            // 'daily_offer_main_title',
            // 'daily_offer_sub_title',
            // 'chef_top_title',
            // 'chef_main_title',
            // 'chef_sub_title',
            // 'testimonial_top_title',
            // 'testimonial_main_title',
            // 'testimonial_sub_title'
        ];

        return SectionTitle::whereIn('key', $keys)->pluck('value','key');
    }
}
