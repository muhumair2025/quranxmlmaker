@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
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
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember" 
                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                >
                <label for="remember" class="ml-2 text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium"
            >
                Login
            </button>
        </form>

        <!-- Forgot Password Link -->
        <div class="mt-6 text-center">
            <a 
                href="{{ route('password.request') }}" 
                class="text-sm text-green-600 hover:text-green-700 hover:underline"
            >
                Forgot your password?
            </a>
        </div>

        <!-- Register Link (only show if no users exist) -->
        @php
            $userExists = \App\Models\User::count() === 0;
        @endphp
        @if($userExists)
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a 
                        href="{{ route('register') }}" 
                        class="text-green-600 hover:text-green-700 font-medium hover:underline"
                    >
                        Register here
                    </a>
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

