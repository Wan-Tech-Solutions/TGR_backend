<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Founder;
use App\Models\Prospectus;
use App\Models\Consultation;
use App\Models\activityLog;
use App\Models\Subscription;
use App\Models\Visitor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;


class AdminHomeController extends Controller
{
    //

    public function index(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');
        $consultation_count = Consultation::count();
        $top_blog = Blog::take(3)->get();
        $user_activity = activityLog::orderby('created_at','desc')->take(10)->get();
        $consultation_dates = Consultation::orderBy('created_at', 'desc')->take(3)->get();
        $subscriptions = Subscription::with('user','seminar')->orderby('created_at','desc')->take(3)->get();

        // Get users online (active in last 5 minutes)
        $usersOnline = 0;
        $onlineUsersList = collect();
        if (Schema::hasColumn('users', 'last_activity')) {
            $onlineUsersList = \App\Models\User::where('last_activity', '>=', now()->subMinutes(5))
                ->orderByDesc('last_activity')
                ->get(['id', 'name', 'email', 'last_activity']);
            $usersOnline = $onlineUsersList->count();
        }

        $geoCountries = Visitor::selectRaw('COALESCE(country_name, "Unknown") as country_name, COALESCE(country_code, "UN") as country_code, COUNT(*) as total')
            ->groupBy('country_name', 'country_code')
            ->orderByDesc('total')
            ->get();

        $totalVisits = Visitor::count();

        $countrySeries = $geoCountries->mapWithKeys(function ($row) {
            $code = strtoupper($row->country_code ?? '');
            return $code ? [$code => (int) $row->total] : [];
        });

        $pageVisits = collect();
        if (Schema::hasColumn('visitors', 'path')) {
            $pageVisits = Visitor::selectRaw('path, COUNT(*) as visits, COUNT(DISTINCT ip_address) as unique_users')
                ->whereNotNull('path')
                ->groupBy('path')
                ->orderByDesc('visits')
                ->take(10)
                ->get();
        }

        // Traffic summary (last 14 days)
        $startDate = Carbon::today()->subDays(13);
        $rawTraffic = Visitor::selectRaw('DATE(created_at) as day, COUNT(*) as visits, COUNT(DISTINCT ip_address) as unique_users')
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $trafficLabels = [];
        $trafficVisits = [];
        $trafficUnique = [];
        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->toDateString();
            $trafficLabels[] = $date->format('M d');
            $trafficVisits[] = (int) ($rawTraffic[$key]->visits ?? 0);
            $trafficUnique[] = (int) ($rawTraffic[$key]->unique_users ?? 0);
        }


        return view('adminPortal.dashboard.home',compact(
            'count_blogs',
            'contact_count',
            'founder_count',
            'prospectus_count',
            'consultation_count',
            'top_blog',
            'user_activity',
            'consultation_dates',
            'subscriptions',
            'geoCountries',
            'countrySeries',
            'totalVisits',
            'pageVisits',
            'usersOnline',
            'onlineUsersList',
            'trafficLabels',
            'trafficVisits',
            'trafficUnique'
        ));
    }

    /**
     * Export consultations as CSV (Excel-friendly)
     */
    public function exportConsultationsCsv()
    {
        $consultations = Consultation::orderByDesc('scheduled_for')->get([
            'name',
            'email',
            'phone',
            'scheduled_for',
            'status',
        ]);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="consultations.csv"',
        ];

        $callback = static function () use ($consultations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Scheduled For', 'Status']);
            foreach ($consultations as $consultation) {
                fputcsv($handle, [
                    $consultation->name,
                    $consultation->email,
                    $consultation->phone,
                    optional($consultation->scheduled_for)->format('Y-m-d'),
                    $consultation->status,
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export consultations as PDF (uses Dompdf if available, otherwise a clean HTML fallback).
     */
    public function exportConsultationsPdf()
    {
        $consultations = Consultation::orderByDesc('scheduled_for')->get([
            'name',
            'email',
            'phone',
            'scheduled_for',
            'status',
        ]);

        $html = view('adminPortal.consultations.export-pdf', compact('consultations'))->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();
            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="consultations.pdf"',
            ]);
        }

        // Fallback: return HTML with PDF filename so the user can print/save as PDF
        return response($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="consultations.html"',
        ]);
    }

    public function exportTrafficCsv()
    {
        $startDate = Carbon::today()->subDays(13);
        $traffic = Visitor::selectRaw('DATE(created_at) as day, COUNT(*) as visits, COUNT(DISTINCT ip_address) as unique_users')
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=\"traffic-summary.csv\"',
        ];

        $callback = static function () use ($traffic) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Visits', 'Unique Users']);
            foreach ($traffic as $row) {
                fputcsv($handle, [
                    $row->day,
                    $row->visits,
                    $row->unique_users,
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function layout(){
        $count_blogs = Blog::count('id');
        $contact_count = ContactUs::count('id');
        $founder_count = Founder::count('id');
        $prospectus_count = Prospectus::count('id');

        return view('adminPortal.layout.header',compact('count_blogs','contact_count','founder_count','prospectus_count'));
    }
}
