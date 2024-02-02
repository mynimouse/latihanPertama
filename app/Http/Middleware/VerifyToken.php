<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('api/a1/register') && !$request->is('api/a1/auth/login'))
            if (!Auth::guard('sanctum')->check()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        return $next($request);
    }
}
