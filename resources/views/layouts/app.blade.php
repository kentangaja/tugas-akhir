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

    {{-- Loading Overlay (Pure JavaScript) --}}
    <div id="loading-overlay"
         style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(255,255,255,0.9); align-items:center; justify-content:center; flex-direction:column;">
        <video id="loading-video" autoplay loop muted playsinline style="width:256px; height:256px;">
            <source src="{{ asset('img/loading.webm') }}" type="video/webm">
            Your browser does not support the video tag.
        </video>
        <p style="margin-top:1rem; color:#4b5563; font-weight:500;">Mohon tunggu...</p>
    </div>

    <script>
        // Set video speed
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('loading-video');
            if (video) video.playbackRate = 2.5;
        });

        // Safety net - paksa hilang setelah 3 detik
        setTimeout(() => {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) overlay.style.display = 'none';
        }, 3000);
    </script>
</body>
</html>