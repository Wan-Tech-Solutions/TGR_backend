<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Mail\ProspectusMail;
use App\Models\ProspectusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProspectusRequestController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|unique:prospectus_requests,email',
    //     ]);
    //     // Save the email to the database
    //     $prospectusRequest = new ProspectusRequest();
    //     $prospectusRequest->email = $request->email;
    //     $prospectusRequest->save();
    //     $pdfPath = public_path('upload/prospectus/Blue Simple Professional CV Resume.pdf');
    //     Mail::send(new ProspectusMail($request->email, $pdfPath));
    //     return redirect()->back()->with('success', 'Prospectus PDF sent successfully!');
    //     // return response()->json(['message' => 'Prospectus PDF sent successfully!']);
    // }
    public function index()
    {
        $data = ProspectusRequest::latest()->paginate(10);
        return view('admin.layouts.listofrequestedprospectus.prospectusrequested', compact('data'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            // Save the email to the database
            $prospectusRequest = new ProspectusRequest();
            $prospectusRequest->email = $request->email;
            $prospectusRequest->save();

            // Get the latest published prospectus
            $prospectus = \App\Models\Prospectus::where('is_published', true)
                ->latest('created_at')
                ->first();

            if (!$prospectus || !$prospectus->prospectus_file) {
                \Log::warning('No published prospectus found for email: ' . $request->email);
                return redirect()->back()->with('error', 'No prospectus available at the moment. Please try again later.');
            }

            // Define the PDF URL from the new storage location
            $pdfUrl = asset('prospectus/' . $prospectus->prospectus_file);
            
            \Log::info('Sending prospectus to: ' . $request->email . ', File: ' . $prospectus->prospectus_file);
            
            // Send the email with the PDF link
            Mail::mailer('investors')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

            return redirect()->back()->with('success', 'Prospectus PDF link sent successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in prospectus request');
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('ProspectusRequestController error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);
    //     // Save the email to the database
    //     $prospectusRequest = new ProspectusRequest();
    //     $prospectusRequest->email = $request->email;
    //     $prospectusRequest->save();
    //     // Define the PDF path
    //     $pdfPath = public_path('upload/prospectus/Investors_Prospectus.pdf');
    //     // Send the email with the PDF attached
    //     Mail::mailer('investors')->to($request->email)->send(new ProspectusMail($request->email, $pdfPath));

    //     return redirect()->back()->with('success', 'Prospectous PDF sent successfully!');
    // }
    // Mail::send(new ProspectusMail($request->email, $pdfPath));
    // Redirect back with a success message
}
