<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuranApiController;
use App\Http\Controllers\Api\ContentApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['api', 'api.key'])->group(function () {
    // Quran API Routes (د آیات فایدی، د آیات تفسیر، د آیه لغات)
    // Get all sections data for a specific ayah
    Route::get('/ayah/{surah}/{ayah}', [QuranApiController::class, 'getAyahData']);
    
    // Get specific section data for an ayah
    Route::get('/ayah/{surah}/{ayah}/{type}', [QuranApiController::class, 'getAyahTypeData']);
    
    // Get all data for a specific section (lughat, tafseer, faidi)
    Route::get('/section/{type}', [QuranApiController::class, 'getSectionData']);
    
    // Get all data for a specific surah and section
    Route::get('/surah/{surah}/{type}', [QuranApiController::class, 'getSurahSectionData']);
    
    // Get all available surahs with their info
    Route::get('/surahs', [QuranApiController::class, 'getSurahs']);
    
    // Get specific surah info
    Route::get('/surah/{surah}', [QuranApiController::class, 'getSurahInfo']);

    // Content Management API Routes
    // Get all categories (main cards for homepage)
    Route::get('/categories', [ContentApiController::class, 'getCategories']);
    
    // Get single category with subcategories
    Route::get('/categories/{id}', [ContentApiController::class, 'getCategory']);
    
    // Get subcategory with contents
    Route::get('/subcategories/{id}', [ContentApiController::class, 'getSubcategory']);
    
    // Get single content item
    Route::get('/contents/{id}', [ContentApiController::class, 'getContent']);
    
    // Search content
    Route::get('/search', [ContentApiController::class, 'search']);
});
