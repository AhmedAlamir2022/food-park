<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    function index()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.privacy-policy.index', compact('privacyPolicy'));
    }

    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['required']
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content
            ]
        );
        toastr()->success('Updated Successfully');

        return redirect()->back();
    }
}
