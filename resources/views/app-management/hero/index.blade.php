@extends('layouts.app')

@section('title', 'Hero Slides')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Hero Slides</h1>
            <p class="text-gray-600">Manage homepage hero/slider images for mobile app</p>
        </div>
        <a href="{{ route('app.hero.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Hero Slide
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Slides Grid -->
    @forelse($slides as $slide)
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-6">
        <div class="md:flex">
            <!-- Slide Image -->
            <div class="md:w-1/3 bg-gray-100">
                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-64 md:h-full object-cover">
            </div>
            
            <!-- Slide Info -->
            <div class="md:w-2/3 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $slide->title ?: 'Untitled Slide' }}</h3>
                            <span class="ml-3 px-2 py-1 text-xs font-medium rounded {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $slide->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        @if($slide->description)
                            <p class="text-gray-600 mb-4">{{ Str::limit($slide->description, 200) }}</p>
                        @endif

                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Order: {{ $slide->order }}
                            </span>
                            @if($slide->button_text)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Button: {{ $slide->button_text }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex space-x-3 ml-6">
                        <a href="{{ route('app.hero.edit', $slide) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Edit
                        </a>
                        <form action="{{ route('app.hero.destroy', $slide) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slide?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- API Download URL -->
                <div class="mt-4 p-3 bg-gray-50 rounded border border-gray-200">
                    <p class="text-xs text-gray-600 mb-1 font-medium">API Download URL:</p>
                    <code class="text-xs text-blue-600 break-all">{{ $slide->image_download_url }}</code>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg border border-gray-200 text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No hero slides yet</h3>
        <p class="text-gray-500 mb-4">Create your first hero slide for the mobile app homepage</p>
        <a href="{{ route('app.hero.create') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Hero Slide
        </a>
    </div>
    @endforelse

    <!-- API Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">API Endpoint for Mobile App</h3>
                <p class="text-blue-800 mb-3">Flutter/Android developers can fetch hero slides using:</p>
                <code class="block bg-white text-blue-600 px-4 py-2 rounded border border-blue-300 text-sm">
                    GET {{ url('/api/hero-slides') }}
                </code>
                <p class="text-sm text-blue-700 mt-2">
                    <strong>Note:</strong> Include API key in header: <code class="bg-white px-2 py-1 rounded">X-API-Key: your-api-key</code>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

