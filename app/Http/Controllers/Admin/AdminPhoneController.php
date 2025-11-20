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
            'website' => 'nullable|url',
            'address' => 'nullable|string'
        ]);

        Contact::create($request->all());

        return redirect()->back()->with(['message' => 'Contact added successfully!']);
    }

    public function index()
    {
        $contacts = Contact::orderby('created_at','desc')->get();
        return response()->json($contacts);
    }

}
