<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
        $categories = Category::where(['show_at_home' => 1, 'status' => 1])
            ->with(['products' => function ($query) {
                $query->where('show_at_home', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->take(8)
                    // ->withAvg('reviews', 'rating')
                    // ->withCount('reviews')
                    ->with('category'); // optional, if needed
            }])
            ->get();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        return view('frontend.home.index', compact('sliders', 'whyChooseUs', 'sectionTitles', 'categories'));
    }

    function getSectionTitles(): Collection
    {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'product_top_title',
            'product_main_title',
            'product_sub_title',
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

        return SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
    }


    function showProduct(string $slug)
    {
        $product = Product::with([
            'productImages',
            'productSizes',
            'productOptions'
        ])->where(['slug' => $slug, 'status' => 1])
            // ->withAvg('reviews', 'rating')
            // ->withCount('reviews')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->take(8)
            // ->withAvg('reviews', 'rating')
            // ->withCount('reviews')
            ->latest()->get();
        // $reviews = ProductRating::where(['product_id' => $product->id, 'status' => 1])->paginate(30);
        return view('frontend.pages.product-view', compact('product', 'relatedProducts'));
    }

    function products(Request $request)
    {

        $products = Product::where(['status' => 1])->orderBy('id', 'DESC');

        if ($request->has('search') && $request->filled('search')) {
            $products->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('long_description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->filled('category')) {
            $products->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        $products = $products
        ->with('category')
        // ->withAvg('reviews', 'rating')
        // ->withCount('reviews')
        ->paginate(12);

        $categories = Category::where('status', 1)->get();

        return view('frontend.pages.product', compact('products', 'categories'));
    }
}
