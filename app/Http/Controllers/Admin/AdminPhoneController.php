<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Contact;

class AdminPhoneController extends Controller
{
    //
    public function tgr_phone(){
        $count_blogs = Blog::count('id');
        $contacts = Contact::all();
        
        return view('adminPortal.phone.phone',compact('contacts','count_blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string'
        ]);

        // Handle nullable fields properly
        $data = $request->only(['name', 'phone', 'email', 'website', 'address']);
        
        // Convert string "null" to actual null
        foreach ($data as $key => $value) {
            if ($value === 'null' || $value === '') {
                $data[$key] = null;
            }
        }

        Contact::create($data);

        return redirect()->back()->with(['message' => 'Contact added successfully!']);
    }

    public function index()
    {
        $contacts = Contact::orderby('created_at','desc')->get();
        return response()->json($contacts);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string'
        ]);

        // Handle nullable fields properly
        $data = $request->only(['name', 'phone', 'email', 'website', 'address']);
        
        // Convert string "null" to actual null
        foreach ($data as $key => $value) {
            if ($value === 'null' || $value === '') {
                $data[$key] = null;
            }
        }

        $contact->update($data);

        return response()->json(['success' => true, 'message' => 'Contact updated successfully!']);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['success' => true, 'message' => 'Contact deleted successfully!']);
    }

}
