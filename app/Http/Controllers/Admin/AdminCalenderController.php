<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;


class AdminCalenderController extends Controller
{
    //
    public function tgr_calender(){
        $events = Event::orderby('created_at','desc')->get();
        $subscribersCount = \App\Models\NewsletterSubscriber::where('active', true)->count();
        
        // Group events by date for calendar display
        $eventsByDate = Event::all()->groupBy(function($event) {
            return \Carbon\Carbon::parse($event->event_date)->format('Y-n-j');
        })->map(function($events) {
            return $events->count();
        });
        
        return view('adminPortal.calender.calender',compact('events', 'subscribersCount', 'eventsByDate'));
    }
}
