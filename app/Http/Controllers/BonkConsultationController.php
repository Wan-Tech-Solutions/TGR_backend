<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Bookconsultation;
use Illuminate\Http\Request;

class BonkConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $consultations = Bookconsultation::latest()->get();
        return view('admin.layouts.features.bookaconsultation.index', compact('consultations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'book_a_consultation_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        Bookconsultation::create([
            'title' => $request->title,
            'body' => $request->body,
            'aim_by' => json_encode($request->aim_by),
            'book_a_consultation_process' => $request->book_a_consultation_process,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
        // return redirect()->route('site-index-bookaconsultation')->with($notification);
    }

    public function edit($uuid)
    {
        $consultations = Bookconsultation::where('uuid', $uuid)->first();
        if (!$consultations) {
            abort(404);
        }
        return view('admin.layouts.features.bookaconsultation.edit', compact('consultations'));
    }

    public function update(Request $request)
    {
        $consultations_id = $request->uuid;
        $consultations = Bookconsultation::where('uuid', $consultations_id)->first();
        if (!$consultations) {
            abort(404);
        }
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'book_a_consultation_process' => 'required|string',
            'aim_by' => 'array',
            'aim_by.*' => 'string|nullable',
        ]);
        $consultations->update([
            'title' => $request->title,
            'body' => $request->body,
            'aim_by' => json_encode($request->aim_by),
            'book_a_consultation_process' => $request->book_a_consultation_process,
        ]);
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('site-index-bookaconsultation')->with($notification);
    }

    public function delete($uuid)
    {
        $missions = Bookconsultation::where('uuid', $uuid)->first();
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
