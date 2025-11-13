@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Verify Your Email</h2>
            <p class="text-sm text-gray-600">
                We've sent a 6-digit verification code to<br>
                <span class="font-medium text-gray-800">{{ Auth::user()->email }}</span>
            </p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm" class="space-y-6">
            @csrf

            <!-- OTP Input Boxes -->
            <div class="flex justify-center gap-3 mb-6">
                <input 
                    type="text" 
                    name="otp_1" 
                    id="otp_1"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    autofocus
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="1"
                >
                <input 
                    type="text" 
                    name="otp_2" 
                    id="otp_2"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="2"
                >
                <input 
                    type="text" 
                    name="otp_3" 
                    id="otp_3"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="3"
                >
                <input 
                    type="text" 
                    name="otp_4" 
                    id="otp_4"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="4"
                >
                <input 
                    type="text" 
                    name="otp_5" 
                    id="otp_5"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="5"
                >
                <input 
                    type="text" 
                    name="otp_6" 
                    id="otp_6"
                    maxlength="1" 
                    pattern="[0-9]"
                    inputmode="numeric"
                    required
                    class="w-14 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('otp') border-red-500 @enderror otp-input"
                    data-index="6"
                >
            </div>

            @error('otp')
                <p class="text-sm text-red-600 text-center">{{ $message }}</p>
            @enderror

            <!-- Hidden input for complete OTP -->
            <input type="hidden" name="otp" id="otp_complete">

            <!-- Submit Button -->
            <button 
                type="submit" 
                id="submitBtn"
                class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium text-lg disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Verify Code
            </button>
        </form>

        <!-- Resend OTP -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 mb-2">
                Didn't receive the code?
            </p>
            <form method="POST" action="{{ route('otp.resend') }}" class="inline">
                @csrf
                <button 
                    type="submit" 
                    class="text-sm text-green-600 hover:text-green-700 font-medium hover:underline"
                >
                    Resend Code
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const form = document.getElementById('otpForm');
    const completeInput = document.getElementById('otp_complete');
    const submitBtn = document.getElementById('submitBtn');

    // Auto-focus and move to next input
    inputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;

            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateCompleteOtp();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/[^0-9]/g, '').slice(0, 6);
            
            digits.split('').forEach((digit, i) => {
                if (inputs[index + i]) {
                    inputs[index + i].value = digit;
                }
            });

            if (digits.length === 6) {
                inputs[5].focus();
            } else if (digits.length > 0) {
                inputs[Math.min(index + digits.length - 1, 5)].focus();
            }

            updateCompleteOtp();
        });
    });

    function updateCompleteOtp() {
        const otp = Array.from(inputs).map(input => input.value).join('');
        completeInput.value = otp;
        submitBtn.disabled = otp.length !== 6;
    }

    form.addEventListener('submit', function(e) {
        const otp = Array.from(inputs).map(input => input.value).join('');
        if (otp.length !== 6) {
            e.preventDefault();
            return false;
        }
        completeInput.value = otp;
    });
});
</script>
@endpush
@endsection

