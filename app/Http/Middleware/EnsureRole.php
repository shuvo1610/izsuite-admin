<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * Accepts one or more role slugs:
     *   Route::middleware('role:candidate')
     *   Route::middleware('role:candidate,recruiter')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            return response()->json(['message' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
        }

        if (! in_array($user->role->slug, $roles, true)) {
            return response()->json(['message' => 'Forbidden. Your role does not have access to this resource.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
