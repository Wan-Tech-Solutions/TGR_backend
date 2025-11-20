<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;

class visioncontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $visions = Vision::latest()->get();
        return view('admin.layouts.aboutus.vision.index', compact('visions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vision' => 'required',
        ]);
        Vision::create([
            'vision' => $request->vision,
        ]);
        $notification = [
            'message' => 'visions Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-vision')->with($notification);
    }

    public function edit($uuid)
    {
        $visions = Vision::where('uuid', $uuid)->first();
        if (!$visions) {
            abort(404);
        }
        return view('admin.layouts.aboutus.vision.edit', compact('visions'));
    }

    public function update(Request $request)
    {
        $vision_id = $request->uuid;
        $visions = Vision::where('uuid', $vision_id)->first();
        if (!$visions) {
            abort(404);
        }
        $visions->update([
            'vision' => $request->vision,
        ]);
        $notification = [
            'message' => 'visions Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-vision')->with($notification);
    }

    public function delete($uuid)
    {
        $visions = Vision::where('uuid', $uuid)->first();
        if (!$visions) {
            abort(404);
        }
        $visions->delete();
        $notification = [
            'message' => 'visions Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
