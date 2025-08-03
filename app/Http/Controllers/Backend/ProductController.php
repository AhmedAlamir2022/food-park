<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $keys = ['product_top_title', 'product_main_title', 'product_sub_title'];
        $titles = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
        // $products = Product::latest()->paginate(10);
        return view('admin.product.index', compact('products', 'titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request): RedirectResponse
    {
        // dd($request->all());
        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image');

        $product = new Product();
        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = generateUniqueSlug('Product', $request->name);
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price ?? 0;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;
        $product->save();

        toastr()->success('Create Successfully');

        return to_route('admin.product.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        /** Handle image file */
        $imagePath = $this->uploadImage($request, 'image', $product->thumb_image);

        $product->thumb_image = !empty($imagePath) ? $imagePath : $product->thumb_image;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price ?? 0;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;
        $product->save();

        toastr()->success('Update Successfully');

        return to_route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        try {
            $product = Product::findOrFail($id);
            $this->removeImage($product->thumb_image);
            $product->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'product_top_title' => ['max:100'],
            'product_main_title' => ['max:200'],
            'product_sub_title' => ['max:500']
        ]);

        SectionTitle::updateOrCreate(
            ['key' => 'product_top_title'],
            ['value' => $request->product_top_title]
        );

        SectionTitle::updateOrCreate(
            ['key' => 'product_main_title'],
            ['value' => $request->product_main_title]
        );

        SectionTitle::updateOrCreate(
            ['key' => 'product_sub_title'],
            ['value' => $request->product_sub_title]
        );

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }
}