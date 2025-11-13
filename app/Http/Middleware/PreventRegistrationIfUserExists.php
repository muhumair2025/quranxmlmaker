<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class PreventRegistrationIfUserExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if any user exists
        if (User::count() > 0) {
            // If user exists, redirect to login
            return redirect()->route('login')->with('error', 'Registration is closed. Please contact the administrator.');
        }

        return $next($request);
    }
}

