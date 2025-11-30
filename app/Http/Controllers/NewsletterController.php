<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Mail\UnsubscribeRequestMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Newsletter subscribe request received', ['email' => $request->input('email'), 'wantsJson' => $request->wantsJson()]);

        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        $subscriber = NewsletterSubscriber::create([
            'email' => $validated['email'],
            'token' => Str::random(40),
            'active' => true,
        ]);

        Log::info('Newsletter subscriber saved', ['id' => $subscriber->id, 'email' => $subscriber->email]);

        // If this was submitted via AJAX expecting JSON, return JSON so client-side handlers work.
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Thank you — you have been subscribed to our newsletter.'], 201);
        }

        return back()->with('newsletter_success', 'Thank you — you have been subscribed to our newsletter.');
    }

    public function index()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(50);
        // Prefer adminPortal view if present
        if (view()->exists('adminPortal.newsletter.index')) {
            return view('adminPortal.newsletter.index', compact('subscribers'));
        }
        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
            'send_to' => 'nullable|in:all,selected',
            'selected' => 'nullable|array',
            'selected.*' => 'integer',
            'reply_to' => 'nullable|email',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:5120',
        ]);

        Log::info('Admin requested newsletter send', ['subject' => $request->input('subject'), 'send_to' => $request->input('send_to')]);

        $query = NewsletterSubscriber::where('active', true);
        if (($data['send_to'] ?? 'all') === 'selected' && !empty($data['selected'])) {
            $query->whereIn('id', $data['selected']);
        }

        // If attachments were uploaded, store them so workers can access them.
        $storedAttachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (! $file->isValid()) continue;
                // store in storage/app/newsletter_attachments
                $path = $file->store('newsletter_attachments');
                $storedAttachments[] = $path;
            }
        }

        // Count recipients before chunking for feedback
        $totalRecipients = $query->count();

        $queued = 0;
        $failed = 0;
        $replyTo = $data['reply_to'] ?? null;

        // Chunk by models to have access to token
        $query->orderBy('id')->chunk(100, function ($subscribers) use ($data, $storedAttachments, $replyTo, &$queued, &$failed) {
            foreach ($subscribers as $sub) {
                try {
                    Mail::to($sub->email)->send(new \App\Mail\NewsletterMail($data['subject'], $data['body'], $sub->token, $storedAttachments, $replyTo));
                    $queued++;
                } catch (\Throwable $ex) {
                    Log::error('Failed to queue newsletter to recipient', [
                        'email' => $sub->email,
                        'error' => $ex->getMessage(),
                        'trace' => $ex->getTraceAsString(),
                    ]);
                    $failed++;
                }
            }
        });

        Log::info('Newsletter send summary', ['total' => $totalRecipients, 'queued' => $queued, 'failed' => $failed, 'attachments' => $storedAttachments]);

        return back()->with('newsletter_sent', "Newsletter queued: {$queued} of {$totalRecipients} recipients. Failures: {$failed}.");
    }

    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->first();
        if (! $subscriber) {
            return view('website.newsletter.unsubscribed', ['message' => 'Invalid unsubscribe link or already unsubscribed.']);
        }

        $subscriber->active = false;
        $subscriber->save();

        return view('website.newsletter.unsubscribed', ['message' => 'You have been unsubscribed from our mailing list.']);
    }

    // Admin action: mark a subscriber inactive
    public function adminUnsubscribe($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->active = false;
        $subscriber->save();

        return back()->with('newsletter_admin_action', 'Subscriber unsubscribed.');
    }

    // Admin action: delete a subscriber
    public function adminDelete($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->delete();

        return back()->with('newsletter_admin_action', 'Subscriber removed.');
    }

    public function adminReactivate($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->active = true;
        $subscriber->save();

        return back()->with('newsletter_admin_action', 'Subscriber reactivated.');
    }

    public function exportCsv(Request $request)
    {
        $filename = 'newsletter_subscribers_' . date('Y_m_d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['id', 'email', 'active', 'token', 'created_at', 'updated_at'];

        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            NewsletterSubscriber::orderBy('id')->chunk(200, function ($subs) use ($handle) {
                foreach ($subs as $sub) {
                    fputcsv($handle, [
                        $sub->id,
                        $sub->email,
                        $sub->active ? '1' : '0',
                        $sub->token,
                        $sub->created_at,
                        $sub->updated_at,
                    ]);
                }
            });

            fclose($handle);
        };

        // Apply active filter if requested (we use request param 'active' = 1)
        $activeOnly = request()->get('active');

        $callback = function () use ($columns, $activeOnly) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            $query = NewsletterSubscriber::orderBy('id');
            if ($activeOnly) {
                $query->where('active', true);
            }

            $query->chunk(200, function ($subs) use ($handle) {
                foreach ($subs as $sub) {
                    fputcsv($handle, [
                        $sub->id,
                        $sub->email,
                        $sub->active ? '1' : '0',
                        $sub->token,
                        $sub->created_at,
                        $sub->updated_at,
                    ]);
                }
            });

            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, $headers);
    }

    // Show public form to request an unsubscribe-by-email confirmation
    public function showUnsubscribeRequestForm()
    {
        return view('website.newsletter.request_unsubscribe');
    }

    // Handle unsubscribe-by-email request and send confirmation link
    public function sendUnsubscribeConfirmation(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = NewsletterSubscriber::where('email', $data['email'])->first();

        // Always show a generic success view to avoid revealing whether an email exists
        if ($subscriber) {
            // ensure token exists
            if (empty($subscriber->token)) {
                $subscriber->token = Str::random(40);
                $subscriber->save();
            }

            Mail::to($subscriber->email)->queue(new UnsubscribeRequestMail($subscriber->token));
        }

        return view('website.newsletter.unsubscribe_request_sent');
    }
}
