<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\ProspectusRequest;


class AdminProspectusController extends Controller
{
    //
    public function prospectus_requests(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $prospectus_request = ProspectusRequest::orderby('created_at','desc')->get();


        return view('adminPortal.prospectus.prospectus_requests',compact('count_blogs','contact_count','founder_count','prospectus_count','prospectus_request'));
    }

    public function prospectus(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus = Prospectus::orderby('created_at','desc')->paginate(15);
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.prospectus.prospectus',compact('count_blogs','contact_count','founder_count','prospectus','prospectus_count'));
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'prospectus_title' => 'required|string|max:255',
                'prospectus_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
                'prospectus_description' => 'required|string|max:1000',
            ], [
                'prospectus_file.required' => 'Please upload a PDF file',
                'prospectus_file.mimes' => 'Only PDF files are allowed',
                'prospectus_file.max' => 'File size must not exceed 10MB',
            ]);

            // Store the file directly in public/prospectus
            $file = $request->file('prospectus_file');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Store in public/prospectus directory
            $publicPath = base_path('public/prospectus');
            if (!is_dir($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            $file->move($publicPath, $filename);

            // Create prospectus record
            $prospectus = new Prospectus();
            $prospectus->prospectus_title = $validated['prospectus_title'];
            $prospectus->prospectus_file = $filename;
            $prospectus->prospectus_description = $validated['prospectus_description'];
            $prospectus->is_published = $request->has('publish_immediately') ? 1 : 0;
            $prospectus->save();

            return response()->json([
                'success' => true,
                'message' => 'Prospectus uploaded successfully',
                'data' => $prospectus
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading prospectus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try {
            $prospectus = Prospectus::findOrFail($id);
            
            // Delete the file from public/prospectus
            if ($prospectus->prospectus_file) {
                $filePath = public_path('prospectus/' . $prospectus->prospectus_file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Delete the database record
            $prospectus->delete();
            
            return redirect()->back()->with('success', 'Prospectus deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting prospectus: ' . $e->getMessage());
        }
    }
}
