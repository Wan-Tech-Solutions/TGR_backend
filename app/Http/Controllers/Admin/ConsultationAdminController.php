<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ConsultationAdminController extends Controller
{
    /**
     * Display a listing of all consultations
     */
    public function index(): View
    {
        $query = Consultation::query();

        // Search filter
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        // Payment status filter
        if ($paymentStatus = request('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        $consultations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics
        $stats = [
            'total_consultations' => Consultation::count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'confirmed_consultations' => Consultation::where('status', 'confirmed')->count(),
            'completed_consultations' => Consultation::where('status', 'completed')->count(),
        ];

        return view('admin.consultations.index', [
            'consultations' => $consultations,
            'stats' => $stats,
        ]);
    }

    /**
     * Display a single consultation details
     */
    public function show(Consultation $consultation): View
    {
        $consultation->load('payments');

        return view('admin.consultations.show', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * Update consultation status
     */
    public function updateStatus(Consultation $consultation): RedirectResponse
    {
        $status = request()->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ])['status'];

        $consultation->update(['status' => $status]);

        return back()->with('success', 'Consultation status updated successfully.');
    }
}
