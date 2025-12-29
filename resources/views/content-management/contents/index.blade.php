@extends('layouts.app')

@section('title', 'Manage Contents')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Contents</h1>
            <p class="text-sm text-gray-600">Manage all your content items (Text, Q&A, PDF, Audio, Video)</p>
        </div>
        <a href="{{ route('content.contents.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors flex items-center text-sm shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Content
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg border border-gray-200 p-2 mb-6 shadow-sm">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('content.categories.index') }}" class="flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium transition-colors text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Categories
            </a>
            <a href="{{ route('content.subcategories.index') }}" class="flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md font-medium transition-colors text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                Subcategories
            </a>
            <a href="{{ route('content.contents.index') }}" class="flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md font-medium transition-colors text-sm shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Contents
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-2.5 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contents List - Compact Table Style -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-12">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subcategory</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-20">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">Order</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider w-28">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($contents as $content)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Type Icon -->
                        <td class="px-4 py-3">
                            @if($content->type === 'text')
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100" title="Text Content">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            @elseif($content->type === 'qa')
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100" title="Q&A Content">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @elseif($content->type === 'pdf')
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-100" title="PDF Document">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @elseif($content->type === 'audio')
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100" title="Audio File">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                    </svg>
                                </div>
                            @elseif($content->type === 'video')
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100" title="Video File">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        <!-- Title -->
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900">{{ Str::limit($content->title, 60) }}</span>
                                @if($content->type === 'text')
                                    <span class="text-xs text-gray-500 mt-0.5">{{ Str::limit(strip_tags($content->text_content), 80) }}</span>
                                @elseif($content->type === 'qa')
                                    <span class="text-xs text-gray-500 mt-0.5">Q: {{ Str::limit($content->question, 70) }}</span>
                                @elseif($content->type === 'pdf' && $content->pdf_url)
                                    <a href="{{ $content->pdf_url }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-700 mt-0.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        View PDF
                                    </a>
                                @elseif($content->type === 'audio' && $content->audio_url)
                                    <a href="{{ $content->audio_url }}" target="_blank" class="text-xs text-orange-600 hover:text-orange-700 mt-0.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Listen
                                    </a>
                                @elseif($content->type === 'video' && $content->video_url)
                                    <a href="{{ $content->video_url }}" target="_blank" class="text-xs text-purple-600 hover:text-purple-700 mt-0.5 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Watch
                                    </a>
                                @endif
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                @if($content->subcategory->category->icon_url)
                                    <img src="{{ $content->subcategory->category->icon_url }}" alt="" class="w-5 h-5 rounded mr-2">
                                @endif
                                <span class="text-sm text-gray-900 font-medium">{{ Str::limit($content->subcategory->category->name_english, 30) }}</span>
                            </div>
                        </td>

                        <!-- Subcategory -->
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-700">{{ Str::limit($content->subcategory->name, 30) }}</span>
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3">
                            @if($content->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Order -->
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-500">{{ $content->order }}</span>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('content.contents.edit', $content) }}" class="text-blue-600 hover:text-blue-700 font-medium text-xs px-2 py-1 rounded hover:bg-blue-50 transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('content.contents.destroy', $content) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-xs px-2 py-1 rounded hover:bg-red-50 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-base font-medium text-gray-900 mb-1">No content yet</h3>
                            <p class="text-sm text-gray-500 mb-4">Get started by creating your first content item</p>
                            <a href="{{ route('content.contents.create') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Content
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($contents->hasPages())
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
    @endif

    <!-- Legend -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-blue-900 mb-3">Content Types Legend:</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-100 mr-2">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-700 font-medium">Text</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-green-100 mr-2">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-700 font-medium">Q&A</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-red-100 mr-2">
                    <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-700 font-medium">PDF</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-orange-100 mr-2">
                    <svg class="w-3.5 h-3.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-700 font-medium">Audio</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-purple-100 mr-2">
                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-700 font-medium">Video</span>
            </div>
        </div>
    </div>
</div>
@endsection
