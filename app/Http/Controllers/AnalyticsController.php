<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\TgrAnalytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tgranalytics = TgrAnalytics::latest()->get();
        return view('admin.layouts.advisory.tgranalytics.index', compact('tgranalytics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_para_analytic' => 'required|string',
            // 'second_para_analytic' => 'required|string',
            'analytic_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        TgrAnalytics::create([
            'title' => $request->title,
            'first_para_analytic' => $request->first_para_analytic,
            // 'second_para_analytic' => $request->second_para_analytic,
            'aim_by' => json_encode($request->aim_by),
            'analytic_process' => $request->analytic_process,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgranalytic')->with($notification);
    }

    public function edit($uuid)
    {
        $tgranalytics = TgrAnalytics::where('uuid', $uuid)->first();
        if (!$tgranalytics) {
            abort(404);
        }
        return view('admin.layouts.advisory.tgranalytics.edit', compact('tgranalytics'));
    }

    public function update(Request $request)
    {
        $tgranalytics_id = $request->uuid;
        $tgranalytics = TgrAnalytics::where('uuid', $tgranalytics_id)->first();
        if (!$tgranalytics) {
            abort(404);
        }
        $request->validate([
            'title' => 'required|string',
            'first_para_analytic' => 'required|string',
            // 'second_para_analytic' => 'required|string',
            'analytic_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        $tgranalytics->update([
            'title' => $request->title,
            'first_para_analytic' => $request->first_para_analytic,
            // 'second_para_analytic' => $request->second_para_analytic,
            'aim_by' => json_encode($request->aim_by),
            'analytic_process' => $request->analytic_process,
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-tgranalytic')->with($notification);
    }

    public function delete($uuid)
    {
        $tgranalytics = TgrAnalytics::where('uuid', $uuid)->first();
        if (!$tgranalytics) {
            abort(404);
        }
        $tgranalytics->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
