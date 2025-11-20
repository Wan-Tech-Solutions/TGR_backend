<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class AdminNoteController extends Controller
{
    //
    public function tgr_note(){
        return view('adminPortal.note.note');
    }

    public function index()
    {
        return response()->json(Note::orderby('created_at','desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->back()->with(['message' => 'Note added successfully!', 'note' => $note]);
    }
}
