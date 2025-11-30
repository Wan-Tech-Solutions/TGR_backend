<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;


class AdminContactController extends Controller
{
    //
    public function contact(){
        $count_blogs = Blog::count('id');
        $contact = ContactUs::orderby('created_at','desc')->paginate(15);
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.contact.contact',compact('count_blogs','contact','contact_count','founder_count','prospectus_count'));
    }
    
    public function markAsResponded($id)
    {
        try {
            $contact = ContactUs::findOrFail($id);
            $contact->responded = true;
            $contact->responded_at = now();
            $contact->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Contact marked as responded successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking contact as responded: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function delete($id)
    {
        try {
            $contact = ContactUs::findOrFail($id);
            $contact->delete();
            
            return redirect()->back()->with('success', 'Contact response deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting contact: ' . $e->getMessage());
        }
    }
    
}
