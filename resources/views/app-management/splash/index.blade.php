@extends('layouts.app')

@section('title', 'Splash Screen')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">App Splash Screen</h1>
        <p class="text-gray-600">Manage the splash screen image displayed when the app starts</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Current Splash Screen -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        @if($splashScreen && $splashScreen->value)
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Splash Screen</h3>
                <div class="inline-block bg-gray-100 p-4 rounded-lg mb-4">
                    <img src="{{ url(Storage::url($splashScreen->value)) }}" alt="Splash Screen" class="max-w-md max-h-96 mx-auto rounded shadow-lg">
                </div>
                
                <!-- API Download URL -->
                <div class="mt-4 p-4 bg-gray-50 rounded border border-gray-200 text-left">
                    <p class="text-sm text-gray-700 mb-2 font-medium">API Download URL:</p>
                    <code class="text-sm text-blue-600 break-all block">{{ url(Storage::url($splashScreen->value)) }}</code>
                </div>

                <!-- Delete Button -->
                <form action="{{ route('app.splash.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the splash screen?');" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Delete Splash Screen
                    </button>
                </form>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No splash screen set</h3>
                <p class="text-gray-500">Upload an image to display when the app starts</p>
            </div>
        @endif
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $splashScreen && $splashScreen->value ? 'Update' : 'Upload' }} Splash Screen</h3>
        
        <form action="{{ route('app.splash.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="splash_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Splash Screen Image * (Recommended: 1080x1920px or 9:16 ratio for mobile)
                    </label>
                    <input type="file" id="splash_image" name="splash_image" accept="image/*" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('splash_image') border-red-500 @enderror">
                    @error('splash_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max size: 5MB. Formats: JPEG, PNG, JPG, WEBP</p>
                    <p class="mt-1 text-xs text-gray-500"><strong>Tip:</strong> Use vertical/portrait orientation for best mobile display</p>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                    {{ $splashScreen && $splashScreen->value ? 'Update' : 'Upload' }} Splash Screen
                </button>
            </div>
        </form>
    </div>

    <!-- API Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">API Endpoint for Mobile App</h3>
                <p class="text-blue-800 mb-3">Flutter/Android developers can fetch the splash screen using:</p>
                <code class="block bg-white text-blue-600 px-4 py-2 rounded border border-blue-300 text-sm mb-3">
                    GET {{ url('/api/splash-screen') }}
                </code>
                <p class="text-sm text-blue-800 mb-2">The API returns:</p>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li><code>has_splash_screen</code> - Boolean indicating if splash screen exists</li>
                    <li><code>image_download_url</code> - Direct download URL for the image</li>
                </ul>
                <p class="text-sm text-blue-700 mt-3">
                    <strong>Note:</strong> Include API key in header: <code class="bg-white px-2 py-1 rounded">X-API-Key: your-api-key</code>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

