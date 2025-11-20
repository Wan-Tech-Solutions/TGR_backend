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
        'status' => 'required|string' // Validate status
    ]);

    Event::create([
        'event_date' => $request->event_date,
        'event_time' => $request->event_time,
        'event_title' => $request->event_title,
        'event_people' => $request->event_people,
        'status' => $request->status, // Save status
    ]);

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
