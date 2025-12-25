@extends('layouts.app')

@section('title', 'App Management')

@section('content')
<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">App Management</h1>
        <p class="text-gray-600">Manage hero slides and splash screen for your mobile app</p>
    </div>

    <!-- Management Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Hero Slides Card -->
        <a href="{{ route('app.hero.index') }}" class="block bg-white rounded-lg border-2 border-gray-200 hover:border-indigo-400 hover:shadow-lg transition-all duration-200 overflow-hidden group">
            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0 w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Hero Slides</h3>
                <p class="text-gray-600 mb-4">Manage homepage carousel/slider images with titles, descriptions, and call-to-action buttons</p>
                
                <div class="flex items-center text-sm text-indigo-600 font-medium">
                    <span>Manage Slides</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-4 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    API: <code class="ml-1 text-indigo-600 font-mono text-xs">/api/hero-slides</code>
                </div>
            </div>
        </a>

        <!-- Splash Screen Card -->
        <a href="{{ route('app.splash.index') }}" class="block bg-white rounded-lg border-2 border-gray-200 hover:border-purple-400 hover:shadow-lg transition-all duration-200 overflow-hidden group">
            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0 w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Splash Screen</h3>
                <p class="text-gray-600 mb-4">Set the image displayed when users first open the mobile app during startup</p>
                
                <div class="flex items-center text-sm text-purple-600 font-medium">
                    <span>Manage Splash Screen</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-8 py-4 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    API: <code class="ml-1 text-purple-600 font-mono text-xs">/api/splash-screen</code>
                </div>
            </div>
        </a>

        <!-- Live Videos Card -->
        <a href="{{ route('app.live.index') }}" class="block bg-white rounded-lg border-2 border-gray-200 hover:border-red-400 hover:shadow-lg transition-all duration-200 overflow-hidden group">
            <div class="p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0 w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-600 transition-colors">Live Videos</h3>
                <p class="text-gray-600 mb-4">Manage YouTube live streams that appear in the app's Live section</p>
                
                <div class="flex items-center text-sm text-red-600 font-medium">
                    <span>Manage Live Videos</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-red-50 to-orange-50 px-8 py-4 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    API: <code class="ml-1 text-red-600 font-mono text-xs">/api/live-videos</code>
                </div>
            </div>
        </a>
    </div>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">For Mobile App Developers</h3>
                <p class="text-blue-800 mb-3">Both features provide direct download URLs via API endpoints. Flutter/Android developers can:</p>
                <ul class="list-disc list-inside text-blue-700 space-y-1 text-sm">
                    <li>Fetch hero slides for homepage carousel</li>
                    <li>Download splash screen image during app initialization</li>
                    <li>Fetch live YouTube streams for Live section</li>
                    <li>Cache images locally for offline support</li>
                    <li>All endpoints require API key authentication</li>
                </ul>
                <div class="mt-4 p-3 bg-white rounded border border-blue-300">
                    <p class="text-xs text-blue-700 font-semibold mb-1">API Authentication Header:</p>
                    <code class="text-xs text-blue-600">X-API-Key: {{ config('app.api_key') }}</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

