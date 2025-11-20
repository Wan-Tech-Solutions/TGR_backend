<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class BlockCountry
{
    public function handle(Request $request, Closure $next)
    {
        // Get the user's IP address
        $ip = $request->ip();

        // Get the user's location using the IP address
        $location = Location::get($ip);

        // Check if the user's country is Russia (RU) or Ukraine (UA)
        if ($location && in_array($location->countryCode, ['RU', 'UA'])) {
            abort(403, 'Access denied. Your country is restricted from accessing this site.');
        }

        return $next($request);
    }
}
