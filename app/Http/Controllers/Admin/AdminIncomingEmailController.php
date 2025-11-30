<?php

namespace App\Http\Controllers\Admin;

use App\Models\IncomingEmail;
use App\Models\EmailTag;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\ProspectusRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminIncomingEmailController extends Controller
{
    /**
     * Display inbox with all incoming emails
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'inbox');
        $search = $request->get('search');

        $query = IncomingEmail::query();

        // Filter by status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('from_email', 'like', "%$search%")
                  ->orWhere('from_name', 'like', "%$search%")
                  ->orWhere('subject', 'like', "%$search%")
                  ->orWhere('message', 'like', "%$search%");
            });
        }

        // Get statistics
        $stats = [
            'total' => IncomingEmail::count(),
            'inbox_unread' => IncomingEmail::where('status', 'inbox')->where('is_read', false)->count(),
            'inbox_read' => IncomingEmail::where('status', 'inbox')->where('is_read', true)->count(),
            'sent' => IncomingEmail::where('status', 'sent')->count(),
            'draft' => IncomingEmail::where('status', 'draft')->count(),
            'trash' => IncomingEmail::where('status', 'trash')->count(),
            'spam' => IncomingEmail::where('status', 'spam')->count(),
            'starred' => IncomingEmail::where('is_starred', true)->count(),
        ];

        $emails = $query->recent()->paginate(15);

        // Get counts for sidebar
        $count_blogs = Blog::count();
        $contact_count = ContactUs::count();
        $prospectus_count = ProspectusRequest::count();

        return view('adminPortal.email.inbox', compact('emails', 'status', 'stats', 'search', 'count_blogs', 'contact_count', 'prospectus_count'));
    }

    /**
     * Display single email details
     */
    public function show($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();

        // Mark as read
        if (!$email->is_read) {
            $email->markAsRead();
        }

        $email->load('attachments', 'tags');

        // Get counts for sidebar
        $count_blogs = Blog::count();
        $contact_count = ContactUs::count();
        $prospectus_count = ProspectusRequest::count();

        return view('adminPortal.email.inbox-details', compact('email', 'count_blogs', 'contact_count', 'prospectus_count'));
    }

    /**
     * Mark email as read
     */
    public function markAsRead($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->markAsRead();

        return redirect()->back()->with('success', 'Email marked as read');
    }

    /**
     * Mark email as unread
     */
    public function markAsUnread($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->markAsUnread();

        return redirect()->back()->with('success', 'Email marked as unread');
    }

    /**
     * Toggle starred status
     */
    public function toggleStarred($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->toggleStarred();

        return redirect()->back()->with('success', $email->is_starred ? 'Email starred' : 'Email unstarred');
    }

    /**
     * Move to trash
     */
    public function moveToTrash($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->moveToTrash();

        return redirect()->back()->with('success', 'Email moved to trash');
    }

    /**
     * Restore from trash
     */
    public function restoreFromTrash($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->restoreFromTrash();

        return redirect()->back()->with('success', 'Email restored from trash');
    }

    /**
     * Mark as spam
     */
    public function markAsSpam($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->markAsSpam();

        return redirect()->back()->with('success', 'Email marked as spam');
    }

    /**
     * Bulk mark as read
     */
    public function bulkMarkAsRead(Request $request)
    {
        $ids = $request->get('ids', []);
        IncomingEmail::whereIn('uuid', $ids)->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Emails marked as read']);
    }

    /**
     * Bulk move to trash
     */
    public function bulkMoveToTrash(Request $request)
    {
        $ids = $request->get('ids', []);
        IncomingEmail::whereIn('uuid', $ids)->update(['status' => 'trash']);

        return response()->json(['success' => true, 'message' => 'Emails moved to trash']);
    }

    /**
     * Permanently delete email
     */
    public function destroy($uuid)
    {
        $email = IncomingEmail::where('uuid', $uuid)->firstOrFail();
        $email->forceDelete();

        return redirect()->back()->with('success', 'Email permanently deleted');
    }

    /**
     * Empty trash
     */
    public function emptyTrash()
    {
        IncomingEmail::where('status', 'trash')->forceDelete();

        return redirect()->back()->with('success', 'Trash emptied');
    }

    /**
     * Fetch new emails from IMAP server
     */
    public function fetchNewEmails()
    {
        try {
            \Artisan::call('email:fetch-incoming', ['--limit' => 50]);
            $output = \Artisan::output();
            
            // Extract new count from output
            preg_match('/New emails: (\d+)/', $output, $matches);
            $newCount = $matches[1] ?? 0;
            
            return response()->json([
                'success' => true,
                'new_count' => (int)$newCount,
                'message' => "Fetched {$newCount} new emails"
            ]);
        } catch (\Exception $e) {
            \Log::error("Email fetch error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch emails: ' . $e->getMessage()
            ], 500);
        }
    }
}
