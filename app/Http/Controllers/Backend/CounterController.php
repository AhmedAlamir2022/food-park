<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    use FileUploadTrait;

    function index()
    {
        $counter = Counter::first();
        return view('admin.counter.index', compact('counter'));
    }

    function update(Request $request)
    {
        $request->validate([
            'background' => ['nullable', 'image'],

            'counter_icon_one' => ['required', 'max:255'],
            'counter_count_one' => ['required', 'numeric'],
            'counter_name_one' => ['required', 'max:255'],

            'counter_icon_two' => ['required', 'max:255'],
            'counter_count_two' => ['required', 'numeric'],
            'counter_name_two' => ['required', 'max:255'],

            'counter_icon_three' => ['required', 'max:255'],
            'counter_count_three' => ['required', 'numeric'],
            'counter_name_three' => ['required', 'max:255'],

            'counter_icon_four' => ['required', 'max:255'],
            'counter_count_four' => ['required', 'numeric'],
            'counter_name_four' => ['required', 'max:255'],
        ]);

        $imagePath = $this->uploadImage($request, 'background', $request->old_background);

        Counter::updateOrCreate(
            ['id' => 1],
            [
                'background' => !empty($imagePath) ? $imagePath : $request->old_background,
                'counter_icon_one' => $request->counter_icon_one,
                'counter_count_one' => $request->counter_count_one,
                'counter_name_one' => $request->counter_name_one,

                'counter_icon_two' => $request->counter_icon_two,
                'counter_count_two' => $request->counter_count_two,
                'counter_name_two' => $request->counter_name_two,

                'counter_icon_three' => $request->counter_icon_three,
                'counter_count_three' => $request->counter_count_three,
                'counter_name_three' => $request->counter_name_three,

                'counter_icon_four' => $request->counter_icon_four,
                'counter_count_four' => $request->counter_count_four,
                'counter_name_four' => $request->counter_name_four,
            ]
        );

        toastr()->success('Updated Successfully!');

        return redirect()->back();
    }
}
