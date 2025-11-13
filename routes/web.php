<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuranXmlController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Registration only allowed if no users exist
    Route::middleware('prevent.registration')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);
    });
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// OTP Verification Routes (must be authenticated but not verified)
Route::middleware('auth')->group(function () {
    Route::get('/verify-otp', [AuthController::class, 'showOtpVerification'])->name('otp.verify.show');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Routes (require authentication and OTP verification)
Route::middleware(['auth', 'verify.otp'])->group(function () {
    // Home page
    Route::get('/', [QuranXmlController::class, 'index'])->name('home');

    // Audio routes
    Route::get('/audio/{type}', [QuranXmlController::class, 'audioForm'])->name('audio.form');
    Route::get('/audio/{type}/surah/{surah}/ayah/{ayah}', [QuranXmlController::class, 'audioFormWithAyah'])->name('audio.form.ayah');
    Route::post('/audio/{type}/save', [QuranXmlController::class, 'saveAudioUrl'])->name('audio.save');
    Route::post('/audio/{type}/generate', [QuranXmlController::class, 'generateAudioXml'])->name('audio.generate');

    // Video routes
    Route::get('/video/{type}', [QuranXmlController::class, 'videoForm'])->name('video.form');
    Route::get('/video/{type}/surah/{surah}/ayah/{ayah}', [QuranXmlController::class, 'videoFormWithAyah'])->name('video.form.ayah');
    Route::post('/video/{type}/save', [QuranXmlController::class, 'saveVideoUrl'])->name('video.save');
    Route::post('/video/{type}/generate', [QuranXmlController::class, 'generateVideoXml'])->name('video.generate');

    // Download routes
    Route::get('/download/{type}/{filename}', [QuranXmlController::class, 'downloadXml'])->name('download.xml');

    // Admin Routes (require admin privileges)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', AdminController::class)->except(['show']);
    });
});
