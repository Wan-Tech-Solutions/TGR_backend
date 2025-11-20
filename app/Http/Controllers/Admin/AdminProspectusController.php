<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\ProspectusRequest;


class AdminProspectusController extends Controller
{
    //
    public function prospectus_requests(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $prospectus_request = ProspectusRequest::orderby('created_at','desc')->get();


        return view('adminPortal.prospectus.prospectus_requests',compact('count_blogs','contact_count','founder_count','prospectus_count','prospectus_request'));
    }

    public function prospectus(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus = Prospectus::orderby('created_at','desc')->get();
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.prospectus.prospectus',compact('count_blogs','contact_count','founder_count','prospectus','prospectus_count'));
    }
}
