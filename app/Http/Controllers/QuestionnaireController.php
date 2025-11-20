<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Mail\ConsultationBookingNotification;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionnaireController extends Controller
{
    // public function submitQuestionnaire(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //     ]);
    //     $existingResponse = QuestionnaireResponse::where('name', $request->input('name'))
    //         ->orWhere('email', $request->input('email'))
    //         ->first();
    //     if ($existingResponse) {
    //         return redirect()->route('home')->with('info', 'TGR will contact you as soon as possible. TGR is processing your application.');
    //     }
    //     $data = $request->except('_token', 'name', 'email');
    //     $totalQuestions = count($data);
    //     $totalScore = 0;

    //     foreach ($data as $score) {
    //         if ($score >= 7) {
    //             $totalScore += 1;
    //         }
    //     }

    //     $percentageScore = ($totalScore / $totalQuestions) * 100;

    //     QuestionnaireResponse::create([
    //         'name' => $request->input('name'),
    //         'email' => $request->input('email'),
    //         'responses' => json_encode($data),
    //         'score' => $percentageScore
    //     ]);
    //     return redirect()->route('home')->with('success', 'Thank You for Booking a consultation with TGR. TGR will get back to you as soon as possible.');
    // }

    public function index()
    {
        $consulation_questionaires = QuestionnaireResponse::latest()->get();
        return view('admin.systemsetting.questionaires.index', compact('consulation_questionaires'));
    }

    public function submitQuestionnaire(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country_of_residence' => 'required',
            'nationality' => 'required',
            'contact' => 'required',
        ]);
        // $existingResponse = QuestionnaireResponse::where('name', $request->input('name'))
        //     ->orWhere('email', $request->input('email'))
        //     ->first();

        // if ($existingResponse) {
        //     return back()->with('info', 'Thank for your interest.Your previous application is still under review.A consultant will contact you as soon as possible.');
        // }
        $data = $request->except('_token', 'name', 'email');
        $totalQuestions = count($data);
        $totalScore = 0;
        foreach ($data as $score) {
            if ($score >= 7) {
                $totalScore += 1;
            }
        }
        $percentageScore = ($totalScore / $totalQuestions) * 100;
        QuestionnaireResponse::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'response_time_and_date' => $request->input('response_time_and_date'),
            'country_of_residence' => $request->input('country_of_residence'),
            'nationality' => $request->input('nationality'),
            'responses' => json_encode($data),
            'scores' => $percentageScore,
        ]);

        $messageContent = [
            'full_name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'country_of_residence' => $validated['country_of_residence'],
            'nationality' => $validated['nationality'],
            'percentageScore' => $percentageScore,
        ];

        Mail::to('info@tgrafrica.com')->send(new ConsultationBookingNotification($messageContent));
        // Send auto-reply to user
        Mail::to($validated['email'])->send(new ConsultationBookingNotification($messageContent));
        return redirect()->route('features.thank_you')->with('success', 'Thank you for booking a consultation with TGR. We will get back to you as soon as possible.');
        // return back()->with('success', 'Thank You for Booking a consultation with TGR. TGR will get back to you as soon as possible.');
    }
}
