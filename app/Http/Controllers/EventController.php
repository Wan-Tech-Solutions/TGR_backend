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
        'send_notification' => 'nullable|boolean',
        'description' => 'nullable|string',
        'location' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip|max:10240',
        'priority' => 'nullable|in:low,medium,high',
        'color' => 'nullable|string',
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
    ]);

    // Send email notifications if requested
    if ($request->send_notification) {
        $subscribers = \App\Models\NewsletterSubscriber::where('active', true)->get();
        
        foreach ($subscribers as $subscriber) {
            try {
                \Mail::to($subscriber->email)->send(new \App\Mail\EventNotification($event));
            } catch (\Exception $e) {
                \Log::error('Failed to send event notification to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }
        
        return response()->json([
            'message' => 'Event saved and ' . $subscribers->count() . ' notifications sent successfully!'
        ]);
    }

    return response()->json(['message' => 'Event saved successfully!']);
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
    $event->delete();

    return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
}



}
