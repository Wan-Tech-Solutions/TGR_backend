<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\activityLog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;


class AdminUserLogsController extends Controller
{
    //
    public function user_logs(){
        $count_blogs = Blog::count('id');
        $activity = activityLog::orderby('id','desc')->paginate(50);
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');


        return view('adminPortal.logs.userlogs',compact('count_blogs','activity','contact_count','founder_count','prospectus_count'));
    }
}
