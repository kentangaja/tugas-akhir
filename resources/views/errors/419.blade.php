@extends('layouts.app')

@section('title', '419 Page Expired')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#F9FBF9] px-4">
    <div class="text-center max-w-md p-8 bg-white border border-[#E2EAE2] rounded-[32px] shadow-sm">
        
        <div class="mb-6 flex justify-center">
            <div class="w-16 h-16 bg-[#E8F5E9] text-[#1B4332] rounded-full flex items-center justify-center text-3xl font-bold">
                ⏳
            </div>
        </div>

        <h1 class="text-8xl font-bold text-[#1B4332] tracking-tight mb-2">
            419
        </h1>
        
        <div class="inline-block bg-[#E2F0D9] text-[#1B4332] font-medium px-4 py-1.5 rounded-full text-sm mb-4">
            Sesi Telah Berakhir 🍂
        </div>

        <p class="text-gray-600 mb-8 text-sm sm:text-base leading-relaxed">
            Halaman ini sudah kedaluwarsa demi keamanan. Silakan muat ulang (refresh) halaman ini dan coba lagi.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-3">
            <button onclick="window.location.reload();" class="inline-block px-6 py-3 bg-[#1B4332] text-white font-medium text-sm rounded-full hover:bg-[#122C21] transition-all duration-300 shadow-md hover:shadow-lg">
                Muat Ulang Halaman
            </button>
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-white text-[#1B4332] border border-[#1B4332] font-medium text-sm rounded-full hover:bg-[#F4F9F4] transition-all duration-300">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection