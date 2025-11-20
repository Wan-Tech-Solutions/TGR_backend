<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\Role;


class AdminRolesController extends Controller
{
    //
    public function roles(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $roles = Role::orderby('created_at','desc')->get();


        return view('adminPortal.roles.roles',compact('count_blogs','contact_count','founder_count','prospectus_count','roles'));
    }
}
