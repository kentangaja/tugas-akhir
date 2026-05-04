@extends('layouts.app')

@section('title', '403 Forbidden')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-7xl font-bold text-yellow-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold mb-2">Akses Ditolak</h2>
        <p class="mb-6 text-gray-600">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Kembali ke Beranda</a>
    </div>
</div>
@endsection
