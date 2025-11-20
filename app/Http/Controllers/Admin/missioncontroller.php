<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Http\Request;

class missioncontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $missions = Mission::latest()->get();
        return view('admin.layouts.aboutus.mission.index', compact('missions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mission' => 'required',
        ]);
        Mission::create([
            'mission' => $request->mission,
        ]);
        $notification = [
            'message' => 'missions Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-mission')->with($notification);
    }

    public function edit($uuid)
    {
        $missions = Mission::where('uuid', $uuid)->first();
        if (!$missions) {
            abort(404);
        }
        return view('admin.layouts.aboutus.mission.edit', compact('missions'));
    }

    public function update(Request $request)
    {
        $mission_id = $request->uuid;
        $missions = Mission::where('uuid', $mission_id)->first();
        if (!$missions) {
            abort(404);
        }
        $missions->update([
            'mission' => $request->mission,
        ]);
        $notification = [
            'message' => 'missions Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-mission')->with($notification);
    }

    public function delete($uuid)
    {
        $missions = Mission::where('uuid', $uuid)->first();
        if (!$missions) {
            abort(404);
        }
        $missions->delete();
        $notification = [
            'message' => 'missions Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
