<?php

namespace App\Http\Middleware;

use App\Support\StatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->user() || ! auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], StatusCode::UNAUTHORIZED);
        }

        return $next($request);
    }
}
