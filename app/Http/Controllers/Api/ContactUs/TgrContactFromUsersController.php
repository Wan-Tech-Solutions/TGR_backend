<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TgrContactFromUsersController extends Controller
{
    public function contact_us_summary(Request $request)
    {
        $data = ContactUs::latest();
        return DataTables::of($data)
            ->editColumn('created_at', function ($record) {
                if ($record->created_at) {
                    $formattedDate = $record->created_at->format('d M Y g:ia');
                    return "<span class=\"badge badge-success mr-1\">$formattedDate</span>";
                }
                return '';
            })
            ->rawColumns(['created_at'])
            ->make(true);
    }
}
