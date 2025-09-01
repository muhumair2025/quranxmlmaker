@extends('layouts.app')

@section('title', 'XML Generated')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Success Message -->
    <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold text-lg">Your XML file has been generated successfully!</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- XML Preview -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center leading-relaxed">XML File</h2>
            
            <!-- File Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><strong>Surah:</strong> {{ $surah['name'] }} ({{ $surah['pashto'] }})</div>
                    <div><strong>Verse:</strong> {{ $ayah }}</div>
                    <div><strong>Type:</strong> {{ $mediaType == 'audio' ? 'Audio' : 'Video' }}</div>
                    <div><strong>Filename:</strong> {{ $filename }}</div>
                </div>
            </div>

            <!-- XML Content -->
            <div class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto code-scroll">
                <pre class="text-sm font-mono whitespace-pre-wrap"><code>{{ $xml }}</code></pre>
            </div>

            <!-- Download Button -->
            <div class="text-center mt-6">
                <a href="{{ route('download.xml', [$type, $filename]) }}" 
                   class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download XML File
                </a>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-6">
            <!-- Create Another -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 text-center leading-relaxed">Create More Files</h3>
                
                <div class="space-y-4">
                    <a href="{{ route($mediaType . '.form', $type) }}" 
                       class="w-full bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Another File of This Type
                    </a>

                    <a href="{{ route('home') }}" 
                       class="w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Go to Home
                    </a>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-bold text-blue-800 mb-4 text-center leading-relaxed">Usage Instructions</h3>
                
                <div class="text-blue-700 space-y-2 text-sm">
                    <p class="flex items-start">
                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold ml-2 mt-0.5">1</span>
                        Download the XML file
                    </p>
                    <p class="flex items-start">
                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold ml-2 mt-0.5">2</span>
                        Use this file in your app project
                    </p>
                    <p class="flex items-start">
                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold ml-2 mt-0.5">3</span>
                        Create more files for other verses
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
