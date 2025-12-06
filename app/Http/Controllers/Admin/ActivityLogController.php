<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\activityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs with analytics
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '7'); // days
        $search = $request->get('search');

        // Get date range
        $startDate = Carbon::now()->subDays((int)$period);

        // Build query
        $query = activityLog::with('user')
            ->where('created_at', '>=', $startDate);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Paginated logs
        $logs = $query->orderByDesc('date_time')
            ->paginate(20);

        // Activity statistics
        $totalActivities = activityLog::where('created_at', '>=', $startDate)->count();
        $uniqueUsers = activityLog::where('created_at', '>=', $startDate)
            ->distinct('user_id')
            ->count('user_id');

        // Top activities chart data
        $topActivities = activityLog::select('description', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('description')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Activity by user
        $topUsers = activityLog::select('name', 'email', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('name', 'email')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Activity timeline (daily breakdown)
        $timeline = activityLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format for chart
        $timelineLabels = [];
        $timelineCounts = [];
        foreach ($timeline as $entry) {
            $timelineLabels[] = Carbon::parse($entry->date)->format('M d');
            $timelineCounts[] = $entry->count;
        }

        // Activity by method (GET, POST, etc)
        $byMethod = activityLog::select('method', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('method')
            ->groupBy('method')
            ->get();

        // Most active hours
        $byHour = activityLog::selectRaw('HOUR(date_time) as hour, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return view('adminPortal.activity-logs.index', compact(
            'logs',
            'totalActivities',
            'uniqueUsers',
            'topActivities',
            'topUsers',
            'timelineLabels',
            'timelineCounts',
            'byMethod',
            'byHour',
            'period',
            'search'
        ));
    }

    /**
     * Export activity logs
     */
    public function export(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays((int)$period);

        $logs = activityLog::where('created_at', '>=', $startDate)
            ->orderByDesc('date_time')
            ->get(['name', 'email', 'description', 'date_time', 'ip_address', 'method', 'path']);

        $filename = 'activity_logs_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Activity', 'Date/Time', 'IP Address', 'Method', 'Path']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->name,
                    $log->email,
                    $log->description,
                    $log->date_time,
                    $log->ip_address,
                    $log->method,
                    $log->path,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
