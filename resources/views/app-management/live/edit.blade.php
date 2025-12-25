@extends('layouts.app')

@section('title', 'Edit Live Video')

@section('content')
<div class="max-w-3xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center text-sm text-gray-600 mb-4">
            <a href="{{ route('app.index') }}" class="hover:text-gray-900">App Management</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('app.live.index') }}" class="hover:text-gray-900">Live Videos</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Live Video</h1>
        <p class="text-gray-600">Update YouTube live stream details</p>
    </div>

    <!-- Form -->
    <form action="{{ route('app.live.update', $video) }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-8">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Title *
            </label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="{{ old('title', $video->title) }}"
                required
                placeholder="e.g., Friday Jummah Prayer Live"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('title') border-red-500 @enderror"
            >
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- YouTube URL -->
        <div class="mb-6">
            <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                YouTube URL *
            </label>
            <input 
                type="url" 
                id="youtube_url" 
                name="youtube_url" 
                value="{{ old('youtube_url', $video->youtube_url) }}"
                required
                placeholder="https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('youtube_url') border-red-500 @enderror"
            >
            @error('youtube_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">
                Supported formats: youtube.com/watch?v=ID, youtube.com/live/ID, youtu.be/ID
            </p>
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Status *</label>
            <div class="grid grid-cols-3 gap-4">
                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition-colors">
                    <input type="radio" name="status" value="upcoming" class="hidden status-radio" required {{ old('status', $video->status) === 'upcoming' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="font-medium text-gray-900 text-sm">Upcoming</p>
                    </div>
                </label>

                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition-colors">
                    <input type="radio" name="status" value="live" class="hidden status-radio" required {{ old('status', $video->status) === 'live' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" />
                            </svg>
                        </div>
                        <p class="font-medium text-gray-900 text-sm">Live Now</p>
                    </div>
                </label>

                <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-red-500 transition-colors">
                    <input type="radio" name="status" value="ended" class="hidden status-radio" required {{ old('status', $video->status) === 'ended' ? 'checked' : '' }}>
                    <div class="flex flex-col items-center w-full">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="font-medium text-gray-900 text-sm">Ended</p>
                    </div>
                </label>
            </div>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Scheduled Date & Time -->
        <div class="mb-6">
            <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">
                Scheduled Date & Time (Optional)
            </label>
            <input 
                type="datetime-local" 
                id="scheduled_at" 
                name="scheduled_at" 
                value="{{ old('scheduled_at', $video->scheduled_at?->format('Y-m-d\TH:i')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('scheduled_at') border-red-500 @enderror"
            >
            @error('scheduled_at')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">
                Set when this live stream is scheduled to start
            </p>
        </div>

        <!-- Order -->
        <div class="mb-6">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                Display Order *
            </label>
            <input 
                type="number" 
                id="order" 
                name="order" 
                value="{{ old('order', $video->order) }}"
                required
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('order') border-red-500 @enderror"
            >
            @error('order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">
                Lower numbers appear first (0, 1, 2, ...)
            </p>
        </div>

        <!-- Active Status -->
        <div class="mb-8">
            <label class="flex items-center cursor-pointer">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    value="1"
                    {{ old('is_active', $video->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500"
                >
                <span class="ml-3 text-sm font-medium text-gray-700">Active (visible in app)</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('app.live.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                Update Live Video
            </button>
        </div>
    </form>
</div>

<script>
    // Handle radio button selection styling
    document.querySelectorAll('.status-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.status-radio').forEach(r => {
                r.closest('label').classList.remove('border-red-500', 'bg-red-50');
                r.closest('label').classList.add('border-gray-300');
            });
            if (this.checked) {
                this.closest('label').classList.remove('border-gray-300');
                this.closest('label').classList.add('border-red-500', 'bg-red-50');
            }
        });
        
        // Set initial state
        if (radio.checked) {
            radio.closest('label').classList.remove('border-gray-300');
            radio.closest('label').classList.add('border-red-500', 'bg-red-50');
        }
    });
</script>
@endsection

