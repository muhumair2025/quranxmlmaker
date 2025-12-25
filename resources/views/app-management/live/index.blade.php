@extends('layouts.app')

@section('title', 'Live Videos Management')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Live Videos</h1>
            <p class="text-gray-600">Manage YouTube live streams for your mobile app</p>
        </div>
        <a href="{{ route('app.live.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Live Video
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Live Videos List -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        @forelse($liveVideos as $video)
        <div class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0">
                        @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-40 h-24 object-cover rounded-lg border border-gray-200">
                        @else
                        <div class="w-40 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $video->title }}</h3>
                                
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-3">
                                    <!-- Status Badge -->
                                    @if($video->status === 'live')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-2 h-2 bg-red-600 rounded-full mr-1.5 animate-pulse"></span>
                                        LIVE NOW
                                    </span>
                                    @elseif($video->status === 'upcoming')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Upcoming
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Ended
                                    </span>
                                    @endif

                                    <!-- Active Status -->
                                    @if($video->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        Inactive
                                    </span>
                                    @endif

                                    <!-- Order -->
                                    <span class="text-gray-500">Order: {{ $video->order }}</span>
                                </div>

                                <!-- Scheduled Time -->
                                @if($video->scheduled_at)
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $video->scheduled_at->format('M d, Y - h:i A') }}
                                </div>
                                @endif

                                <!-- YouTube URL -->
                                <div class="flex items-center text-sm">
                                    <a href="{{ $video->youtube_url }}" target="_blank" class="text-red-600 hover:text-red-700 font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                        View on YouTube
                                    </a>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-3 ml-4">
                                <a href="{{ route('app.live.edit', $video) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('app.live.destroy', $video) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this live video?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg mb-4">No live videos yet</p>
            <a href="{{ route('app.live.create') }}" class="text-red-600 hover:text-red-700 font-medium">
                Add your first live video →
            </a>
        </div>
        @endforelse
    </div>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">How It Works</h3>
                <ul class="list-disc list-inside text-blue-700 space-y-1 text-sm">
                    <li>Add YouTube live stream URLs (supports youtube.com/watch, youtube.com/live, youtu.be)</li>
                    <li>Set status: Upcoming, Live, or Ended</li>
                    <li>Schedule date/time for upcoming streams</li>
                    <li>Mobile app fetches via API: <code class="bg-blue-100 px-2 py-0.5 rounded">/api/live-videos</code></li>
                    <li>Videos are displayed in the app's Live section</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

