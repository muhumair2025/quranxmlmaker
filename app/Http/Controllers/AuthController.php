<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Generate and send OTP
            $otp = $this->otpService->generateOtp();
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
                'otp_verified' => false,
            ]);

            $this->otpService->sendOtp($user, $otp);

            return redirect()->route('otp.verify.show')->with('success', 'Please check your email for the verification code.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        // Check if this is the first user (make them admin)
        $isFirstUser = User::count() === 0;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $isFirstUser,
        ]);

        Auth::login($user);

        // Generate and send OTP for new registration
        $otp = $this->otpService->generateOtp();
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'otp_verified' => false,
        ]);

        $this->otpService->sendOtp($user, $otp);

        return redirect()->route('otp.verify.show')->with('success', 'Account created successfully! Please check your email for the verification code.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Clear OTP verification on logout
        if ($user) {
            $user->update([
                'otp_verified' => false,
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle reset password request
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Show OTP verification form
     */
    public function showOtpVerification()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // If already verified, redirect to home
        if ($user->otp_verified) {
            return redirect()->route('home');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Combine individual OTP inputs if provided separately
        $otp = $request->input('otp');
        if (!$otp) {
            $otp = $request->input('otp_1') . 
                   $request->input('otp_2') . 
                   $request->input('otp_3') . 
                   $request->input('otp_4') . 
                   $request->input('otp_5') . 
                   $request->input('otp_6');
        }

        if ($this->otpService->verifyOtp($user, $otp)) {
            $this->otpService->clearOtp($user);

            return redirect()->route('home')->with('success', 'Email verified successfully! Welcome!');
        }

        return back()->withErrors([
            'otp' => 'Invalid or expired verification code. Please try again.',
        ])->withInput();
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Generate new OTP
        $otp = $this->otpService->generateOtp();
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $this->otpService->sendOtp($user, $otp);

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}

