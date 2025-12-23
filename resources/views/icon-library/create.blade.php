@extends('layouts.app')

@section('title', 'Upload Icon')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('icon-library.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Icon Library
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-2">Upload Icon</h1>
        <p class="text-gray-600">Add a new icon to your library</p>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('icon-library.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Icon Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Icon Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        placeholder="e.g., Islamic Studies Icon">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Give your icon a descriptive name</p>
                </div>

                <!-- Icon File Upload -->
                <div>
                    <label for="icon_file" class="block text-sm font-medium text-gray-700 mb-2">Icon File *</label>
                    
                    <!-- File Input -->
                    <div class="flex items-center justify-center w-full">
                        <label for="icon_file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center py-6" id="upload-placeholder">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, SVG, WEBP (MAX. 2MB)</p>
                                <p class="text-[10px] text-gray-400 mt-1">Recommended: Square images (e.g., 512x512px)</p>
                            </div>
                            
                            <!-- Preview -->
                            <div id="icon-preview" class="hidden w-full h-full p-6 flex items-center justify-center">
                                <div class="relative">
                                    <img id="preview-image" src="" alt="Preview" class="max-w-[160px] max-h-[160px] object-contain mx-auto border border-gray-200 rounded p-2 bg-white">
                                    <button type="button" onclick="resetUpload()" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <input id="icon_file" name="icon_file" type="file" class="hidden" accept=".png,.jpg,.jpeg,.svg,.webp" required />
                        </label>
                    </div>
                    
                    @error('icon_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Icon Upload Guidelines:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-700">
                                <li>Supported formats: PNG, JPG, JPEG, SVG, WEBP</li>
                                <li>Maximum file size: 2MB</li>
                                <li>Recommended: Square images for best display</li>
                                <li>SVG files work best for scalability</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('icon-library.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                    Upload Icon
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Image preview
document.getElementById('icon_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('icon-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Reset upload
function resetUpload() {
    document.getElementById('icon_file').value = '';
    document.getElementById('preview-image').src = '';
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('icon-preview').classList.add('hidden');
}
</script>
@endpush
@endsection

