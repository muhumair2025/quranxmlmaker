<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quran XML Generator')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 leading-relaxed">
                Quran XML Generator
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Create XML files for audio, video and text content of Quranic verses
            </p>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-500">
                Quran XML Generator - {{ date('Y') }}
            </p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
