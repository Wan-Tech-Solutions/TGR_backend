<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SentEmail;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function sendMail(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('emails', 'public');
        }

        SentEmail::create([
            'recipient_email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachment' => $filePath
        ]);

        Mail::to($request->email)->send(new SendEmail($request->subject, $request->message, $filePath));

        return response()->json(['message' => 'Email sent successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Email sending failed: ' . $e->getMessage()], 500);
    }
}
}
