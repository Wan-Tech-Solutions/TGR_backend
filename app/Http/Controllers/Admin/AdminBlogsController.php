<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;


class AdminBlogsController extends Controller
{
    //
    public function blogs(){
        $all_blogs = Blog::all();
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.blogs.blogs', compact('all_blogs','count_blogs','contact_count','founder_count','prospectus_count'));
    }
}
