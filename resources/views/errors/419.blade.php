@extends('layouts.app')

@section('title', '419 Page Expired')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-pink-500 mb-4">419</h1>
        <h2 class="text-2xl font-semibold mb-2">Halaman Kadaluarsa</h2>
        <p class="mb-6 text-gray-600">Halaman ini sudah kadaluarsa. Silakan refresh dan coba lagi.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection
