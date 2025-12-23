@extends('layouts.app')

@section('title', 'Icon Library')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Icon Library</h1>
            <p class="text-gray-600">Manage icons for your categories</p>
        </div>
        <a href="{{ route('icon-library.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Upload Icon
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Icons Grid -->
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-3">
        @forelse($icons as $icon)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-indigo-400 hover:shadow-sm transition-all group relative">
            <!-- Icon Preview -->
            <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-3">
                <img src="{{ $icon->icon_url }}" alt="{{ $icon->name }}" class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
            </div>
            
            <!-- In Use Badge -->
            @if($icon->isInUse())
                <div class="absolute top-1 right-1">
                    <span class="inline-flex w-5 h-5 items-center justify-center text-xs text-white bg-green-500 rounded-full" title="In use by categories">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>
            @endif
            
            <!-- Icon Info -->
            <div class="p-2 border-t border-gray-100 bg-white">
                <h3 class="text-xs font-medium text-gray-900 truncate mb-1" title="{{ $icon->name }}">{{ $icon->name }}</h3>
                <p class="text-[10px] text-gray-500">{{ strtoupper($icon->file_type) }}</p>

                <!-- Actions -->
                <div class="flex items-center gap-2 mt-2">
                    <a href="{{ $icon->icon_url }}" target="_blank" class="flex-1 text-[10px] text-center text-indigo-600 hover:text-indigo-700 font-medium py-1 px-2 bg-indigo-50 hover:bg-indigo-100 rounded transition-colors">
                        View
                    </a>
                    <form action="{{ route('icon-library.destroy', $icon) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this icon?');" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-[10px] text-center text-red-600 hover:text-red-700 font-medium py-1 px-2 bg-red-50 hover:bg-red-100 rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed" {{ $icon->isInUse() ? 'disabled title=In use by categories' : '' }}>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No icons yet</h3>
                <p class="text-gray-500 mb-4">Upload your first icon to get started</p>
                <a href="{{ route('icon-library.create') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Upload Icon
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

