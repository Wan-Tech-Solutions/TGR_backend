<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Consultation;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Mail\RebookReminderMail;
use App\Models\RebookLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AdminConsultationsController extends Controller
{
    //
    public function consultations(Request $request){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        
        // Build query with filters
        $query = Consultation::query();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $consultation = $query->orderby('created_at','desc')->paginate(15);
        
        // Calculate statistics
        $total_consultations = Consultation::count();
        $pending_consultations = Consultation::where('status', 'pending')->count();
        $confirmed_consultations = Consultation::where('status', 'confirmed')->count();
        $completed_consultations = Consultation::where('status', 'completed')->count();
        $cancelled_consultations = Consultation::where('status', 'cancelled')->count();

        // Monthly bookings trend (last 6 months)
        $monthlyBookings = Consultation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')
            ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m")')
            ->get();
        
        // Top countries
        $topCountries = Consultation::selectRaw('country_of_residence as country, COUNT(*) as total')
            ->where('country_of_residence', '!=', null)
            ->groupBy('country_of_residence')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        // Revenue calculation (sum of all paid consultation amounts)
        $revenue = Consultation::where('payment_status', 'paid')
            ->sum('quoted_amount');
        
        // Recent consultations for dashboard
        $recentConsultations = Consultation::with('payments')
            ->orderby('created_at','desc')
            ->limit(5)
            ->get();
        
        // Average consultation hours
        $averageHours = Consultation::where('consultation_hours', '!=', null)
            ->avg('consultation_hours') ?? 0;
        
        // Store filters for view
        $filters = [
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'search' => $request->search,
        ];
        
        $capsuleMetrics = [
            'pending' => $pending_consultations,
            'confirmed' => $confirmed_consultations,
            'completed' => $completed_consultations,
            'cancelled' => $cancelled_consultations,
        ];

        return view('adminPortal.consultations.consultations', compact(
            'count_blogs',
            'consultation',
            'contact_count',
            'founder_count',
            'prospectus_count',
            'total_consultations',
            'pending_consultations',
            'confirmed_consultations',
            'completed_consultations',
            'cancelled_consultations',
            'monthlyBookings',
            'topCountries',
            'revenue',
            'recentConsultations',
            'averageHours',
            'filters',
            'capsuleMetrics'
        ));
    }

    public function sendRebookReminder($id)
    {
        $consultation = Consultation::findOrFail($id);

        // Check if consultation was actually scheduled and is past
        if (!$consultation->scheduled_for || !Carbon::parse($consultation->scheduled_for)->isPast()) {
            return redirect()->route('admin.consultations')
                ->withErrors(['error' => 'This consultation is not yet past the scheduled date.']);
        }

        // Check if rebook limit has been reached
        if (($consultation->rebook_count ?? 0) >= 2) {
            return redirect()->route('admin.consultations')
                ->withErrors(['error' => 'This client has already used their 2 free rebook opportunities.']);
        }

        try {
            // Send the rebook reminder email
            Mail::to($consultation->email)->send(new RebookReminderMail($consultation));

            // Log the rebook reminder email
            RebookLog::create([
                'consultation_id' => $consultation->id,
                'email' => $consultation->email,
                'subject' => 'Rebook Reminder - Schedule Your Next Consultation',
                'message_preview' => 'Your rebook reminder has been sent',
                'status' => 'sent',
                'sent_at' => now(),
                'sent_by' => auth()->user()->name ?? 'System',
            ]);

            // Increment the rebook count
            $consultation->increment('rebook_count');

            return redirect()->route('admin.consultations')
                ->with('success', 'Rebook reminder email sent successfully to ' . $consultation->email . ' (Reminder ' . $consultation->rebook_count . ' of 2)');
        } catch (\Throwable $exception) {
            report($exception);

            // Log failed attempt
            RebookLog::create([
                'consultation_id' => $consultation->id,
                'email' => $consultation->email,
                'subject' => 'Rebook Reminder - Schedule Your Next Consultation',
                'status' => 'failed',
                'sent_by' => auth()->user()->name ?? 'System',
                'error_message' => $exception->getMessage(),
            ]);

            return redirect()->route('admin.consultations')
                ->withErrors(['error' => 'Failed to send reminder email. Please try again later.']);
        }
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['payments', 'rebookLogs']);

        // Get the counts needed for the admin header
        $count_blogs = Blog::count();
        $founder_count = Founder::count();
        $contact_count = ContactUs::count();
        $prospectus_count = Prospectus::count();

        return view('adminPortal.consultations.show', [
            'consultation' => $consultation,
            'count_blogs' => $count_blogs,
            'founder_count' => $founder_count,
            'contact_count' => $contact_count,
            'prospectus_count' => $prospectus_count,
        ]);
    }

    public function updateStatus(Consultation $consultation)
    {
        $validated = request()->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
            'payment_status' => ['required', 'in:unpaid,pending,paid'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $consultation->update($validated);

        return redirect()->route('admin.consultations.show', $consultation->id)
            ->with('success', 'Consultation status updated successfully.');
    }

    public function rebookReminders()
    {
        // Get consultations awaiting rebook reminders (past consultations with rebook_count < 2)
        $pendingReminders = Consultation::where('scheduled_for', '<=', Carbon::now()->startOfDay())
            ->where(function($query) {
                $query->whereNull('rebook_count')
                      ->orWhere('rebook_count', '<', 2);
            })
            ->orderBy('scheduled_for', 'desc')
            ->get();

        // Get all rebook logs with pagination
        $rebookLogs = RebookLog::with('consultation')
            ->orderBy('sent_at', 'desc')
            ->paginate(15);

        // Calculate statistics
        $pendingCount = $pendingReminders->count();
        $sentCount = RebookLog::where('status', 'sent')->count();
        $failedCount = RebookLog::where('status', 'failed')->count();

        // Get the counts needed for the admin header
        $count_blogs = Blog::count();
        $founder_count = Founder::count();
        $contact_count = ContactUs::count();
        $prospectus_count = Prospectus::count();

        return view('adminPortal.consultations.rebook_reminders', [
            'pendingReminders' => $pendingReminders,
            'rebookLogs' => $rebookLogs,
            'pendingCount' => $pendingCount,
            'sentCount' => $sentCount,
            'failedCount' => $failedCount,
            'count_blogs' => $count_blogs,
            'founder_count' => $founder_count,
            'contact_count' => $contact_count,
            'prospectus_count' => $prospectus_count,
        ]);
    }
}
