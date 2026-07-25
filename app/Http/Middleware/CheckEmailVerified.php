<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || is_null($request->user()->email_verified_at)) {
            return response()->json([
                'message' => 'Your email address is not verified. Please verify your email to access this resource.',
                'action'  => 'verification_required',
            ], 403);
        }

        return $next($request);
    }
}
