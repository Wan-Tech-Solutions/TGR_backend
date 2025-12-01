<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;


class EventController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'event_date' => 'required|date',
        'event_time' => 'required',
        'event_title' => 'required|string',
        'event_people' => 'nullable|string',
        'status' => 'required|string',
        'send_notification' => 'nullable',
        'description' => 'nullable|string',
        'location' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
        'priority' => 'nullable|in:low,medium,high',
        'color' => 'nullable|string',
        'additional_emails' => 'nullable|string',
    ]);

    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $attachmentPath = $file->store('event_attachments', 'public');
    }

    $event = Event::create([
        'event_date' => $request->event_date,
        'event_time' => $request->event_time,
        'event_title' => $request->event_title,
        'event_people' => $request->event_people,
        'status' => $request->status,
        'description' => $request->description,
        'location' => $request->location,
        'attachment' => $attachmentPath,
        'priority' => $request->priority ?? 'medium',
        'color' => $request->color ?? '#d93025',
        'additional_emails' => $request->additional_emails,
    ]);

    // Send email notifications if requested
    if ($request->send_notification || $request->additional_emails) {
        $totalSent = 0;
        $allEmails = [];
        
        // Get newsletter subscribers if checkbox is checked
        if ($request->send_notification) {
            $subscribers = \App\Models\NewsletterSubscriber::where('active', true)->get();
            $allEmails = $subscribers->pluck('email')->toArray();
        }
        
        // Add additional custom emails
        if ($request->additional_emails) {
            $customEmails = array_map('trim', explode(',', $request->additional_emails));
            $customEmails = array_filter($customEmails, function($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
            $allEmails = array_merge($allEmails, $customEmails);
        }
        
        // Remove duplicates
        $allEmails = array_unique($allEmails);
        
        // Send to all emails
        foreach ($allEmails as $email) {
            try {
                \Mail::to($email)->send(new \App\Mail\EventNotification($event));
                $totalSent++;
            } catch (\Exception $e) {
                \Log::error('Failed to send event notification to ' . $email . ': ' . $e->getMessage());
            }
        }
        
        return response()->json([
            'message' => 'Event saved and ' . $totalSent . ' notification(s) sent successfully!'
        ]);
    }

    return response()->json(['message' => 'Event saved successfully!']);
}


public function show($id)
{
    $event = Event::findOrFail($id);
    return response()->json(['event' => $event]);
}

public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);
    
    $request->validate([
        'event_date' => 'required|date',
        'event_time' => 'required',
        'event_title' => 'required|string',
        'event_people' => 'nullable|string',
        'status' => 'required|string',
        'description' => 'nullable|string',
        'location' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
        'priority' => 'nullable|in:low,medium,high',
        'color' => 'nullable|string',
    ]);

    $attachmentPath = $event->attachment; // Keep existing attachment by default
    if ($request->hasFile('attachment')) {
        // Delete old attachment if exists
        if ($event->attachment && \Storage::disk('public')->exists($event->attachment)) {
            \Storage::disk('public')->delete($event->attachment);
        }
        
        $file = $request->file('attachment');
        $attachmentPath = $file->store('event_attachments', 'public');
    }

    $event->update([
        'event_date' => $request->event_date,
        'event_time' => $request->event_time,
        'event_title' => $request->event_title,
        'event_people' => $request->event_people,
        'status' => $request->status,
        'description' => $request->description,
        'location' => $request->location,
        'attachment' => $attachmentPath,
        'priority' => $request->priority ?? 'medium',
        'color' => $request->color ?? '#d93025',
    ]);

    return response()->json(['success' => true, 'message' => 'Event updated successfully!']);
}

public function markComplete($id)
{
    $event = Event::findOrFail($id);
    $event->status = 'Complete';
    $event->save();

    return response()->json(['success' => true, 'message' => 'Event marked as complete!']);
}

public function destroy($id)
{
    $event = Event::findOrFail($id);
    
    // Delete attachment if exists
    if ($event->attachment && \Storage::disk('public')->exists($event->attachment)) {
        \Storage::disk('public')->delete($event->attachment);
    }
    
    $event->delete();

    return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
}



}
