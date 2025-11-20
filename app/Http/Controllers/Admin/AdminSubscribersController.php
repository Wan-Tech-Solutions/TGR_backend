<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\Subscription;


class AdminSubscribersController extends Controller
{
    //
    public function subscribers(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $subscriptions = Subscription::with('user','seminar')->orderby('created_at','desc')->get();



        return view('adminPortal.subscribers.subscribers',compact('count_blogs','contact_count','founder_count','prospectus_count','subscriptions'));
    }
}
