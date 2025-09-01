@extends('layouts.app')

@section('title', 'Home - Quran XML Generator')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($cardTitles as $type => $title)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-500 to-blue-500 p-6 text-white">
                <h2 class="text-xl font-bold text-center leading-relaxed">{{ $title }}</h2>
            </div>
            
            <!-- Card Body -->
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Audio Button -->
                    <a href="{{ route('audio.form', $type) }}" 
                       class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center group">
                        <svg class="w-6 h-6 ml-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.816L4.5 13.5H3a1 1 0 01-1-1V7.5a1 1 0 011-1h1.5l3.883-3.316zm2.617 2.22a1 1 0 011.414 0 5.5 5.5 0 010 7.778 1 1 0 01-1.414-1.414 3.5 3.5 0 000-4.95 1 1 0 010-1.414zm3 0a1 1 0 011.414 0 9.5 9.5 0 010 13.434 1 1 0 01-1.414-1.414 7.5 7.5 0 000-10.606 1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Audio
                    </a>

                    <!-- Video Button -->
                    <a href="{{ route('video.form', $type) }}" 
                       class="w-full bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center group">
                        <svg class="w-6 h-6 ml-2 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                        </svg>
                        Video
                    </a>

                    <!-- Matan Button (Disabled for now) -->
                    <button disabled 
                            class="w-full bg-gray-300 text-gray-500 font-bold py-4 px-6 rounded-xl cursor-not-allowed flex items-center justify-center">
                        <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0h8v12H6V4z" clip-rule="evenodd"></path>
                        </svg>
                        Text (Coming Soon)
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection
