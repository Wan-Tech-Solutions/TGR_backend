<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Founder;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class FounderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Founder::latest()->get();
        return view('admin.layouts.aboutus.founder.index', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'founder_profile' => 'required',
        ]);
        $data = new Founder();
        $data->founder_profile = $request->founder_profile;
        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img->save(public_path('upload/founder/' . $name_gen));
            $data->image = 'upload/founder/' . $name_gen;
        }
        $data->save();
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-founder')->with($notification);
    }

    public function edit($uuid)
    {
        $data = Founder::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        return view('admin.layouts.aboutus.founder.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $founder_id = $request->uuid;
        $data = Founder::where('uuid', $founder_id)->first();
        if (!$data) {
            abort(404);
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image',
            ]);
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img->save(public_path('upload/founder/' . $name_gen));
            $save_url = 'upload/founder/' . $name_gen;
            $data->image = $save_url;
        }
        $data->founder_profile = $request->founder_profile;
        $data->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-founder')->with($notification);
    }

    public function delete($uuid)
    {
        $data = Founder::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        $data->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
