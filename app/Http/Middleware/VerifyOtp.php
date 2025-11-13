<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Allow access to OTP verification routes
            if ($request->routeIs('otp.*') || $request->routeIs('logout')) {
                return $next($request);
            }
            
            // Check if OTP is verified
            if (!$user->otp_verified) {
                return redirect()->route('otp.verify.show');
            }
        }

        return $next($request);
    }
}

