<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Mail\ConsultationConfirmationMail;
use App\Models\Consultation;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
/** @noinspection PhpUndefinedClassInspection */
use Throwable;

class ConsultationController extends Controller
{
    public function create(): View
    {
        // Prefill parameters from rebook link or manual population
        $rebook_of = request()->query('rebook_of');
        $originalConsultation = null;
        $prefillQuestionnaire = [];
        
        if ($rebook_of) {
            $originalConsultation = Consultation::find($rebook_of);
            // Convert questionnaire array to indexed array for prefilling
            if ($originalConsultation && $originalConsultation->questionnaire) {
                $prefillQuestionnaire = is_array($originalConsultation->questionnaire) 
                    ? $originalConsultation->questionnaire 
                    : [];
            }
        }

        $prefillParams = [
            'client_name' => request()->query('client_name') ?? $originalConsultation?->name,
            'client_email' => request()->query('client_email') ?? $originalConsultation?->email,
            'dial_code' => request()->query('dial_code') ?? $originalConsultation?->dial_code ?? '+233',
            'client_phone' => request()->query('client_phone') ?? $originalConsultation?->phone,
            'client_nationality' => request()->query('client_nationality') ?? $originalConsultation?->nationality,
            'country_of_residence' => request()->query('country_of_residence') ?? $originalConsultation?->country_of_residence,
            'selectedDate' => request()->query('selected_date'),
            'rebook_of' => $rebook_of,
            'selectedHours' => $originalConsultation?->consultation_hours ?? 1,
            'prefillQuestionnaire' => $prefillQuestionnaire,
        ];

        $bookings = Consultation::query()
            ->select('scheduled_for', DB::raw('COUNT(*) as total'))
            ->groupBy('scheduled_for')
            ->get()
            ->map(fn (Consultation $consultation) => [
                'date' => $consultation->scheduled_for->toDateString(),
                'booked' => (int) $consultation->total,
            ])
            ->values()
            ->all();

        return view('website.features.consult-book', [
            'availability' => $bookings,
            'dailyCapacity' => Consultation::DAILY_CAPACITY,
            'hourlyRate' => Consultation::HOURLY_RATE,
            ...$prefillParams,
        ]);
    }

    public function store(StoreConsultationRequest $request, StripeService $stripe): RedirectResponse
    {
        $data = $request->validated();
        /** @noinspection PhpUndefinedClassInspection */
        $scheduledDate = Carbon::parse($data['selected_date'])->startOfDay()->toDateString();

        /** @var array<int, int> $questionnaire */
        $questionnaire = collect($data['questionnaire'] ?? [])
            ->map(fn ($value) => (int) $value)
            ->values()
            ->all();

        // Check if this is a rebook
        $parentConsultation = null;
        if (! empty($data['rebook_of'])) {
            $parentConsultation = Consultation::find($data['rebook_of']);
            if (! $parentConsultation) {
                return back()
                    ->withInput()
                    ->withErrors(['rebook_of' => 'The parent consultation does not exist.']);
            }

            if (($parentConsultation->rebook_count ?? 0) >= 2) {
                return back()
                    ->withInput()
                    ->withErrors(['rebook_of' => 'Maximum rebooks allowed for this consultation.']);
            }
        }

        $consultation = null;
        $payment = null;

        try {
            DB::beginTransaction();

            $existingCount = Consultation::query()
                ->whereDate('scheduled_for', $scheduledDate)
                ->lockForUpdate()
                ->count();

            if ($existingCount >= Consultation::DAILY_CAPACITY) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->withErrors([
                        'selected_date' => 'The selected date is fully booked. Please choose another day.',
                    ]);
            }

            $quotedAmount = (int) $data['consultation_hours'] * Consultation::HOURLY_RATE * 100;

            $consultation = Consultation::create([
                'reference' => 'CONSULT-' . strtoupper(uniqid()),
                'name' => $data['client_name'],
                'email' => $data['client_email'],
                'dial_code' => $data['dial_code'],
                'phone' => $data['client_phone'],
                'nationality' => $data['client_nationality'] ?? null,
                'country_of_residence' => $data['country_of_residence'],
                'questionnaire' => $questionnaire,
                'consultation_hours' => (int) $data['consultation_hours'],
                'scheduled_for' => $scheduledDate,
                'quoted_amount' => $quotedAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_reference' => null,
                'meta' => [
                    'user_agent' => $request->userAgent(),
                    'ip' => $request->ip(),
                ],
                'rebook_parent_id' => $parentConsultation?->id,
                'rebook_count' => 0,
            ]);

            // Send confirmation email to client
            try {
                Mail::to($consultation->email)->send(new ConsultationConfirmationMail($consultation));
            } catch (Throwable $e) {
                \Log::warning('Failed to send consultation confirmation email', [
                    'consultation_id' => $consultation->id,
                    'email' => $consultation->email,
                    'error' => $e->getMessage(),
                ]);
            }

            // Check if parent has a paid payment; if so, reuse it
            if ($parentConsultation) {
                $parentPaidPayment = $parentConsultation->payments()
                    ->where('status', 'paid')
                    ->first();

                if ($parentPaidPayment) {
                    // Create a 0-amount internal 'rebook' payment to mark this as paid
                    $payment = $consultation->payments()->create([
                        'provider' => 'rebook',
                        'amount' => 0,
                        'currency' => strtolower(config('services.stripe.currency', 'usd')),
                        'status' => 'paid',
                    ]);

                    $consultation->update([
                        'payment_status' => 'paid',
                        'payment_reference' => $payment->reference,
                    ]);

                    // Increment parent rebook count
                    $parentConsultation->increment('rebook_count');

                    DB::commit();

                    return redirect()->route('features.thank_you')
                        ->with('success', 'Rebook confirmed! Your consultation has been scheduled.');
                }
            }

            // Otherwise, create a normal Stripe payment
            $payment = $consultation->payments()->create([
                'reference' => 'PAY-' . strtoupper(uniqid()),
                'provider' => 'stripe',
                'amount' => $quotedAmount,
                'currency' => strtolower(config('services.stripe.currency', 'usd')),
                'status' => 'pending',
            ]);

            DB::commit();
            // @noinspection PhpUndefinedClassInspection
        } catch (Throwable $exception) {
            DB::rollBack();
            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'payment' => 'We could not process your booking at the moment. Please try again shortly.',
                ]);
        }

        try {
            $currency = strtolower(config('services.stripe.currency', 'usd'));

            $successBase = config('services.stripe.success_url') ?: route('features.thank_you');
            $successUrl = $successBase;
            if (! str_contains($successBase, '{CHECKOUT_SESSION_ID}')) {
                $separator = str_contains($successBase, '?') ? '&' : '?';
                $successUrl = rtrim($successBase, '&?') . $separator . 'session_id={CHECKOUT_SESSION_ID}';
            }

            $cancelBase = config('services.stripe.cancel_url') ?: route('features.consult.book');
            if (! str_contains($cancelBase, 'reference=')) {
                $separator = str_contains($cancelBase, '?') ? '&' : '?';
                $cancelUrl = rtrim($cancelBase, '&?') . $separator . 'reference=' . urlencode($payment->reference);
            } else {
                $cancelUrl = $cancelBase;
            }

            $session = $stripe->createCheckoutSession([
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'customer_email' => $consultation->email,
                'metadata' => [
                    'consultation_id' => $consultation->id,
                    'consultation_reference' => $consultation->reference,
                    'payment_id' => $payment->id,
                    'scheduled_for' => optional($consultation->scheduled_for)->toDateString(),
                    'customer_name' => $consultation->name,
                ],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency,
                            'unit_amount' => $payment->amount,
                            'product_data' => [
                                'name' => 'TGR Africa Consultation',
                                'description' => 'Consultation scheduled for ' . Carbon::parse($scheduledDate)->format('M j, Y'),
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
            ]);

            $payment->update([
                'status' => 'initialized',
                'provider_reference' => $session['id'] ?? null,
                'initialize_payload' => $session,
            ]);

            $consultation->update([
                'payment_status' => 'initiated',
                'payment_reference' => $payment->reference,
            ]);

            return redirect()->away((string) ($session['url'] ?? ''));
            // @noinspection PhpUndefinedClassInspection
        } catch (Throwable $exception) {
            report($exception);

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                ]);
            }

            if ($consultation) {
                $consultation->update([
                    'payment_status' => 'failed',
                ]);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'payment' => 'We could not start the payment process. Please try again later.',
                ]);
        }
    }
}
