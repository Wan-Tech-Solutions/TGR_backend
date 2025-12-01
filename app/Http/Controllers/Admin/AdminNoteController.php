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
        $notes = Note::orderby('created_at','desc')
            ->select(['id', 'title', 'content', 'created_at'])
            ->limit(500)
            ->get();
        return response()->json($notes);
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

    public function show($id)
    {
        $note = Note::findOrFail($id);
        return response()->json(['note' => $note]);
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['success' => true, 'message' => 'Note updated successfully!']);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json(['success' => true, 'message' => 'Note deleted successfully!']);
    }
}
