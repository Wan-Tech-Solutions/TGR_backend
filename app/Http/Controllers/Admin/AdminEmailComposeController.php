<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\SentEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminEmailComposeController extends Controller
{
    public function compose(Request $request)
    {
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        // Check if composing a reply to a contact
        $recipientEmail = $request->query('to');
        $subject = $request->query('subject');
        $showOriginal = false;
        $originalName = null;
        $originalDate = null;
        $originalSubject = null;
        $originalMessage = null;

        // If replying to a contact response
        if ($recipientEmail && $request->query('contact_id')) {
            $contact = ContactUs::find($request->query('contact_id'));
            if ($contact) {
                $showOriginal = true;
                $recipientEmail = $contact->email;
                $originalName = $contact->full_name;
                $originalDate = $contact->created_at->format('M d, Y h:i A');
                $originalSubject = $contact->subject;
                $originalMessage = $contact->message;
                $subject = 'Re: ' . $contact->subject;
            }
        }

        return view('adminPortal.email.compose', compact(
            'count_blogs',
            'contact_count',
            'founder_count',
            'prospectus_count',
            'recipientEmail',
            'subject',
            'showOriginal',
            'originalName',
            'originalDate',
            'originalSubject',
            'originalMessage'
        ));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'cc' => 'nullable|email',
            'bcc' => 'nullable|email',
        ]);

        // Create email tracking record first (pending status)
        $emailLog = SentEmail::create([
            'uuid' => Str::uuid(),
            'sender_id' => Auth::id(),
            'recipient_email' => $validated['to'],
            'recipient_name' => null,
            'subject' => $validated['subject'],
            'message' => $validated['body'],
            'cc' => $validated['cc'] ?? null,
            'bcc' => $validated['bcc'] ?? null,
            'status' => 'pending',
        ]);

        try {
            // Prepare mail data
            $mailData = [
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'from' => config('mail.from.address'),
            ];

            // Send email
            $mailer = Mail::to($validated['to']);
            
            if ($validated['cc'] ?? null) {
                $mailer->cc($validated['cc']);
            }
            
            if ($validated['bcc'] ?? null) {
                $mailer->bcc($validated['bcc']);
            }

            $mailer->send(new \App\Mail\AdminEmail($mailData));

            // Update email log to sent status
            $emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return redirect()->route('admin.email.compose')
                ->with('success', 'Email sent successfully to ' . $validated['to']);

        } catch (\Exception $e) {
            // Log error and update email log to failed status
            \Log::error('Email sending failed: ' . $e->getMessage());
            
            $emailLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to send email. Please try again later.');
        }
    }
}
