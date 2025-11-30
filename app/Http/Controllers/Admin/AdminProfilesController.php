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
        $users = User::orderby('id','desc')->paginate(50);
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.profiles.profiles',compact('count_blogs','users','contact_count','founder_count','prospectus_count'));
    }

    public function view($id){
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    public function edit($id){
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'gender' => 'nullable|string',
                'country_of_residence' => 'nullable|string',
                'nationality' => 'nullable|string',
                'status' => 'required|in:0,1',
            ]);

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
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

