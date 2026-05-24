@extends('layouts.app')

@section('title', '403 Forbidden')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#F9FBF9] px-4">
    <div class="text-center max-w-md p-8 bg-white border border-[#E2EAE2] rounded-[32px] shadow-sm">
        
        <div class="mb-6 flex justify-center">
            <div class="w-16 h-16 bg-[#E8F5E9] text-[#1B4332] rounded-full flex items-center justify-center text-3xl font-bold">
                !
            </div>
        </div>

        <h1 class="text-8xl font-bold text-[#1B4332] tracking-tight mb-2">
            403
        </h1>
        
        <div class="inline-block bg-[#E2F0D9] text-[#1B4332] font-medium px-4 py-1.5 rounded-full text-sm mb-4">
            Akses Ditolak 🛑
        </div>

        <p class="text-gray-600 mb-8 text-sm sm:text-base leading-relaxed">
            Maaf, Anda tidak memiliki izin atau hak akses untuk melihat halaman ini. Silakan kembali ke jalan yang hijau.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-[#1B4332] text-white font-medium text-sm rounded-full hover:bg-[#122C21] transition-all duration-300 shadow-md hover:shadow-lg">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection