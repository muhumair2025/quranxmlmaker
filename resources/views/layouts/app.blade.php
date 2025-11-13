<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quran XML Generator')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-900 hover:text-green-600 transition-colors">
                        Quran XML
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.index') }}" class="text-sm text-gray-700 hover:text-green-600 transition-colors font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Admin
                            </a>
                        @endif
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-600">
                                <span class="font-medium text-gray-900">{{ Auth::user()->name }}</span>
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-red-600 transition-colors font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 transition-colors font-medium">
                            Login
                        </a>
                        @php
                            $userExists = \App\Models\User::count() === 0;
                        @endphp
                        @if($userExists)
                            <a href="{{ route('register') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-200 mt-2">
                <div class="flex flex-col space-y-3 pt-4">
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.index') }}" class="text-sm text-gray-700 hover:text-green-600 transition-colors font-medium flex items-center px-2 py-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Admin Panel
                            </a>
                        @endif
                        <div class="px-2 py-2">
                            <span class="text-sm text-gray-600">
                                <span class="font-medium text-gray-900">{{ Auth::user()->name }}</span>
                            </span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="px-2">
                            @csrf
                            <button type="submit" class="text-sm text-gray-700 hover:text-red-600 transition-colors font-medium w-full text-left">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 transition-colors font-medium px-2 py-2">
                            Login
                        </a>
                        @php
                            $userExists = \App\Models\User::count() === 0;
                        @endphp
                        @if($userExists)
                            <a href="{{ route('register') }}" class="text-sm bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium text-center block">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">
                © {{ date('Y') }} Quran XML Generator. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
