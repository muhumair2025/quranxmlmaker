@extends('layouts.app')

@section('title', 'Audio File - ' . $title)

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-medium">URL saved successfully!</span>
            </div>
        </div>
    @endif

    <!-- Quick Navigation Buttons -->
    <div class="mb-6 flex flex-wrap gap-3 items-center">
        <a href="{{ route('audio.form', $type) }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors px-3 py-1.5 rounded-md hover:bg-gray-100">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Surah Selection
            <span class="ml-2 text-xs text-gray-400">(Alt+S)</span>
        </a>
        <a href="{{ route('home') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors px-3 py-1.5 rounded-md hover:bg-gray-100">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Back to Home
            <span class="ml-2 text-xs text-gray-400">(Alt+H)</span>
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
        <p class="text-gray-600 text-sm">
            {{ $surahs[$currentSurah]['name'] }} ({{ $surahs[$currentSurah]['pashto'] }}) - Verse {{ $currentAyah }} of {{ $maxAyahs }}
        </p>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full transition-all duration-300" 
                 style="width: {{ ($currentAyah / $maxAyahs) * 100 }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-1 text-right">{{ $currentAyah }} / {{ $maxAyahs }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <form action="{{ route('audio.save', $type) }}" method="POST" class="space-y-6">
            @csrf
            
            <input type="hidden" name="surah" value="{{ $currentSurah }}">
            <input type="hidden" name="ayah" value="{{ $currentAyah }}">
            
            <!-- Audio Link -->
            <div>
                <label for="audio_link" class="block text-sm font-medium text-gray-700 mb-2">
                    Audio File URL
                    <span class="text-xs text-gray-400 font-normal ml-2">(Ctrl+V to paste)</span>
                </label>
                <div class="relative">
                    <input type="url" name="audio_link" id="audio_link" required
                           value="{{ $existingUrl }}"
                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                           placeholder="https://example.com/audio.mp3">
                    <button type="button" id="pasteBtn" 
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium transition-colors flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Paste
                    </button>
                </div>
                @error('audio_link')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Navigation Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Previous Button -->
                @if($currentAyah > 1 || $currentSurah > 1)
                    <button type="submit" name="action" value="previous" id="prevBtn"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center border border-gray-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                        <span class="ml-2 text-xs text-gray-400">(←)</span>
                    </button>
                @endif

                <!-- Save & Stay Button -->
                <button type="submit" name="action" value="stay" id="saveBtn"
                        class="flex-1 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center border border-yellow-300">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save
                    <span class="ml-2 text-xs text-gray-400">(Enter)</span>
                </button>

                <!-- Next Button -->
                @if($currentAyah < $maxAyahs || $currentSurah < 114)
                    <button type="submit" name="action" value="next" id="nextBtn"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center">
                        Next
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ml-2 text-xs text-white/70">(→)</span>
                    </button>
                @endif
            </div>

            <!-- Generate XML Button -->
            <div class="pt-6 border-t border-gray-200">
                <button type="submit" name="action" value="generate_complete_xml"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generate Complete XML
                </button>
                <p class="text-xs text-gray-500 mt-2 text-center">Creates XML file with all saved URLs</p>
            </div>
        </form>
    </div>

    <!-- Quick Navigation -->
    <div class="bg-white rounded-lg border border-gray-200 p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Quick Navigation</h3>
        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-2">
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
                   class="p-2 text-center rounded-md border transition-all duration-200 relative text-sm
                   {{ $hasUrl1 ? 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100' : 
                      'bg-gray-50 hover:bg-gray-100 border-gray-200 hover:border-gray-300' }}">
                    1
                    @if($hasUrl1)
                        <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
                    @endif
                </a>
                @if($startVerse > 2)
                    <div class="p-2 text-center text-gray-400 text-sm">...</div>
                @endif
            @endif
            
            @for($i = $startVerse; $i <= $endVerse; $i++)
                @php
                    $hasUrl = in_array($i, $savedVerses);
                    $isCurrent = $i == $currentAyah;
                @endphp
                <a href="{{ route('audio.form.ayah', [$type, $currentSurah, $i]) }}" 
                   class="p-2 text-center rounded-md border transition-all duration-200 relative text-sm
                   {{ $isCurrent ? 'bg-green-600 text-white border-green-600' : 
                      ($hasUrl ? 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100' : 
                       'bg-gray-50 hover:bg-gray-100 border-gray-200 hover:border-gray-300') }}">
                    {{ $i }}
                    @if($hasUrl && !$isCurrent)
                        <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
                    @endif
                </a>
            @endfor
            
            @if($endVerse < $maxAyahs)
                @if($endVerse < $maxAyahs - 1)
                    <div class="p-2 text-center text-gray-400 text-sm">...</div>
                @endif
                @php $hasUrlLast = in_array($maxAyahs, $savedVerses); @endphp
                <a href="{{ route('audio.form.ayah', [$type, $currentSurah, $maxAyahs]) }}" 
                   class="p-2 text-center rounded-md border transition-all duration-200 relative text-sm
                   {{ $hasUrlLast ? 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100' : 
                      'bg-gray-50 hover:bg-gray-100 border-gray-200 hover:border-gray-300' }}">
                    {{ $maxAyahs }}
                    @if($hasUrlLast)
                        <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-green-500 rounded-full border border-white"></span>
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audioInput = document.getElementById('audio_link');
    const pasteBtn = document.getElementById('pasteBtn');
    const saveBtn = document.getElementById('saveBtn');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const form = document.querySelector('form');

    // Paste button functionality
    pasteBtn.addEventListener('click', async function() {
        try {
            const text = await navigator.clipboard.readText();
            audioInput.value = text;
            audioInput.focus();
            audioInput.select();
            
            // Show brief feedback
            const originalText = pasteBtn.innerHTML;
            pasteBtn.innerHTML = '<svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Pasted!';
            pasteBtn.classList.add('bg-green-100', 'text-green-700');
            pasteBtn.classList.remove('bg-gray-100', 'text-gray-700');
            
            setTimeout(() => {
                pasteBtn.innerHTML = originalText;
                pasteBtn.classList.remove('bg-green-100', 'text-green-700');
                pasteBtn.classList.add('bg-gray-100', 'text-gray-700');
            }, 1000);
        } catch (err) {
            // Fallback: focus input and let user paste manually
            audioInput.focus();
            audioInput.select();
            alert('Please paste using Ctrl+V (or Cmd+V on Mac)');
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        const isInputFocused = e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA';
        
        // Arrow keys work even when input is focused
        // Arrow Left: Previous
        if (e.key === 'ArrowLeft' && prevBtn && !e.ctrlKey && !e.altKey && !e.metaKey) {
            e.preventDefault();
            prevBtn.click();
            return;
        }

        // Arrow Right: Next
        if (e.key === 'ArrowRight' && nextBtn && !e.ctrlKey && !e.altKey && !e.metaKey) {
            e.preventDefault();
            nextBtn.click();
            return;
        }

        // Don't trigger other shortcuts when typing in input (except arrow keys and Enter)
        if (isInputFocused) {
            // Allow Enter to save when in URL input
            if (e.key === 'Enter' && e.target.id === 'audio_link' && !e.shiftKey) {
                e.preventDefault();
                saveBtn.click();
                return;
            }
            return;
        }

        // Alt + S: Back to Surah Selection
        if (e.altKey && e.key === 's') {
            e.preventDefault();
            window.location.href = '{{ route("audio.form", $type) }}';
            return;
        }

        // Alt + H: Back to Home
        if (e.altKey && e.key === 'h') {
            e.preventDefault();
            window.location.href = '{{ route("home") }}';
            return;
        }

        // Enter: Save
        if (e.key === 'Enter' && !e.shiftKey && !e.ctrlKey && !e.altKey) {
            e.preventDefault();
            saveBtn.click();
            return;
        }
    });

    // Auto-focus URL input on page load
    if (audioInput && !audioInput.value) {
        audioInput.focus();
    }

    // Ctrl+V / Cmd+V visual feedback
    audioInput.addEventListener('paste', function() {
        setTimeout(() => {
            this.select();
        }, 10);
    });
});
</script>
@endpush
@endsection
