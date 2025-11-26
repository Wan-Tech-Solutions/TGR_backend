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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'country_of_residence' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'subject' => 'required|string|max:255',
        ]);

        try {
            // Save the data to the database
            $contact = ContactUs::create($validated);

            // Email content
            $messageContent = $validated;

            // Try to send email to admin
            try {
                Mail::to('info@tgrafrica.com')->send(new \App\Mail\ContactUsNotification($messageContent));
            } catch (\Exception $e) {
                \Log::error('Failed to send admin notification: ' . $e->getMessage());
                // Continue even if admin email fails
            }

            // Try to send auto-reply to the user
            try {
                Mail::to($validated['email'])->send(new \App\Mail\AutoReplyNotification($messageContent));
            } catch (\Exception $e) {
                \Log::error('Failed to send user auto-reply: ' . $e->getMessage());
                // Continue even if user email fails
            }

            return redirect()->route('contact-thank-you-message')
                ->with('success', 'Your message has been received successfully! We will get back to you soon.');

        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }

    public function thankyoucontact()
    {
        return view('website.thankyoucontact');
    }
}
