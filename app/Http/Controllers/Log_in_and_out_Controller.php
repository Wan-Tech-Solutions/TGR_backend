<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Log_in_and_out_Controller extends Controller
{
    public function Log_in(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        /** @noinspection PhpUndefinedClassInspection */
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            if ($user->status == 1) {
                $activityLog = [
                    'uuid' => Str::uuid(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'description' => 'has logged in',
                    'date_time' => $todayDate,
                ];
                DB::table('activity_logs')->insert($activityLog);
                return redirect()->intended('admin-home');
            } else {
                auth()->logout();
                return redirect()->route('login')->withErrors(['error' => 'Your account is not active Yet.']);
            }
        }
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    public function Logout()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        /** @noinspection PhpUndefinedClassInspection */
        $dt = Carbon::now();
        $todayDate = $dt->toDateTimeString();
        $activityLog = [
            'uuid' => Str::uuid(),
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        return redirect('/login')->with('success', 'User Logout Successfully');
    }

    public function verifyaccount()
    {
        return view('systemsetting.user account.verifyaccount');
    }

    public function resetpassword()
    {
        return view('auth.forgot-password');
    }

    public function register()
    {
        return view('auth.register');
    }
}
