@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Password</h2>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $email) }}"
                    required 
                    autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="Enter your email"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="Enter new password"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm New Password
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Confirm new password"
                >
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium"
            >
                Reset Password
            </button>
        </form>

        <!-- Back to Login Link -->
        <div class="mt-6 text-center">
            <a 
                href="{{ route('login') }}" 
                class="text-sm text-green-600 hover:text-green-700 hover:underline"
            >
                ← Back to Login
            </a>
        </div>
    </div>
</div>
@endsection

