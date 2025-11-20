<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
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

        // Send email to info@tgrafrica.com
        Mail::send('emails.contact', $validated, function ($message) use ($validated) {
            $message->to('info@tgrafrica.com')
                ->subject('New Contact Us Message');
        });
        return back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }
}
