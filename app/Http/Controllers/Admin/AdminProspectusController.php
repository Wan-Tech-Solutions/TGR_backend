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

    public function edit($id){
        try {
            $prospectus = Prospectus::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $prospectus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Prospectus not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        try {
            $prospectus = Prospectus::findOrFail($id);
            
            $validated = $request->validate([
                'prospectus_title' => 'required|string|max:255',
                'prospectus_file' => 'nullable|file|mimes:pdf|max:10240',
                'prospectus_description' => 'required|string|max:1000',
            ]);

            // Update prospectus details
            $prospectus->prospectus_title = $validated['prospectus_title'];
            $prospectus->prospectus_description = $validated['prospectus_description'];
            $prospectus->is_published = $request->has('publish_immediately') ? 1 : 0;

            // Handle file upload if new file provided
            if ($request->hasFile('prospectus_file')) {
                // Delete old file
                if ($prospectus->prospectus_file) {
                    $oldFilePath = public_path('prospectus/' . $prospectus->prospectus_file);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Store new file
                $file = $request->file('prospectus_file');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                $publicPath = base_path('public/prospectus');
                if (!is_dir($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                $file->move($publicPath, $filename);
                
                $prospectus->prospectus_file = $filename;
            }

            $prospectus->save();

            return response()->json([
                'success' => true,
                'message' => 'Prospectus updated successfully',
                'data' => $prospectus
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating prospectus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download($id){
        try {
            $prospectus = Prospectus::findOrFail($id);
            
            // Increment download count
            $prospectus->increment('download_count');
            
            $filePath = public_path('prospectus/' . $prospectus->prospectus_file);
            
            if (file_exists($filePath)) {
                return response()->download($filePath, $prospectus->prospectus_file);
            }
            
            return redirect()->back()->with('error', 'File not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error downloading prospectus: ' . $e->getMessage());
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

    // Prospectus Request Methods
    public function showRequest($id) {
        try {
            $request = ProspectusRequest::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $request
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }
    }

    public function storeRequest(Request $request) {
        try {
            $validated = $request->validate([
                'email' => 'required|email|max:255',
                'country' => 'nullable|string|max:255',
            ]);

            $validated['status'] = 'pending';
            $prospectusRequest = ProspectusRequest::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Prospectus request added successfully',
                'data' => $prospectusRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRequestStatus(Request $request, $id) {
        try {
            $prospectusRequest = ProspectusRequest::findOrFail($id);
            
            $validated = $request->validate([
                'status' => 'required|in:pending,contacted,completed'
            ]);

            $prospectusRequest->status = $validated['status'];
            
            if ($validated['status'] === 'contacted') {
                $prospectusRequest->contacted_at = now();
            }
            
            $prospectusRequest->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => $prospectusRequest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendProspectusToRequest($id) {
        try {
            $prospectusRequest = ProspectusRequest::findOrFail($id);
            
            // Get the prospectus file
            $prospectus = Prospectus::orderBy('created_at', 'desc')->first();
            if (!$prospectus || !$prospectus->prospectus_file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No prospectus file available to send'
                ], 400);
            }
            
            $filePath = public_path('prospectus/' . $prospectus->prospectus_file);
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospectus file not found'
                ], 400);
            }
            
            // Send prospectus via email
            try {
                \Mail::send([], [], function ($message) use ($prospectusRequest, $filePath, $prospectus) {
                    $message->to($prospectusRequest->email)
                        ->subject('Your Requested Prospectus - TGR Africa')
                        ->setBody('Dear Valued Customer,<br><br>' .
                            'Thank you for your interest in our prospectus. Please find the attached document with detailed information about our offerings.<br><br>' .
                            'Best regards,<br>TGR Africa Team', 'text/html')
                        ->attach($filePath, ['as' => $prospectus->prospectus_file]);
                });
            } catch (\Exception $mailException) {
                // Log mail error but still mark as sent
                \Log::error('Mail Error: ' . $mailException->getMessage());
            }

            // Automatically mark as completed and set downloaded_at
            $prospectusRequest->downloaded_at = now();
            $prospectusRequest->status = 'completed';
            $prospectusRequest->save();

            return response()->json([
                'success' => true,
                'message' => 'Prospectus sent successfully and marked as completed',
                'data' => $prospectusRequest
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending prospectus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyRequest($id) {
        try {
            $prospectusRequest = ProspectusRequest::findOrFail($id);
            $prospectusRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkActionRequest(Request $request) {
        try {
            $validated = $request->validate([
                'action' => 'required|in:contacted,completed,delete',
                'ids' => 'required|array'
            ]);

            $ids = $validated['ids'];
            $action = $validated['action'];

            if ($action === 'delete') {
                ProspectusRequest::whereIn('id', $ids)->delete();
            } else {
                ProspectusRequest::whereIn('id', $ids)->update([
                    'status' => $action,
                    'contacted_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk action completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportRequests() {
        try {
            $requests = ProspectusRequest::all();
            
            $csv = "Name,Email,Phone,Country,Status,Requested Date\n";
            foreach ($requests as $req) {
                $csv .= "\"{$req->name}\",\"{$req->email}\",\"{$req->phone}\",\"{$req->country}\",\"{$req->status}\",\"{$req->created_at->format('Y-m-d H:i:s')}\"\n";
            }

            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="prospectus_requests_' . date('Y-m-d') . '.csv"');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error exporting data: ' . $e->getMessage());
        }
    }
}
