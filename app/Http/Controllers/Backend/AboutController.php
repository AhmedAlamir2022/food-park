<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }

    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['nullable', 'image'],
            'title' => ['required', 'max:255'],
            'main_title' => ['required', 'max:255'],
            'description' => ['required'],
            'video_link' => ['required', 'url'],
        ]);
        
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        About::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ? $imagePath : $request->old_image,
                'title' => $request->title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'video_link' => $request->video_link
            ]
        );

        toastr()->success('Created Successfully');

        return redirect()->back();
    }
}
