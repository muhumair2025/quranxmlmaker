@extends('layouts.app')

@section('title', 'Create Content')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('content.contents.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Contents
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-2">Create Content</h1>
        <p class="text-gray-600">Add new content (Text, Q&A, or PDF)</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('content.contents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Category and Subcategory Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_select" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select id="category_select" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700 mb-2">Subcategory *</label>
                        <select id="subcategory_id" name="subcategory_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('subcategory_id') border-red-500 @enderror">
                            <option value="">Select a subcategory</option>
                            @foreach($categories as $category)
                                @foreach($category->activeSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category="{{ $category->id }}" style="display:none;">
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Content Type *</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                            <input type="radio" name="type" value="text" class="hidden content-type-radio" required {{ old('type') === 'text' ? 'checked' : '' }}>
                            <div class="flex items-center w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Text</p>
                                    <p class="text-xs text-gray-500">Rich text content</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                            <input type="radio" name="type" value="qa" class="hidden content-type-radio" required {{ old('type') === 'qa' ? 'checked' : '' }}>
                            <div class="flex items-center w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Q&A</p>
                                    <p class="text-xs text-gray-500">Question & Answer</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                            <input type="radio" name="type" value="pdf" class="hidden content-type-radio" required {{ old('type') === 'pdf' ? 'checked' : '' }}>
                            <div class="flex items-center w-full">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">PDF</p>
                                    <p class="text-xs text-gray-500">PDF document</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Text Content (shown when type is text) -->
                <div id="text_content_field" class="content-field" style="display:none;">
                    <label for="text_content" class="block text-sm font-medium text-gray-700 mb-2">Text Content *</label>
                    <textarea id="text_content" name="text_content" rows="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('text_content') border-red-500 @enderror">{{ old('text_content') }}</textarea>
                    @error('text_content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Q&A Fields (shown when type is qa) -->
                <div id="qa_fields" class="content-field" style="display:none;">
                    <div class="space-y-4">
                        <div>
                            <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Question *</label>
                            <textarea id="question" name="question" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('question') border-red-500 @enderror">{{ old('question') }}</textarea>
                            @error('question')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Answer *</label>
                            <textarea id="answer" name="answer" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('answer') border-red-500 @enderror">{{ old('answer') }}</textarea>
                            @error('answer')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- PDF URL (shown when type is pdf) -->
                <div id="pdf_field" class="content-field" style="display:none;">
                    <label for="pdf_url" class="block text-sm font-medium text-gray-700 mb-2">PDF URL * (Backblaze or External URL)</label>
                    <input type="url" id="pdf_url" name="pdf_url" value="{{ old('pdf_url') }}" placeholder="https://f000.backblazeb2.com/file/bucket-name/file.pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('pdf_url') border-red-500 @enderror">
                    @error('pdf_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Enter the full URL of your PDF file hosted on Backblaze B2 or any other CDN</p>
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active (visible to users)</label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('content.contents.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    Create Content
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Category/Subcategory filter
document.getElementById('category_select').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategory_id');
    const options = subcategorySelect.querySelectorAll('option[data-category]');
    
    // Reset subcategory
    subcategorySelect.value = '';
    
    // Show/hide subcategories based on selected category
    options.forEach(option => {
        if (option.dataset.category === categoryId) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
});

// Content type radio buttons
const typeRadios = document.querySelectorAll('.content-type-radio');
const contentFields = document.querySelectorAll('.content-field');

typeRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        // Update label styles
        document.querySelectorAll('label:has(.content-type-radio)').forEach(label => {
            label.classList.remove('border-green-500', 'bg-green-50');
            label.classList.add('border-gray-300');
        });
        
        if (this.checked) {
            this.closest('label').classList.remove('border-gray-300');
            this.closest('label').classList.add('border-green-500', 'bg-green-50');
        }
        
        // Show/hide relevant fields
        contentFields.forEach(field => field.style.display = 'none');
        
        if (this.value === 'text') {
            document.getElementById('text_content_field').style.display = 'block';
        } else if (this.value === 'qa') {
            document.getElementById('qa_fields').style.display = 'block';
        } else if (this.value === 'pdf') {
            document.getElementById('pdf_field').style.display = 'block';
        }
    });
    
    // Trigger change on page load if checked
    if (radio.checked) {
        radio.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection

