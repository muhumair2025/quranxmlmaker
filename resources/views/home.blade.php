@extends('layouts.app')

@section('title', 'Home - Quran XML Generator')

@section('content')
<div>
    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Quran XML Generator</h1>
        <p class="text-gray-600 text-base sm:text-lg">Create XML files for audio, video and text content of Quranic verses</p>
    </div>

    <!-- Content Management Card -->
    <div class="mb-8">
        <a href="{{ route('content.index') }}" class="block bg-white rounded-lg border border-gray-200 hover:border-green-300 hover:shadow-md transition-all duration-200 overflow-hidden group">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors">Content Management</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Manage categories, subcategories, and content for your app</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Admin Panel Card (only visible to admins) -->
    @if(Auth::check() && Auth::user()->is_admin)
    <div class="mb-8">
        <a href="{{ route('admin.index') }}" class="block bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200 overflow-hidden group">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">Admin Panel</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Manage users and system settings</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </a>
    </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cardTitles as $type => $title)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-200">
            <!-- Card Header -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-5 py-4">
                <h2 class="text-lg font-semibold text-white text-center">{{ $title }}</h2>
            </div>
            
            <!-- Card Body -->
            <div class="p-5">
                <div class="space-y-3">
                    <!-- Audio Button -->
                    <a href="{{ route('audio.form', $type) }}" 
                       class="w-full bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group border border-purple-200 hover:border-purple-300">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.816L4.5 13.5H3a1 1 0 01-1-1V7.5a1 1 0 011-1h1.5l3.883-3.316zm2.617 2.22a1 1 0 011.414 0 5.5 5.5 0 010 7.778 1 1 0 01-1.414-1.414 3.5 3.5 0 000-4.95 1 1 0 010-1.414zm3 0a1 1 0 011.414 0 9.5 9.5 0 010 13.434 1 1 0 01-1.414-1.414 7.5 7.5 0 000-10.606 1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Audio
                    </a>

                    <!-- Video Button -->
                    <a href="{{ route('video.form', $type) }}" 
                       class="w-full bg-red-50 hover:bg-red-100 text-red-700 font-medium py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group border border-red-200 hover:border-red-300">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                        </svg>
                        Video
                    </a>

                    <!-- Text Button (Disabled) -->
                    <button disabled 
                            class="w-full bg-gray-50 text-gray-400 font-medium py-3 px-4 rounded-lg cursor-not-allowed flex items-center justify-center border border-gray-200">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0h8v12H6V4z" clip-rule="evenodd"></path>
                        </svg>
                        Text (Coming Soon)
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
