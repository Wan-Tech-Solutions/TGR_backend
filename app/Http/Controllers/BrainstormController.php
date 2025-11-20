<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\TgrBrainstorm;
use Illuminate\Http\Request;

class BrainstormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $brainstorm = TgrBrainstorm::latest()->get();
        return view('admin.layouts.advisory.tgrbrainstorm.index', compact('brainstorm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_para_brainstorm' => 'required|string',
            // 'second_para_brainstorm' => 'required|string',
            'brainstorm_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        TgrBrainstorm::create([
            'title' => $request->title,
            'first_para_brainstorm' => $request->first_para_brainstorm,
            // 'second_para_brainstorm' => $request->second_para_brainstorm,
            'aim_by' => json_encode($request->aim_by),
            'brainstorm_process' => $request->brainstorm_process,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgrbrainstorm')->with($notification);
    }

    public function edit($uuid)
    {
        $brainstorm = TgrBrainstorm::where('uuid', $uuid)->first();
        if (!$brainstorm) {
            abort(404);
        }
        return view('admin.layouts.advisory.tgrbrainstorm.edit', compact('brainstorm'));
    }

    public function update(Request $request)
    {
        $brainstorm_id = $request->uuid;
        $brainstorm = TgrBrainstorm::where('uuid', $brainstorm_id)->first();
        if (!$brainstorm) {
            abort(404);
        }
        $request->validate([
            'title' => 'required|string',
            'first_para_brainstorm' => 'required|string',
            // 'second_para_brainstorm' => 'required|string',
            'brainstorm_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        $brainstorm->update([
            'title' => $request->title,
            'first_para_brainstorm' => $request->first_para_brainstorm,
            // 'second_para_brainstorm' => $request->second_para_brainstorm,
            'aim_by' => json_encode($request->aim_by),
            'brainstorm_process' => $request->brainstorm_process,
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgrbrainstorm')->with($notification);
    }

    public function delete($uuid)
    {
        $missions = TgrBrainstorm::where('uuid', $uuid)->first();
        if (!$missions) {
            abort(404);
        }
        $missions->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
