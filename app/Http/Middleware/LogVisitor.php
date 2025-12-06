<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        $hasCountryName = Schema::hasColumn('visitors', 'country_name');
        $hasCountryCode = Schema::hasColumn('visitors', 'country_code');
        $hasPath = Schema::hasColumn('visitors', 'path');

        // Reuse existing geolocation for this IP if we have it to avoid repeated API calls
        $existing = null;
        if ($hasCountryCode) {
            $existing = Visitor::where('ip_address', $ip)
                ->whereNotNull('country_code')
                ->latest('visited_at')
                ->first();
        }

        [$countryName, $countryCode] = $existing
            ? [$existing->country_name, $existing->country_code]
            : $this->resolveCountry($ip);

        $payload = [
            'ip_address' => $ip,
            'visited_at' => now(),
        ];

        if ($hasCountryName) {
            $payload['country_name'] = $countryName;
        }

        if ($hasCountryCode) {
            $payload['country_code'] = $countryCode;
        }

        if ($hasPath) {
            $payload['path'] = $request->path();
        }

        Visitor::create($payload);
        return $next($request);
    }

    /**
     * Resolve country name/code from IP with short timeouts and sensible fallbacks.
     */
    private function resolveCountry(string $ip): array
    {
        // Skip geolocation for local/dev addresses
        if ($this->isLocalIp($ip)) {
            return ['Local / Private', 'LC'];
        }

        // Primary: ip-api.com (fast, returns name + code)
        try {
            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,country,countryCode',
            ]);

            if ($response->successful() && $response->json('status') === 'success') {
                return [
                    $response->json('country') ?? 'Unknown',
                    $response->json('countryCode') ?? 'UN',
                ];
            }
        } catch (\Throwable $e) {
            // swallow and fallback
        }

        // Fallback: ipinfo.io (code only)
        try {
            $response = Http::timeout(2)->get("https://ipinfo.io/{$ip}");
            if ($response->successful() && $response->json('country')) {
                $code = $response->json('country');
                return [$code, $code];
            }
        } catch (\Throwable $e) {
            // swallow and fallback
        }

        return ['Unknown', 'UN'];
    }

    private function isLocalIp(string $ip): bool
    {
        return $ip === '127.0.0.1'
            || $ip === 'localhost'
            || str_starts_with($ip, '192.168.')
            || str_starts_with($ip, '10.')
            || str_starts_with($ip, '172.16.')
            || str_starts_with($ip, '172.17.')
            || str_starts_with($ip, '172.18.')
            || str_starts_with($ip, '172.19.')
            || str_starts_with($ip, '172.2') // covers 172.20-172.29
            || str_starts_with($ip, '172.30.')
            || str_starts_with($ip, '172.31.');
    }
}
