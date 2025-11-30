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
                return redirect()->back()->with('error', 'No prospectus available at the moment. Our team is preparing the materials. Please check back soon or contact our team directly.');
            }

            // Increment download count when sending email
            $prospectus->increment('download_count');

            // Define the PDF URL using the public download route (use url() for full absolute URL)
            $pdfUrl = url('prospectus/download/' . $prospectus->id);
            
            \Log::info('Sending prospectus to: ' . $request->email . ', File: ' . $prospectus->prospectus_file . ', Download count: ' . $prospectus->download_count);

            // Send the email with the PDF link. Wrap send in try/catch and fallback to logging if SMTP fails.
            try {
                Mail::mailer('investors')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

                return redirect()->back()->with('success', 'Prospectus PDF link sent successfully! Check your email inbox or spam folder.');
            } catch (\Throwable $e) {
                // Log the detailed error for the investors mailer
                \Log::error('ProspectusRequestController mail error (investors mailer): ' . $e->getMessage() . ' | ' . $e->getTraceAsString());

                // Attempt to send using the primary SMTP mailer as a fallback (if investor mailer auth fails)
                try {
                    \Log::info('Attempting fallback send using primary SMTP mailer for: ' . $request->email);
                    Mail::mailer(config('mail.default'))->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

                    return redirect()->back()->with('success', 'Prospectus PDF link sent using primary mailer. Check your inbox or spam folder.');
                } catch (\Throwable $fallbackEx) {
                    // Log fallback failure then try the log-driver fallback so the request is recorded
                    \Log::error('ProspectusRequestController fallback mail error (primary mailer): ' . $fallbackEx->getMessage() . ' | ' . $fallbackEx->getTraceAsString());

                    try {
                        Mail::mailer('log')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));
                    } catch (\Throwable $inner) {
                        \Log::error('Fallback log-mail also failed: ' . $inner->getMessage());
                    }

                    return redirect()->back()->with('warning', 'We could not send the prospectus by email right now; your request is recorded and our team will follow up shortly.');
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in prospectus request: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('ProspectusRequestController error: ' . $e->getMessage() . ' | ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while processing your request. Please try again later or contact our support team.');
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
