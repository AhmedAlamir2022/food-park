<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppDownloadSection;
use App\Models\BannerSlider;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Counter;
use App\Models\Coupon;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Illuminate\Http\RedirectResponse;
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
        $dailyOffers = DailyOffer::with('product')->where('status', 1)->take(15)->get();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $bannerSliders = BannerSlider::where('status', 1)->latest()->take(10)->get();
        $chefs = Chef::where(['show_at_home' => 1, 'status' => 1])->get();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();
        $appSection = AppDownloadSection::first();
        $counter = Counter::first();
        $latestBlogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1)->latest()->take(3)->get();
        return view('frontend.home.index', compact(
            'sliders',
            'whyChooseUs',
            'sectionTitles',
            'categories',
            'dailyOffers',
            'bannerSliders',
            'chefs',
            'appSection',
            'testimonials',
            'counter',
            'latestBlogs'
        ));
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
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        return SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
    }

    function chef()
    {
        $chefs = Chef::where(['status' => 1])->paginate(12);
        return view('frontend.pages.chefs', compact('chefs'));
    }

    function testimonial()
    {
        $testimonials = Testimonial::where(['status' => 1])->paginate(9);
        return view('frontend.pages.testimonial', compact('testimonials'));
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

    function loadProductModal($productId)
    {
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($productId);

        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render();
    }

    function applyCoupon(Request $request)
    {

        $subtotal = $request->subtotal;
        $code = $request->code;

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid Coupon Code.'], 422);
        }
        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon has been fully redeemed.'], 422);
        }
        if ($coupon->expire_date < now()) {
            return response(['message' => 'Coupon hs expired.'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = number_format($subtotal * ($coupon->discount / 100), 2);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = number_format($coupon->discount, 2);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);

        return response(['message' => 'Coupon Applied Successfully.', 'discount' => $discount, 'finalTotal' => $finalTotal, 'coupon_code' => $code]);
    }

    function destroyCoupon()
    {
        try {
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grand_cart_total' => grandCartTotal()]);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something went wrong']);
        }
    }

    function blog(Request $request)
    {
        $blogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1);

        if ($request->has('search') && $request->filled('search')) {
            $blogs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->filled('category')) {
            $blogs->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        $blogs = $blogs->latest()->paginate(9);
        $categories = BlogCategory::where('status', 1)->get();
        return view('frontend.pages.blog', compact('blogs', 'categories'));
    }

    function blogDetails(string $slug)
    {
        $blog = Blog::with(['user'])->where('slug', $slug)->where('status', 1)->firstOrFail();
        $comments = $blog->comments()->where('status', 1)->orderBy('id', 'DESC')->paginate(20);

        $latestBlogs = Blog::select('id', 'title', 'slug', 'created_at', 'image')
            ->where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()->take(5)->get();
        $categories = BlogCategory::withCount(['blogs' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();

        $nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'ASC')->first();
        $previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();


        return view('frontend.pages.blog-details', compact('blog', 'latestBlogs', 'categories', 'nextBlog', 'previousBlog', 'comments'));
    }

    function blogCommentStore(Request $request, string $blog_id): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'max:500']
        ]);

        Blog::findOrFail($blog_id);

        $comment = new BlogComment();
        $comment->blog_id = $blog_id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        toastr()->success('Comment submitted successfully and waiting to approve.');
        return redirect()->back();
    }
}