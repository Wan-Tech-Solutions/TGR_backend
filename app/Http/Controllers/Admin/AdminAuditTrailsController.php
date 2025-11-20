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
use App\Models\Audit;



class AdminAuditTrailsController extends Controller
{
    // 
    public function audit_trails(){
        $count_blogs = Blog::count('id');
        $audits = Audit::with('user')->orderby('created_at','desc')->get();
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.audit.audit_trails',compact('count_blogs','audits','contact_count','founder_count','prospectus_count'));
    }
}
