<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\NewsLetter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsLetterController extends Controller
{
    function index()
    {
        $subscribers = Subscriber::latest()->paginate(10);
        return view('admin.news-letter.index', compact('subscribers'));
    }

    function sendNewsLetter(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);

        $subscribers = Subscriber::pluck('email')->toArray();

        Mail::to($subscribers)->send(new NewsLetter($request->subject, $request->message));

        toastr()->success('News letter sent successfully!');

        return redirect()->back();
    }
}
