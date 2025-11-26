<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SentEmail;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use Illuminate\Http\Request;

class AdminEmailTrackingController extends Controller
{
    /**
     * Display all emails with tracking
     */
    public function index(Request $request)
    {
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        // Get filter parameter
        $status = $request->query('status');
        
        $query = SentEmail::latest();

        // Apply status filter
        if ($status && in_array($status, ['sent', 'pending', 'failed'])) {
            $query->where('status', $status);
        }

        $emails = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => SentEmail::count(),
            'sent' => SentEmail::sent()->count(),
            'pending' => SentEmail::pending()->count(),
            'failed' => SentEmail::failed()->count(),
        ];

        return view('adminPortal.email.tracking', compact(
            'emails',
            'stats',
            'status',
            'count_blogs',
            'contact_count',
            'founder_count',
            'prospectus_count'
        ));
    }

    /**
     * Show detailed view of a single email
     */
    public function show($uuid)
    {
        $email = SentEmail::where('uuid', $uuid)->firstOrFail();

        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.email.details', compact(
            'email',
            'count_blogs',
            'contact_count',
            'founder_count',
            'prospectus_count'
        ));
    }

    /**
     * Retry failed email
     */
    public function retry($uuid)
    {
        $email = SentEmail::where('uuid', $uuid)->firstOrFail();

        if ($email->status !== 'failed') {
            return redirect()->back()->with('error', 'Only failed emails can be retried.');
        }

        try {
            $mailData = [
                'subject' => $email->subject,
                'body' => $email->message,
                'from' => config('mail.from.address'),
            ];

            $mailer = \Illuminate\Support\Facades\Mail::to($email->recipient_email);
            
            if ($email->cc) {
                $mailer->cc($email->cc);
            }
            
            if ($email->bcc) {
                $mailer->bcc($email->bcc);
            }

            $mailer->send(new \App\Mail\AdminEmail($mailData));

            // Update status to sent
            $email->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);

            return redirect()->back()->with('success', 'Email retried successfully.');

        } catch (\Exception $e) {
            $email->update([
                'error_message' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to retry email: ' . $e->getMessage());
        }
    }

    /**
     * Delete email record
     */
    public function destroy($uuid)
    {
        $email = SentEmail::where('uuid', $uuid)->firstOrFail();
        $email->delete();

        return redirect()->back()->with('success', 'Email record deleted successfully.');
    }
}
