<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuranXmlController;

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
