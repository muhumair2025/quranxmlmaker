@extends('layouts.app')

@section('title', 'Manage Subcategories')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Subcategories</h1>
            <p class="text-gray-600">Manage subcategories within your categories</p>
        </div>
        <a href="{{ route('content.subcategories.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Subcategory
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg border border-gray-200 p-2 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('content.categories.index') }}" class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Categories
            </a>
            <a href="{{ route('content.subcategories.index') }}" class="flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                Subcategories
            </a>
            <a href="{{ route('content.contents.index') }}" class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Contents
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Collapsible Categories with Subcategories -->
    <div class="space-y-4">
        @forelse($categories as $category)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <!-- Category Header (Collapsible) -->
            <button type="button" onclick="toggleCategory({{ $category->id }})" 
                class="w-full p-5 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center flex-1">
                    <!-- Category Icon -->
                    @if($category->iconLibrary)
                        <img src="{{ $category->icon_url }}" alt="{{ $category->name_english }}" class="w-12 h-12 rounded-lg mr-4 object-cover border-2" style="border-color: {{ $category->color }}">
                    @else
                        <div class="w-12 h-12 rounded-lg mr-4 flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                            <svg class="w-6 h-6" style="color: {{ $category->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Category Info -->
                    <div class="flex-1 text-left">
                        <div class="flex items-center mb-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $category->name_english }}</h3>
                            @if($category->name_urdu)
                                <span class="mr-2 text-lg font-semibold text-gray-700" dir="rtl"> • {{ $category->name_urdu }}</span>
                            @endif
                        </div>
                        <div class="flex items-center text-sm text-gray-600 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                <strong>{{ $category->active_subcategories_count }}</strong>&nbsp;subcategories
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Expand/Collapse Icon -->
                <svg id="icon-{{ $category->id }}" class="w-6 h-6 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Subcategories List (Collapsible Content) -->
            <div id="category-{{ $category->id }}" class="hidden border-t border-gray-200">
                @forelse($category->activeSubcategories as $subcategory)
                <div class="p-5 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-base font-semibold text-gray-900">{{ $subcategory->name }}</h4>
                                <span class="ml-3 px-2 py-1 text-xs font-medium rounded {{ $subcategory->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600 space-x-4 ml-11">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $subcategory->contents_count }} content items
                                </span>
                                <span class="text-gray-400">Order: {{ $subcategory->order }}</span>
                            </div>
                            
                            @if($subcategory->description)
                                <p class="text-sm text-gray-600 mt-2 ml-11">{{ Str::limit($subcategory->description, 150) }}</p>
                            @endif
                        </div>

                        <div class="flex space-x-3 ml-6">
                            <a href="{{ route('content.subcategories.edit', $subcategory) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                Edit
                            </a>
                            <form action="{{ route('content.subcategories.destroy', $subcategory) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <p class="text-sm">No subcategories in this category yet</p>
                </div>
                @endforelse
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg border border-gray-200 text-center py-12">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories yet</h3>
            <p class="text-gray-500 mb-4">Create categories first before adding subcategories</p>
            <a href="{{ route('content.categories.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Go to Categories
            </a>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
function toggleCategory(categoryId) {
    const content = document.getElementById('category-' + categoryId);
    const icon = document.getElementById('icon-' + categoryId);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Expand all categories on page load (optional)
// You can remove this if you want them collapsed by default
document.addEventListener('DOMContentLoaded', function() {
    // Uncomment next line to expand first category by default
    // if (document.querySelector('[id^="category-"]')) toggleCategory({{ $categories->first()->id ?? 0 }});
});
</script>
@endpush
@endsection

