<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\Bookconsultation ;
use App\Models\activityLog;
use App\Models\Subscription;


class AdminHomeController extends Controller
{
    //

    public function index(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $consultation_count = Bookconsultation::count('id');
        $top_blog = Blog::take(3)->get();
        $user_activity = activityLog::orderby('created_at','desc')->take(6)->get();
        $consultation_dates = Bookconsultation::take(3)->get();
        $subscriptions = Subscription::with('user','seminar')->orderby('created_at','desc')->take(3)->get();


        return view('adminPortal.dashboard.home',compact('count_blogs','contact_count','founder_count','prospectus_count','consultation_count','top_blog','user_activity','consultation_dates','subscriptions'));
    }

    public function layout(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.layout.header',compact('count_blogs','contact_count','founder_count','prospectus_count'));
    }
}
