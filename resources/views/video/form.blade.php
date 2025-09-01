@extends('layouts.app')

@section('title', 'Video File - ' . $title)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Home
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 leading-relaxed">{{ $title }}</h1>
            <p class="text-gray-600 leading-relaxed">Create XML file for video content</p>
        </div>

        <div class="space-y-6">
            <!-- Surah Selection -->
            <div>
                <label for="surah" class="block text-lg font-semibold text-gray-700 mb-3">Select Surah:</label>
                <select name="surah" id="surah" required
                        class="w-full p-4 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 text-lg">
                    <option value="">Select a Surah</option>
                    @foreach($surahs as $index => $surah)
                        <option value="{{ $index }}" {{ old('surah') == $index ? 'selected' : '' }}>
                            {{ $index }}. {{ $surah['name'] }} ({{ $surah['pashto'] }}) - {{ $surah['ayahs'] }} verses
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Button -->
            <div class="text-center pt-4">
                <button id="startBtn" disabled
                        class="bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold py-4 px-8 rounded-xl text-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                    Start - Add Verse URLs
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('surah').addEventListener('change', function() {
    const surahIndex = this.value;
    const startBtn = document.getElementById('startBtn');
    
    if (surahIndex) {
        startBtn.disabled = false;
        startBtn.onclick = function() {
            window.location.href = `{{ url('/video/' . $type . '/surah') }}/${surahIndex}/ayah/1`;
        };
    } else {
        startBtn.disabled = true;
        startBtn.onclick = null;
    }
});
</script>
@endpush
@endsection
