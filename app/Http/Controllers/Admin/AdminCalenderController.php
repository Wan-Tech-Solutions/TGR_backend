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
        return view('adminPortal.calender.calender',compact('events'));
    }
}
