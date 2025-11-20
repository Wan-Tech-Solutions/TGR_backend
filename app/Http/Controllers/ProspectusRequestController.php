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
        $request->validate([
            'email' => 'required|email',
        ]);

        // Save the email to the database
        $prospectusRequest = new ProspectusRequest();
        $prospectusRequest->email = $request->email;
        $prospectusRequest->save();

        // Define the PDF URL
        // $pdfUrl = asset('upload/prospectus/Investors_Prospectus.pdf');
        $pdfUrl = url('upload/prospectus/Investors_Prospectus.pdf');
        // Send the email with the PDF link
        Mail::mailer('investors')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

        return redirect()->back()->with('success', 'Prospectus PDF link sent successfully!');
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
