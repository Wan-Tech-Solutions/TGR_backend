<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventRsvp;
use App\Models\Event;
use Illuminate\Support\Str;

class RsvpController extends Controller
{
    /**
     * Admin view: list RSVP responses with optional filtering.
     */
    public function adminIndex(Request $request)
    {
        $query = EventRsvp::with('event')->orderByDesc('responded_at');

        if ($request->filled('response') && in_array($request->response, ['yes', 'no', 'maybe'])) {
            $query->where('response', $request->response);
        }

        if ($request->filled('q')) {
            $search = Str::lower($request->q);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('event', function ($qe) use ($search) {
                      $qe->whereRaw('LOWER(event_title) LIKE ?', ["%{$search}%"]);
                  });
            });
        }

        $rsvps = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => EventRsvp::count(),
            'yes' => EventRsvp::where('response', 'yes')->count(),
            'maybe' => EventRsvp::where('response', 'maybe')->count(),
            'no' => EventRsvp::where('response', 'no')->count(),
        ];

        return view('adminPortal.rsvps.index', [
            'rsvps' => $rsvps,
            'stats' => $stats,
        ]);
    }

    /**
     * Handle RSVP response via URL
     */
    public function respond(Request $request, $eventId, $response)
    {
        $event = Event::findOrFail($eventId);

        // Validate response type
        if (!in_array($response, ['yes', 'no', 'maybe'])) {
            abort(400, 'Invalid RSVP response');
        }

        // Get email from query parameter
        $email = $request->query('email');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return view('rsvp.response', [
                'event' => $event,
                'response' => $response,
                'needsEmail' => true
            ]);
        }

        // Check if already responded
        $existingRsvp = EventRsvp::where('event_id', $eventId)
            ->where('email', $email)
            ->first();

        if ($existingRsvp) {
            // Update existing response
            $existingRsvp->update([
                'response' => $response,
                'responded_at' => now()
            ]);
        } else {
            // Create new RSVP
            EventRsvp::create([
                'event_id' => $eventId,
                'email' => $email,
                'response' => $response,
                'responded_at' => now()
            ]);
        }

        return view('rsvp.response', [
            'event' => $event,
            'response' => $response,
            'success' => true
        ]);
    }

    /**
     * Submit RSVP with email
     */
    public function submit(Request $request, $eventId, $response)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $event = Event::findOrFail($eventId);

        // Check if already responded
        $existingRsvp = EventRsvp::where('event_id', $eventId)
            ->where('email', $request->email)
            ->first();

        if ($existingRsvp) {
            $existingRsvp->update([
                'response' => $response,
                'responded_at' => now()
            ]);
        } else {
            EventRsvp::create([
                'event_id' => $eventId,
                'email' => $request->email,
                'response' => $response,
                'responded_at' => now()
            ]);
        }

        return redirect()->route('rsvp.response', [
            'eventId' => $eventId,
            'response' => $response,
            'email' => $request->email
        ]);
    }
}
