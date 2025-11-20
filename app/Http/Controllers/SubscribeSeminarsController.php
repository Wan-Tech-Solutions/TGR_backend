<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class SubscribeSeminarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required|file|mimes:mp4,mov,ogg,qt', // Adjust file size limit as needed
        ]);
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $name_gen = hexdec(uniqid()) . '.' . $video->getClientOriginalExtension();
            $videoPath = 'upload/seminars/' . $name_gen;
            $video->move(public_path('upload/seminars'), $name_gen);
        }
        Seminar::create([
            'title' => $request->title,
            'description' => $request->description,
            'video' => $videoPath,
        ]);
        return redirect()->route('all-seminars-videos')->with('success', 'Seminar added successfully.');
    }
    public function all_seminars_record()
    {
        $all_seminars_vidoes = Seminar::all();
        return view('admin.systemsetting.seminars.index', compact('all_seminars_vidoes'));
    }
    public function delete_seminar_video($uuid)
    {
        // Retrieve the seminar record by UUID
        $all_seminars_vidoes = Seminar::where('uuid', $uuid)->first();
        if (!$all_seminars_vidoes) {
            // If seminar record is not found, abort with a 404 error
            abort(404);
        }
        // Get the video file path from the seminar record (assuming you have a 'video_path' column)
        $videoPath = public_path('upload/seminars/' . $all_seminars_vidoes->video_path);
        // Check if the video file exists and delete it
        if (File::exists($videoPath)) {
            File::delete($videoPath);
        }
        // Delete the seminar record from the database
        $all_seminars_vidoes->delete();
        // Flash a success message to the session
        session()->flash('success', 'Seminar video has been deleted successfully!');
        // Redirect back to the previous page
        return back();
    }

    public function index()
    {
        $user = Auth::user();
        $seminars = Seminar::all();
        foreach ($seminars as $seminar) {
            $seminar->isSubscribed = Subscription::where('user_id', $user->id)
                ->where('seminar_id', $seminar->id)
                ->exists();
        }
        return view('admin.layouts.advisory.tgrseminars.index', compact('seminars'));
    }

    public function subscribe(Seminar $seminar)
    {
        $user = Auth::user();
        Subscription::firstOrCreate([
            'user_id' => $user->id,
            'seminar_id' => $seminar->id,
        ]);
        return redirect()->route('seminarsindex', $seminar->id)->with('success', 'You have subscribed to this seminar.');
    }

    public function show(Seminar $seminar)
    {
        $user = Auth::user();
        $isSubscribed = Subscription::where('user_id', $user->id)
            ->where('seminar_id', $seminar->id)
            ->exists();

        return view('admin.layouts.advisory.tgrseminars.show', compact('seminar', 'isSubscribed'));
    }

    public function users_subscribed_semiars(Request $request)
    {
        $subscriptions = Subscription::with(['user', 'seminar'])->get();
        return DataTables::of($subscriptions)
            ->addColumn('user_name', function ($subscription) {
                return $subscription->user->name;
            })
            ->addColumn('seminar_title', function ($subscription) {
                return $subscription->seminar->title;
            })
            ->make(true);
    }

    public function users_subscribed()
    {
        return view('admin.systemsetting.seminars.seminar_subscribed');
    }
}
