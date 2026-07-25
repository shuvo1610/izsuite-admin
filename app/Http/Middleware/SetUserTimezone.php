<?php

namespace App\Http\Middleware;

use App\Support\Timezone;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserTimezone
{
    public function handle(Request $request, Closure $next): Response
    {
        // Keep storage baseline in UTC for all requests.
        config([
            'app.timezone' => Timezone::UTC,
        ]);

        $defaultDisplayTimezone  = Timezone::resolve(
            config('app.default_display_timezone'),
            Timezone::UTC
        );

        $user                    = $request->user();

        if (! $user && $request->bearerToken()) {
            $user = $request->user('sanctum');
        }

        $resolvedDisplayTimezone = Timezone::resolve(
            $user?->timezone,
            $defaultDisplayTimezone
        );

        config([
            'app.display_timezone' => $resolvedDisplayTimezone,
        ]);

        return $next($request);
    }
}
