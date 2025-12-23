@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Categories</h1>
            <p class="text-gray-600">Manage your main content categories</p>
        </div>
        <a href="{{ route('content.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-1" style="background: {{ $category->color }}20;">
                <div class="h-2 rounded-t-lg" style="background: {{ $category->color }};"></div>
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        @if($category->iconLibrary)
                            <img src="{{ $category->icon_url }}" alt="{{ $category->name_english }}" class="w-12 h-12 object-contain mr-3">
                        @endif
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name_english }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $category->subcategories_count }} subcategories</p>
                            <div class="flex flex-wrap gap-2 mt-2 text-xs">
                                <span class="bg-gray-100 px-2 py-1 rounded" dir="rtl">🇵🇰 {{ $category->name_urdu }}</span>
                                <span class="bg-gray-100 px-2 py-1 rounded" dir="rtl">🇸🇦 {{ $category->name_arabic }}</span>
                                <span class="bg-gray-100 px-2 py-1 rounded" dir="rtl">🇦🇫 {{ $category->name_pashto }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                @if($category->description)
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                @endif

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <span class="text-xs text-gray-500">Order: {{ $category->order }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('content.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Edit
                        </a>
                        <form action="{{ route('content.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No categories yet</h3>
                <p class="text-gray-500 mb-4">Get started by creating your first category</p>
                <a href="{{ route('content.categories.create') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Category
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

