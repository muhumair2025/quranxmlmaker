@extends('layouts.app')

@section('title', 'Audio File - ' . $title)

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Home
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h1>
        <p class="text-gray-600">Select a Surah to start adding audio URLs</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="space-y-6">
            <!-- Surah Selection -->
            <div>
                <label for="surah" class="block text-sm font-medium text-gray-700 mb-2">Select Surah</label>
                <select name="surah" id="surah" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white">
                    <option value="">Choose a Surah...</option>
                    @foreach($surahs as $index => $surah)
                        <option value="{{ $index }}" {{ old('surah') == $index ? 'selected' : '' }}>
                            {{ $index }}. {{ $surah['name'] }} ({{ $surah['pashto'] }}) - {{ $surah['ayahs'] }} verses
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Button -->
            <div>
                <button id="startBtn" disabled
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-green-600">
                    Continue
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
            window.location.href = `{{ url('/audio/' . $type . '/surah') }}/${surahIndex}/ayah/1`;
        };
    } else {
        startBtn.disabled = true;
        startBtn.onclick = null;
    }
});
</script>
@endpush
@endsection
