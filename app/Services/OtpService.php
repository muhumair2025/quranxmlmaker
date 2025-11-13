<?php

namespace App\Services;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    /**
     * Generate a 6-digit OTP code
     */
    public function generateOtp(): string
    {
        return str_pad((string) rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send OTP to user's email
     */
    public function sendOtp(User $user, string $otp): bool
    {
        try {
            Mail::to($user->email)->send(new OtpMail($user, $otp));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(User $user, string $otp): bool
    {
        if (!$user->otp_code || !$user->otp_expires_at) {
            return false;
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return false;
        }

        return $user->otp_code === $otp;
    }

    /**
     * Clear OTP from user
     */
    public function clearOtp(User $user): void
    {
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_verified' => true,
        ]);
    }
}

