<?php

namespace App\Http\Middleware;

use App\Models\activityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrackUserActivity
{
    /**
     * Handle an incoming request and log user activities
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log for authenticated users and exclude certain routes
        if (Auth::check() && $this->shouldLog($request)) {
            $user = Auth::user();
            $action = $this->getActionDescription($request);

            activityLog::create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'description' => $action,
                'date_time' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'method' => $request->method(),
                'path' => $request->path(),
            ]);
        }

        return $response;
    }

    /**
     * Determine if the request should be logged
     */
    private function shouldLog(Request $request): bool
    {
        $excludedPaths = [
            'logout',
            'login',
            '_debugbar',
            'livewire',
        ];

        $path = $request->path();

        foreach ($excludedPaths as $excluded) {
            if (Str::contains($path, $excluded)) {
                return false;
            }
        }

        // Only log state-changing operations and important views
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']) ||
               $this->isImportantView($path);
    }

    /**
     * Check if this is an important view to log
     */
    private function isImportantView(string $path): bool
    {
        $importantViews = [
            'admin-home',
            'admin-blogs',
            'admin-consultations',
            'admin-subscribers',
            'admin-prospectus',
            'admin-contacts',
            'admin-users',
            'admin-settings',
        ];

        foreach ($importantViews as $view) {
            if (Str::contains($path, $view)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get human-readable action description
     */
    private function getActionDescription(Request $request): string
    {
        $method = $request->method();
        $path = $request->path();

        // Map common actions
        if ($method === 'POST' && Str::contains($path, 'store')) {
            return 'created a new record in ' . $this->getModule($path);
        }
        if ($method === 'PUT' || $method === 'PATCH') {
            return 'updated a record in ' . $this->getModule($path);
        }
        if ($method === 'DELETE') {
            return 'deleted a record in ' . $this->getModule($path);
        }
        if (Str::contains($path, 'admin-home')) {
            return 'viewed dashboard';
        }
        if (Str::contains($path, 'admin-blogs')) {
            return 'accessed blog management';
        }
        if (Str::contains($path, 'admin-consultations')) {
            return 'accessed consultations';
        }
        if (Str::contains($path, 'admin-subscribers')) {
            return 'viewed subscribers';
        }
        if (Str::contains($path, 'admin-prospectus')) {
            return 'accessed prospectus';
        }
        if (Str::contains($path, 'admin-contacts')) {
            return 'viewed contact messages';
        }

        return 'performed action on ' . $path;
    }

    /**
     * Extract module name from path
     */
    private function getModule(string $path): string
    {
        $segments = explode('/', $path);
        return $segments[0] ?? 'system';
    }
}
