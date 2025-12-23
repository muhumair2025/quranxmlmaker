<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get API key from environment
        $validApiKey = config('app.api_key');

        // Get API key from request header
        $requestApiKey = $request->header('X-API-Key');

        // Verify API key
        if (!$requestApiKey || $requestApiKey !== $validApiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Invalid or missing API key.'
            ], 401);
        }

        return $next($request);
    }
}
