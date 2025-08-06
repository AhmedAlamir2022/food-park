<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    function index()
    {
        $contact = Contact::first();
        return view('admin.contact.index', compact('contact'));
    }

    function update(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_one' => ['nullable', 'max:50'],
            'phone_two' => ['nullable', 'max:50'],
            'mail_one' => ['nullable', 'max:255'],
            'mail_two' => ['nullable', 'max:255'],
            'address' => ['nullable', 'max:1000'],
            'map_link' => ['nullable']
        ]);

        Contact::updateOrCreate(
            ['id' => 1],
            [
                'phone_one' => $request->phone_one,
                'phone_two' => $request->phone_two,
                'mail_one' => $request->mail_one,
                'mail_two' => $request->mail_two,
                'address' => $request->address,
                'map_link' => $request->map_link
            ]
        );

        toastr()->success('Created Successfully');

        return redirect()->back();
    }
}