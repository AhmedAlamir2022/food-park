<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::latest()->paginate(10);
        return view('admin.blog.blog-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:blog_categories,name'],
            'status' => ['required', 'boolean']
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Created Successfully!');

        return to_route('admin.blog-category.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:blog_categories,name,'.$id],
            'status' => ['required', 'boolean']
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Update Successfully!');

        return to_route('admin.blog-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        try {
            $category = BlogCategory::findOrFail($id);
            $category->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
