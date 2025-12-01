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
                'country' => 'nullable|string|max:255',
            ]);

            // Get country from form first
            $country = $request->country;
            
            // Save the email and country to the database immediately (don't wait for geolocation)
            $prospectusRequest = new ProspectusRequest();
            $prospectusRequest->email = $request->email;
            $prospectusRequest->ip_address = $request->ip();
            $prospectusRequest->country = $country ?? 'Detecting...'; // Placeholder while detecting
            $prospectusRequest->status = 'pending'; // Initially set to pending
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
            
            \Log::info('Sending prospectus to: ' . $request->email . ', IP: ' . $request->ip() . ', File: ' . $prospectus->prospectus_file);

            // Send the email with the PDF link. Wrap send in try/catch and fallback to logging if SMTP fails.
            try {
                Mail::mailer('investors')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

                // Update status to completed and set downloaded_at timestamp
                $prospectusRequest->status = 'completed';
                $prospectusRequest->downloaded_at = now();
                $prospectusRequest->save();

                return redirect()->back()->with('success', 'Prospectus PDF link sent successfully! Check your email inbox or spam folder.');
            } catch (\Throwable $e) {
                // Log the detailed error for the investors mailer
                \Log::error('ProspectusRequestController mail error (investors mailer): ' . $e->getMessage() . ' | ' . $e->getTraceAsString());

                // Attempt to send using the primary SMTP mailer as a fallback (if investor mailer auth fails)
                try {
                    \Log::info('Attempting fallback send using primary SMTP mailer for: ' . $request->email);
                    Mail::mailer(config('mail.default'))->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));

                    // Update status to completed and set downloaded_at timestamp on successful fallback send
                    $prospectusRequest->status = 'completed';
                    $prospectusRequest->downloaded_at = now();
                    $prospectusRequest->save();

                    return redirect()->back()->with('success', 'Prospectus PDF link sent using primary mailer. Check your inbox or spam folder.');
                } catch (\Throwable $fallbackEx) {
                    // Log fallback failure then try the log-driver fallback so the request is recorded
                    \Log::error('ProspectusRequestController fallback mail error (primary mailer): ' . $fallbackEx->getMessage() . ' | ' . $fallbackEx->getTraceAsString());

                    try {
                        Mail::mailer('log')->to($request->email)->send(new ProspectusMail($request->email, $pdfUrl));
                    } catch (\Throwable $inner) {
                        \Log::error('Fallback log-mail also failed: ' . $inner->getMessage());
                    }

                    // Update status to completed on any email send attempt
                    $prospectusRequest->status = 'completed';
                    $prospectusRequest->downloaded_at = now();
                    $prospectusRequest->save();

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

    /**
     * Detect country from IP address asynchronously
     * Call this via a separate route or queue job
     */
    public function detectCountry($id)
    {
        try {
            $prospectusRequest = ProspectusRequest::find($id);
            
            if (!$prospectusRequest) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            // Skip if already has a real country (not "Detecting...")
            if ($prospectusRequest->country && $prospectusRequest->country !== 'Detecting...') {
                return response()->json(['country' => $prospectusRequest->country]);
            }

            $country = $this->getCountryFromIP($prospectusRequest->ip_address);
            
            if ($country) {
                $prospectusRequest->country = $country;
                $prospectusRequest->save();
                return response()->json(['country' => $country]);
            }

            return response()->json(['country' => 'Unknown']);
        } catch (\Exception $e) {
            \Log::error('Error detecting country: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get country from IP address using free geolocation API
     * @param string $ip
     * @return string|null
     */
    private function getCountryFromIP($ip)
    {
        // Skip geolocation for localhost/development IPs
        if ($ip === '127.0.0.1' || $ip === 'localhost' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
            \Log::info("Skipping geolocation for local/development IP: {$ip}");
            return 'Local Testing';
        }

        try {
            // Use ipinfo.io - faster and more reliable free tier
            $response = \Http::timeout(3)->get("https://ipinfo.io/{$ip}?token=");
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['country']) && !empty($data['country'])) {
                    \Log::info("Country detected from IP {$ip}: {$data['country']}");
                    return $data['country'];
                }
            }
        } catch (\Exception $e) {
            \Log::warning("Country detection from ipinfo.io failed for IP {$ip}: " . $e->getMessage());
        }

        // Fallback: Try ip-api.com
        try {
            $response = \Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=country");
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['country']) && !empty($data['country'])) {
                    \Log::info("Country detected from IP {$ip} via ip-api.com: {$data['country']}");
                    return $data['country'];
                }
            }
        } catch (\Exception $e) {
            \Log::warning("Country detection from ip-api.com failed for IP {$ip}: " . $e->getMessage());
        }

        // Final fallback: Try geoip.dev
        try {
            $response = \Http::timeout(2)->get("https://geoip.dev/api/geoip/{$ip}");
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['country_code']) && !empty($data['country_code'])) {
                    \Log::info("Country detected from IP {$ip} via geoip.dev: {$data['country_code']}");
                    return $data['country_code'];
                }
            }
        } catch (\Exception $e) {
            \Log::warning("Country detection from geoip.dev failed for IP {$ip}: " . $e->getMessage());
        }

        \Log::warning("All country detection methods failed for IP {$ip}");
        return 'Unknown';
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
