@extends('layouts.app')

@section('title', '500 Internal Server Error')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-red-600 mb-4">500</h1>
        <h2 class="text-2xl font-semibold mb-2">Terjadi Kesalahan Server</h2>
        <p class="mb-6 text-gray-600">Maaf, terjadi kesalahan pada server kami. Silakan coba beberapa saat lagi.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection
