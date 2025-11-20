<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;


class AdminProfilesController extends Controller
{
    //
    public function profiles(){
        $count_blogs = Blog::count('id');
        $users = User::orderby('id','desc')->get();
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.profiles.profiles',compact('count_blogs','users','contact_count','founder_count','prospectus_count'));
    }
}
