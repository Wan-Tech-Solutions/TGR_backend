<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Prospectus;
use Illuminate\Http\Request;

class ProspectusController extends Controller
{
    public function index()
    {

        $prospectusFiles = Prospectus::get();
        return view('admin.layouts.prospectus.index', compact('prospectusFiles'));
    }

    public function create()
    {
        return view('admin.layouts.prospectus.create');
    }
    // public function store(Request $request)
    // {
    //     // Validate the file upload
    //     $request->validate([
    //         'prospectus' => 'required|mimes:pdf',
    //     ]);
    //     $prospectus_save_url = null;
    //     if ($request->hasFile('prospectus')) {
    //         $file = $request->file('prospectus');
    //         $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('upload/prospectus'), $name_gen);
    //         $prospectus_save_url = 'upload/prospectus/' . $name_gen;
    //         $prospectus = new Prospectus();
    //         $prospectus->prospectus = $name_gen;
    //         $prospectus->save();
    //         return back()->with('success', 'Prospectus PDF uploaded successfully.');
    //     }
    // }

    public function store(Request $request)
    {
        // Validate the file upload
        $request->validate([
            'prospectus' => 'required|mimes:pdf',
        ]);

        // Initialize variable to store the file path
        $prospectus_save_url = null;

        // Check if a file was uploaded
        if ($request->hasFile('prospectus')) {
            $file = $request->file('prospectus');

            // Get the original file name
            $original_name = $file->getClientOriginalName();

            // Move the uploaded file to 'upload/prospectus/' directory with the original name
            $file->move(public_path('upload/prospectus'), $original_name);

            // Save the file path (relative to the public folder) in the 'prospectus' column
            $prospectus_save_url = 'upload/prospectus/' . $original_name;

            // Create a new Prospectus instance and save the original file name
            $prospectus = new Prospectus();
            $prospectus->prospectus = $prospectus_save_url; // Save the path in the prospectus column
            $prospectus->save();

            // Return success message
            return redirect()->route('prospectus-index')->with('success', 'Created successfully.');
        }

        // If no file was uploaded, return an error
        return back()->with('error', 'Failed to upload the PDF file.');
    }

}
