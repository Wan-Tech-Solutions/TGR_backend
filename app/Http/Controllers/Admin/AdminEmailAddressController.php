<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmailAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminEmailAddressController extends Controller
{
    /**
     * Display all email addresses
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $query = EmailAddress::query();
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%$search%")
                  ->orWhere('label', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        
        $emailAddresses = $query->orderBy('is_active', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->paginate(15);
        
        // Get sidebar counts
        $count_blogs = \App\Models\Blog::count();
        $contact_count = \App\Models\ContactUs::count();
        $prospectus_count = \App\Models\ProspectusRequest::count();
        
        return view('adminPortal.email.email-addresses', compact(
            'emailAddresses',
            'search',
            'count_blogs',
            'contact_count',
            'prospectus_count'
        ));
    }

    /**
     * Show create form
     */
    public function create()
    {
        // Get sidebar counts
        $count_blogs = \App\Models\Blog::count();
        $contact_count = \App\Models\ContactUs::count();
        $prospectus_count = \App\Models\ProspectusRequest::count();
        
        return view('adminPortal.email.email-address-form', compact(
            'count_blogs',
            'contact_count',
            'prospectus_count'
        ));
    }

    /**
     * Store new email address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:email_addresses,email',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string',
            'host' => 'nullable|string',
            'port' => 'nullable|integer|between:1,65535',
            'encryption' => 'nullable|in:ssl,tls,none',
            'is_active' => 'boolean',
            'auto_sync' => 'boolean',
        ]);

        $emailAddress = EmailAddress::create($validated);
        
        // Encrypt password if provided
        if ($request->filled('password')) {
            $emailAddress->setEncryptedPassword($request->password)->save();
        }

        return redirect()->route('admin.email-addresses.index')
                        ->with('success', "Email address '{$emailAddress->email}' added successfully!");
    }

    /**
     * Show edit form
     */
    public function edit(EmailAddress $emailAddress)
    {
        // Get sidebar counts
        $count_blogs = \App\Models\Blog::count();
        $contact_count = \App\Models\ContactUs::count();
        $prospectus_count = \App\Models\ProspectusRequest::count();
        
        return view('adminPortal.email.email-address-form', compact(
            'emailAddress',
            'count_blogs',
            'contact_count',
            'prospectus_count'
        ));
    }

    /**
     * Update email address
     */
    public function update(Request $request, EmailAddress $emailAddress)
    {
        $validated = $request->validate([
            'email' => "required|email|unique:email_addresses,email,{$emailAddress->id}",
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string',
            'host' => 'nullable|string',
            'port' => 'nullable|integer|between:1,65535',
            'encryption' => 'nullable|in:ssl,tls,none',
            'is_active' => 'boolean',
            'auto_sync' => 'boolean',
        ]);

        $emailAddress->update($validated);
        
        // Encrypt password if provided
        if ($request->filled('password')) {
            $emailAddress->setEncryptedPassword($request->password)->save();
        }

        return redirect()->route('admin.email-addresses.index')
                        ->with('success', "Email address '{$emailAddress->email}' updated successfully!");
    }

    /**
     * Toggle active status
     */
    public function toggleActive(EmailAddress $emailAddress)
    {
        $emailAddress->update(['is_active' => !$emailAddress->is_active]);
        
        $status = $emailAddress->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()->with('success', "Email address {$status} successfully!");
    }

    /**
     * Toggle auto sync
     */
    public function toggleAutoSync(EmailAddress $emailAddress)
    {
        $emailAddress->update(['auto_sync' => !$emailAddress->auto_sync]);
        
        $status = $emailAddress->auto_sync ? 'enabled' : 'disabled';
        
        return redirect()->back()->with('success', "Auto-sync {$status} successfully!");
    }

    /**
     * Delete email address
     */
    public function destroy(EmailAddress $emailAddress)
    {
        $email = $emailAddress->email;
        $emailAddress->delete();
        
        return redirect()->route('admin.email-addresses.index')
                        ->with('success', "Email address '{$email}' deleted successfully!");
    }

    /**
     * Get statistics for email addresses
     */
    public function getStats()
    {
        return [
            'total' => EmailAddress::count(),
            'active' => EmailAddress::active()->count(),
            'inactive' => EmailAddress::where('is_active', false)->count(),
            'with_auto_sync' => EmailAddress::withAutoSync()->count(),
        ];
    }
}
