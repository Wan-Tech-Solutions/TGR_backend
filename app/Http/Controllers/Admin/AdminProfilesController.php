<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Consultation;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminProfilesController extends Controller
{
    public function profiles(){
        $count_blogs = Blog::count('id');
        $users = User::orderby('id','desc')->get();
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.profiles.profiles',compact('count_blogs','users','contact_count','founder_count','prospectus_count'));
    }

    /**
     * Show authenticated user's profile with analytics
     */
    public function myProfile()
    {
        // @noinspection PhpUndefinedClassInspection
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Get user's login/logout history
        $activityLogs = ActivityLog::where('email', $user->email)
            ->orderBy('date_time', 'desc')
            ->limit(10)
            ->get();

        // Calculate login statistics
        $todayLogins = ActivityLog::where('email', $user->email)
            ->where('description', 'has logged in')
            ->whereDate('date_time', Carbon::today())
            ->count();

        $thisMonthLogins = ActivityLog::where('email', $user->email)
            ->where('description', 'has logged in')
            ->whereBetween('date_time', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->count();

        $totalLogins = ActivityLog::where('email', $user->email)
            ->where('description', 'has logged in')
            ->count();

        // System statistics (for admin dashboard info)
        $totalConsultations = Consultation::count();
        $totalBlogs = Blog::count();
        $totalContacts = ContactUs::count();
        $totalProspectus = Prospectus::count();

        // Sidebar data (required for header layout)
        $count_blogs = Blog::count('id');
        $founder_count = Founder::count('id');
        $contact_count = ContactUs::count('id');
        $prospectus_count = Prospectus::count('id');

        // Recent activity
        $recentActivity = ActivityLog::where('email', $user->email)
            ->orderBy('date_time', 'desc')
            ->limit(20)
            ->get();

        // Last login time
        $lastLogin = ActivityLog::where('email', $user->email)
            ->where('description', 'has logged in')
            ->orderBy('date_time', 'desc')
            ->first();

        return view('adminPortal.profiles.my-profile', compact(
            'user',
            'activityLogs',
            'todayLogins',
            'thisMonthLogins',
            'totalLogins',
            'totalConsultations',
            'totalBlogs',
            'totalContacts',
            'totalProspectus',
            'recentActivity',
            'lastLogin',
            'count_blogs',
            'founder_count',
            'contact_count',
            'prospectus_count'
        ));
    }
}

