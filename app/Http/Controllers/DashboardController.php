<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\ProspectusRequest; // Ensure this model is correctly imported
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Count total visitors
        $visitorCount = Visitor::count();

        // Get last 10 visitors
        $visitors = Visitor::orderBy('visited_at', 'desc')->take(10)->get();

        // Count visitors for the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $monthlyVisitorCount = Visitor::whereBetween('visited_at', [$startOfMonth, $endOfMonth])->count();

        // Fetch the requested prospectus data
        $data = ProspectusRequest::latest()->paginate(10); // Paginate with 10 records per page

        // Pass all data to the view
        return view('admin.layouts.index', compact('visitorCount', 'visitors', 'monthlyVisitorCount', 'data'));
    }
}
