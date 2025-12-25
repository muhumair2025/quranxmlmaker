<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuranXmlController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\IconLibraryController;
use App\Http\Controllers\AppManagementController;

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

    // Icon Library Routes
    Route::prefix('icon-library')->name('icon-library.')->group(function () {
        Route::get('/', [IconLibraryController::class, 'index'])->name('index');
        Route::get('/create', [IconLibraryController::class, 'create'])->name('create');
        Route::post('/', [IconLibraryController::class, 'store'])->name('store');
        Route::delete('/{icon}', [IconLibraryController::class, 'destroy'])->name('destroy');
    });

    // Content Management Routes
    Route::prefix('content-management')->name('content.')->group(function () {
        // Dashboard
        Route::get('/', [ContentManagementController::class, 'index'])->name('index');
        
        // Categories
        Route::get('/categories', [ContentManagementController::class, 'categoriesIndex'])->name('categories.index');
        Route::get('/categories/create', [ContentManagementController::class, 'categoriesCreate'])->name('categories.create');
        Route::post('/categories', [ContentManagementController::class, 'categoriesStore'])->name('categories.store');
        Route::get('/categories/{category}/edit', [ContentManagementController::class, 'categoriesEdit'])->name('categories.edit');
        Route::put('/categories/{category}', [ContentManagementController::class, 'categoriesUpdate'])->name('categories.update');
        Route::delete('/categories/{category}', [ContentManagementController::class, 'categoriesDestroy'])->name('categories.destroy');
        
        // Subcategories
        Route::get('/subcategories', [ContentManagementController::class, 'subcategoriesIndex'])->name('subcategories.index');
        Route::get('/subcategories/create', [ContentManagementController::class, 'subcategoriesCreate'])->name('subcategories.create');
        Route::post('/subcategories', [ContentManagementController::class, 'subcategoriesStore'])->name('subcategories.store');
        Route::get('/subcategories/{subcategory}/edit', [ContentManagementController::class, 'subcategoriesEdit'])->name('subcategories.edit');
        Route::put('/subcategories/{subcategory}', [ContentManagementController::class, 'subcategoriesUpdate'])->name('subcategories.update');
        Route::delete('/subcategories/{subcategory}', [ContentManagementController::class, 'subcategoriesDestroy'])->name('subcategories.destroy');
        
        // Contents
        Route::get('/contents', [ContentManagementController::class, 'contentsIndex'])->name('contents.index');
        Route::get('/contents/create', [ContentManagementController::class, 'contentsCreate'])->name('contents.create');
        Route::post('/contents', [ContentManagementController::class, 'contentsStore'])->name('contents.store');
        Route::get('/contents/{content}/edit', [ContentManagementController::class, 'contentsEdit'])->name('contents.edit');
        Route::put('/contents/{content}', [ContentManagementController::class, 'contentsUpdate'])->name('contents.update');
        Route::delete('/contents/{content}', [ContentManagementController::class, 'contentsDestroy'])->name('contents.destroy');
    });

    // App Management Routes (Hero Slides & Splash Screen)
    Route::prefix('app-management')->name('app.')->group(function () {
        // Dashboard
        Route::get('/', [AppManagementController::class, 'index'])->name('index');
        
        // Hero Slides
        Route::get('/hero-slides', [AppManagementController::class, 'heroIndex'])->name('hero.index');
        Route::get('/hero-slides/create', [AppManagementController::class, 'heroCreate'])->name('hero.create');
        Route::post('/hero-slides', [AppManagementController::class, 'heroStore'])->name('hero.store');
        Route::get('/hero-slides/{slide}/edit', [AppManagementController::class, 'heroEdit'])->name('hero.edit');
        Route::put('/hero-slides/{slide}', [AppManagementController::class, 'heroUpdate'])->name('hero.update');
        Route::delete('/hero-slides/{slide}', [AppManagementController::class, 'heroDestroy'])->name('hero.destroy');
        
        // Splash Screen
        Route::get('/splash-screen', [AppManagementController::class, 'splashIndex'])->name('splash.index');
        Route::post('/splash-screen', [AppManagementController::class, 'splashUpdate'])->name('splash.update');
        Route::delete('/splash-screen', [AppManagementController::class, 'splashDelete'])->name('splash.delete');
        
        // Live Videos
        Route::get('/live-videos', [AppManagementController::class, 'liveIndex'])->name('live.index');
        Route::get('/live-videos/create', [AppManagementController::class, 'liveCreate'])->name('live.create');
        Route::post('/live-videos', [AppManagementController::class, 'liveStore'])->name('live.store');
        Route::get('/live-videos/{video}/edit', [AppManagementController::class, 'liveEdit'])->name('live.edit');
        Route::put('/live-videos/{video}', [AppManagementController::class, 'liveUpdate'])->name('live.update');
        Route::delete('/live-videos/{video}', [AppManagementController::class, 'liveDestroy'])->name('live.destroy');
    });

    // Admin Routes (require admin privileges)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::resource('users', AdminController::class)->except(['show']);
    });
});
