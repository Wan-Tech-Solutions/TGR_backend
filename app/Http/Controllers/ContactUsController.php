<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        $data = ContactUs::latest()->paginate(10);
        return view('admin.layouts.contactus.contact_us', compact('data'));
    }

    // public function store(Request $request)
    // {
    //     // Validate request data
    //     $validated = $request->validate([
    //         'full_name' => 'required',
    //         'email' => 'required|email',
    //         'country_of_residence' => 'required',
    //         'nationality' => 'required',
    //         'message' => 'required',
    //         'subject' => 'required',
    //     ]);

    //     // Save the data to the database
    //     ContactUs::create([
    //         'full_name' => $request->full_name,
    //         'email' => $request->email,
    //         'country_of_residence' => $request->country_of_residence,
    //         'nationality' => $request->nationality,
    //         'subject' => $request->subject,
    //         'message' => $request->message,
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Your message has been sent successfully!');
    // }

    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'country_of_residence' => 'required',
            'nationality' => 'required',
            'message' => 'required',
            'subject' => 'required',
        ]);
        // Save the data to the database
        ContactUs::create($validated);
        // Email content
        $messageContent = $validated;
        // Send email to admin
        Mail::to('info@tgrafrica.com')->send(new \App\Mail\ContactUsNotification($messageContent));
        // Send auto-reply to the user
        Mail::to($validated['email'])->send(new \App\Mail\AutoReplyNotification($messageContent));
        return redirect()->route('contact-thank-you-message')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    public function thankyoucontact()
    {
        return view('website.thankyoucontact');
    }
}
