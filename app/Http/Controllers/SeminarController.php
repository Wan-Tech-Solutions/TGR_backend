<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\TgrSeminar;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tgrseminars = TgrSeminar::latest()->get();
        return view('admin.layouts.advisory.tgrseminars.index', compact('tgrseminars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_para_seminar' => 'required|string',
            // 'second_para_seminar' => 'required|string',
            'seminar_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        TgrSeminar::create([
            'title' => $request->title,
            'first_para_seminar' => $request->first_para_seminar,
            // 'second_para_seminar' => $request->second_para_seminar,
            'aim_by' => json_encode($request->aim_by),
            'seminar_process' => $request->seminar_process,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgrseminar')->with($notification);
    }

    public function edit($uuid)
    {
        $tgrseminars = TgrSeminar::where('uuid', $uuid)->first();
        if (!$tgrseminars) {
            abort(404);
        }
        return view('admin.layouts.advisory.tgrseminars.edit', compact('tgrseminars'));
    }

    public function update(Request $request)
    {
        $tgrseminars_id = $request->uuid;
        $tgrseminars = TgrSeminar::where('uuid', $tgrseminars_id)->first();
        if (!$tgrseminars) {
            abort(404);
        }
        $request->validate([
            'title' => 'required|string',
            'first_para_seminar' => 'required|string',
            // 'second_para_seminar' => 'required|string',
            'seminar_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        $tgrseminars->update([
            'title' => $request->title,
            'first_para_seminar' => $request->first_para_seminar,
            // 'second_para_seminar' => $request->second_para_seminar,
            'aim_by' => json_encode($request->aim_by),
            'seminar_process' => $request->seminar_process,
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgrseminar')->with($notification);
    }

    public function delete($uuid)
    {
        $tgrseminars = TgrSeminar::where('uuid', $uuid)->first();
        if (!$tgrseminars) {
            abort(404);
        }
        $tgrseminars->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
