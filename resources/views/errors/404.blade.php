@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-blue-600 mb-4">404</h1>
        <h2 class="text-2xl font-semibold mb-2">Halaman Tidak Ditemukan</h2>
        <p class="mb-6 text-gray-600">Maaf, halaman yang Anda cari tidak ditemukan atau sudah dipindahkan.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection
