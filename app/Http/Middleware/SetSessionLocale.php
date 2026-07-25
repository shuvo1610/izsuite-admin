<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Apply session-based locale (language) and currency overrides.
 *
 * These overrides do NOT change the default settings stored in the
 * database — they only last for the current browser session.
 */
class SetSessionLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Apply session language if set
        if ($locale = session('admin_locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
