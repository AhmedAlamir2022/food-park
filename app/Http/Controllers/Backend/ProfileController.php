<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUploadTrait;


    function index()
    {
        return view('admin.profile.index');
    }

    function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = Auth::user();
        $imagePath = $this->uploadImage($request, 'avatar');

        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = isset($imagePath) ? $imagePath : $user->avatar;
        $user->save();

        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }

    function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:5', 'confirmed'],
        ]);


        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        toastr()->success('Password Updated Successfully');

        return redirect()->back();
    }
}