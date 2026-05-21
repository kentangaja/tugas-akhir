<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/logo-vm.svg') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Loading Screen -->
    <div x-data="{ loading: false }" 
         x-show="loading" 
         x-transition.opacity.duration.500ms
         @loading.window="loading = $event.detail.isLoading" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-90">
        
        <div class="flex flex-col items-center">
            <video
                x-init="$el.playbackRate = 2.5" 
                autoplay 
                loop 
                muted 
                playsinline 
                class="w-64 h-64">
                <source src="{{ asset('img/loading.webm') }}" type="video/webm">
                Your browser does not support the video tag.
            </video>         
            <p class="mt-4 text-gray-600 font-medium">Mohon tunggu...</p>
        </div>
    </div>
</body>
</html>