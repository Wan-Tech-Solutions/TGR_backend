<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncreaseExecutionTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Increase max execution time for potentially heavy operations
        $timeout = config('performance.timeout', 300);
        
        if (function_exists('set_time_limit')) {
            set_time_limit($timeout);
        }
        
        return $next($request);
    }
}
