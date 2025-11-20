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

class AdminFoundersController extends Controller
{
    //
    public function founders(){
        $count_blogs = Blog::count('id');
        $founders = Founder::orderby('created_at','desc')->get();
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.founders.founders',compact('count_blogs','founders','contact_count','founder_count','prospectus_count'));
    }
}
