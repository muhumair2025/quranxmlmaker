@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('content.categories.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-2">Edit Category</h1>
        <p class="text-gray-600">Update category information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('content.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Multilingual Names -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        Category Names (All Languages)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- English Name -->
                        <div>
                            <label for="name_english" class="block text-sm font-medium text-gray-700 mb-2">English Name *</label>
                            <input type="text" id="name_english" name="name_english" value="{{ old('name_english', $category->name_english) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_english') border-red-500 @enderror">
                            @error('name_english')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Urdu Name -->
                        <div>
                            <label for="name_urdu" class="block text-sm font-medium text-gray-700 mb-2">Urdu Name *</label>
                            <input type="text" id="name_urdu" name="name_urdu" value="{{ old('name_urdu', $category->name_urdu) }}" required dir="rtl"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_urdu') border-red-500 @enderror">
                            @error('name_urdu')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arabic Name -->
                        <div>
                            <label for="name_arabic" class="block text-sm font-medium text-gray-700 mb-2">Arabic Name *</label>
                            <input type="text" id="name_arabic" name="name_arabic" value="{{ old('name_arabic', $category->name_arabic) }}" required dir="rtl"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_arabic') border-red-500 @enderror">
                            @error('name_arabic')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pashto Name -->
                        <div>
                            <label for="name_pashto" class="block text-sm font-medium text-gray-700 mb-2">Pashto Name *</label>
                            <input type="text" id="name_pashto" name="name_pashto" value="{{ old('name_pashto', $category->name_pashto) }}" required dir="rtl"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_pashto') border-red-500 @enderror">
                            @error('name_pashto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Select Icon from Library
                        <a href="{{ route('icon-library.index') }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 text-xs ml-2">
                            (Manage Library →)
                        </a>
                    </label>
                    
                    @php
                        $icons = \App\Models\IconLibrary::latest()->get();
                    @endphp
                    
                    @if($icons->count() > 0)
                        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-3">
                            @foreach($icons as $icon)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="icon_library_id" value="{{ $icon->id }}" class="hidden icon-radio" {{ old('icon_library_id', $category->icon_library_id) == $icon->id ? 'checked' : '' }}>
                                <div class="aspect-square border-2 border-gray-300 rounded-lg p-2 hover:border-indigo-500 transition-all flex items-center justify-center bg-white group-hover:shadow-md icon-option">
                                    <img src="{{ $icon->icon_url }}" alt="{{ $icon->name }}" class="max-w-full max-h-full object-contain" title="{{ $icon->name }}">
                                </div>
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-indigo-600 rounded-full hidden items-center justify-center icon-check">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">No icons in library. <a href="{{ route('icon-library.create') }}" target="_blank" class="font-medium underline">Upload icons first</a></p>
                        </div>
                    @endif
                    
                    @error('icon_library_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active (visible to users)</label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('content.categories.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Icon selection
document.querySelectorAll('.icon-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove selection from all
        document.querySelectorAll('.icon-option').forEach(opt => {
            opt.classList.remove('border-indigo-600', 'bg-indigo-50');
            opt.classList.add('border-gray-300');
        });
        document.querySelectorAll('.icon-check').forEach(check => {
            check.classList.add('hidden');
            check.classList.remove('flex');
        });
        
        // Add selection to checked
        if (this.checked) {
            const option = this.nextElementSibling;
            option.classList.remove('border-gray-300');
            option.classList.add('border-indigo-600', 'bg-indigo-50');
            const check = option.nextElementSibling;
            check.classList.remove('hidden');
            check.classList.add('flex');
        }
    });
    
    // Trigger on load if checked
    if (radio.checked) {
        radio.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
