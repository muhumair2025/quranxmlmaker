@extends('layouts.app')

@section('title', 'Manage Contents')

@section('content')
<div>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Contents</h1>
            <p class="text-gray-600">Manage all your content items (Text, Q&A, PDF)</p>
        </div>
        <a href="{{ route('content.contents.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Content
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contents List -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        @forelse($contents as $content)
        <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <!-- Content Type Badge -->
                        @if($content->type === 'text')
                            <span class="px-2 py-1 text-xs font-medium rounded bg-blue-100 text-blue-800 mr-3">TEXT</span>
                        @elseif($content->type === 'qa')
                            <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800 mr-3">Q&A</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-800 mr-3">PDF</span>
                        @endif

                        <h3 class="text-lg font-semibold text-gray-900">{{ $content->title }}</h3>
                        
                        <span class="ml-3 px-2 py-1 text-xs font-medium rounded {{ $content->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center text-sm text-gray-600 space-x-4 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Category: <strong class="ml-1">{{ $content->subcategory->category->name }}</strong>
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            Subcategory: <strong class="ml-1">{{ $content->subcategory->name }}</strong>
                        </span>
                        <span class="text-gray-400">Order: {{ $content->order }}</span>
                    </div>
                    
                    <!-- Content Preview -->
                    @if($content->type === 'text' && $content->text_content)
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit(strip_tags($content->text_content), 150) }}</p>
                    @elseif($content->type === 'qa')
                        <p class="text-sm text-gray-600 mt-2"><strong>Q:</strong> {{ Str::limit($content->question, 100) }}</p>
                    @elseif($content->type === 'pdf' && $content->pdf_url)
                        <p class="text-sm text-gray-600 mt-2 flex items-start">
                            <svg class="w-4 h-4 mr-1 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <a href="{{ $content->pdf_url }}" target="_blank" class="text-blue-600 hover:text-blue-700 underline break-all">
                                {{ Str::limit($content->pdf_url, 80) }}
                            </a>
                        </p>
                    @endif
                </div>

                <div class="flex space-x-3 ml-6">
                    <a href="{{ route('content.contents.edit', $content) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Edit
                    </a>
                    <form action="{{ route('content.contents.destroy', $content) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No content yet</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first content item</p>
            <a href="{{ route('content.contents.create') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Content
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($contents->hasPages())
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
    @endif
</div>
@endsection

