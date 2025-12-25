@extends('layouts.app')

@section('title', 'Edit Hero Slide')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('app.hero.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Hero Slides
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-2">Edit Hero Slide</h1>
        <p class="text-gray-600">Update the hero slide details</p>
    </div>

    <!-- Current Image Preview -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <h3 class="text-sm font-medium text-gray-700 mb-3">Current Image</h3>
        <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="max-w-md rounded shadow-lg">
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('app.hero.update', $slide) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Image Upload (Optional for edit) -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Hero Image (Optional - leave empty to keep current)</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Upload a new image only if you want to replace the current one</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title (Optional)</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $slide->title) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $slide->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Text & Link -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text (Optional)</label>
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $slide->button_text) }}" placeholder="Learn More"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('button_text') border-red-500 @enderror">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">Button Link (Optional)</label>
                        <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $slide->button_link) }}" placeholder="/categories/1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('button_link') border-red-500 @enderror">
                        @error('button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Deep link or route path for the app</p>
                    </div>
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order *</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $slide->order) }}" min="0" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('order') border-red-500 @enderror">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first in the slider</p>
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active (visible in app)</label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('app.hero.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                    Update Hero Slide
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

