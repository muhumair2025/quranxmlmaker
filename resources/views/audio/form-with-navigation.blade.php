@extends('layouts.app')

@section('title', 'Audio File - ' . $title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-6">
            <div class="flex items-center">
                <svg class="w-6 h-6 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold">URL Saved Successfully!</span>
            </div>
        </div>
    @endif

    <!-- Progress Info -->
    <div class="bg-blue-50 rounded-2xl p-6 mb-6">
        <div class="text-center">
            <h2 class="text-xl font-bold text-blue-800 mb-2 leading-relaxed">{{ $title }}</h2>
            <p class="text-blue-600">
                Surah: {{ $surahs[$currentSurah]['name'] }} ({{ $surahs[$currentSurah]['pashto'] }}) - 
                Verse: {{ $currentAyah }} of {{ $maxAyahs }}
            </p>
            <div class="w-full bg-blue-200 rounded-full h-3 mt-4">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" 
                     style="width: {{ ($currentAyah / $maxAyahs) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('audio.save', $type) }}" method="POST" class="space-y-6">
            @csrf
            
            <input type="hidden" name="surah" value="{{ $currentSurah }}">
            <input type="hidden" name="ayah" value="{{ $currentAyah }}">
            
            <!-- Current Ayah Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2 leading-relaxed">
                    Verse Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div><strong>Surah:</strong> {{ $surahs[$currentSurah]['name'] }}</div>
                    <div><strong>Verse Number:</strong> {{ $currentAyah }}</div>
                    <div><strong>Type:</strong> Audio File</div>
                </div>
            </div>

            <!-- Audio Link -->
            <div>
                <label for="audio_link" class="block text-lg font-semibold text-gray-700 mb-3">Audio File Link:</label>
                <input type="url" name="audio_link" id="audio_link" required
                       value="{{ $existingUrl }}"
                       class="w-full p-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 text-lg"
                       placeholder="https://example.com/audio.mp3">
                @error('audio_link')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Navigation Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <!-- Previous Button -->
                @if($currentAyah > 1 || $currentSurah > 1)
                    <button type="submit" name="action" value="previous"
                            class="flex-1 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous Verse
                    </button>
                @endif

                <!-- Save & Stay Button -->
                <button type="submit" name="action" value="stay"
                        class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Save & Stay
                </button>

                <!-- Next Button -->
                @if($currentAyah < $maxAyahs || $currentSurah < 114)
                    <button type="submit" name="action" value="next"
                            class="flex-1 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                        Next Verse
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @endif
            </div>

            <!-- Generate XML Button -->
            <div class="text-center pt-6 border-t border-gray-200">
                <button type="submit" name="action" value="generate_complete_xml"
                        class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-4 px-8 rounded-xl text-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generate Complete Quran XML
                </button>
                <p class="text-sm text-gray-500 mt-2">This will create XML file with all saved URLs from all surahs</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <a href="{{ route('audio.form', $type) }}" 
                   class="flex-1 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Surah Selection
                </a>

                <a href="{{ route('home') }}" 
                   class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go to Home
                </a>
            </div>
        </form>
    </div>

    <!-- Quick Navigation -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 text-center leading-relaxed">Quick Navigation</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2">
            @php
                // Calculate the range of verses to show
                $showCount = 12;
                $halfShow = floor($showCount / 2);
                
                if ($maxAyahs <= $showCount) {
                    // If total verses are 12 or less, show all
                    $startVerse = 1;
                    $endVerse = $maxAyahs;
                } elseif ($currentAyah <= $halfShow) {
                    // If current verse is in the first half, show from 1
                    $startVerse = 1;
                    $endVerse = $showCount;
                } elseif ($currentAyah > ($maxAyahs - $halfShow)) {
                    // If current verse is in the last half, show last 12
                    $startVerse = $maxAyahs - $showCount + 1;
                    $endVerse = $maxAyahs;
                } else {
                    // Show verses around current verse
                    $startVerse = $currentAyah - $halfShow;
                    $endVerse = $currentAyah + $halfShow - 1;
                }
            @endphp
            
            @if($startVerse > 1)
                @php $hasUrl1 = in_array(1, $savedVerses); @endphp
                <a href="{{ route('audio.form.ayah', [$type, $currentSurah, 1]) }}" 
                   class="p-2 text-center rounded-lg border-2 transition-all duration-200 relative
                   {{ $hasUrl1 ? 'bg-green-100 border-green-300 text-green-700 hover:bg-green-200' : 
                      'bg-gray-50 hover:bg-blue-50 border-gray-200 hover:border-blue-300' }}">
                    1
                    @if($hasUrl1)
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    @endif
                </a>
                @if($startVerse > 2)
                    <div class="p-2 text-center text-gray-500">...</div>
                @endif
            @endif
            
            @for($i = $startVerse; $i <= $endVerse; $i++)
                @php
                    $hasUrl = in_array($i, $savedVerses);
                    $isCurrent = $i == $currentAyah;
                @endphp
                <a href="{{ route('audio.form.ayah', [$type, $currentSurah, $i]) }}" 
                   class="p-2 text-center rounded-lg border-2 transition-all duration-200 relative
                   {{ $isCurrent ? 'bg-blue-500 text-white border-blue-500' : 
                      ($hasUrl ? 'bg-green-100 border-green-300 text-green-700 hover:bg-green-200' : 
                       'bg-gray-50 hover:bg-blue-50 border-gray-200 hover:border-blue-300') }}">
                    {{ $i }}
                    @if($hasUrl && !$isCurrent)
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    @endif
                </a>
            @endfor
            
            @if($endVerse < $maxAyahs)
                @if($endVerse < $maxAyahs - 1)
                    <div class="p-2 text-center text-gray-500">...</div>
                @endif
                @php $hasUrlLast = in_array($maxAyahs, $savedVerses); @endphp
                <a href="{{ route('audio.form.ayah', [$type, $currentSurah, $maxAyahs]) }}" 
                   class="p-2 text-center rounded-lg border-2 transition-all duration-200 relative
                   {{ $hasUrlLast ? 'bg-green-100 border-green-300 text-green-700 hover:bg-green-200' : 
                      'bg-gray-50 hover:bg-blue-50 border-gray-200 hover:border-blue-300' }}">
                    {{ $maxAyahs }}
                    @if($hasUrlLast)
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
