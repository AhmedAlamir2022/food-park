<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppDownloadSection;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppDownloadSectionController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        $appSection = AppDownloadSection::first();
        return view('admin.app-download-section.index', compact('appSection'));
    }

    function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['nullable', 'image'],
            'background' => ['nullable', 'image'],
            'title' => ['required', 'max:255'],
            'short_description' => ['required', 'max:1000'],
            'play_store_link' => ['nullable', 'url'],
            'apple_store_link' => ['nullable', 'url'],
        ]);

        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);

        AppDownloadSection::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ?  $imagePath : $request->old_image,
                'background' => !empty($backgroundPath) ?  $backgroundPath : $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'apple_store_link' => $request->apple_store_link
            ]

        );

        toastr()->info('Updated Successfully!');

        return to_route('admin.app-download.index');
    }
}
