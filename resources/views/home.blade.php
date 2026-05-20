<x-app-layout>
    <style>
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: scroll 30s linear infinite;
        }
        html, body { 
            height: 100%; 
            scroll-behavior: smooth;
        }
        @keyframes scrollTeam {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
        }
        .animate-team-marquee {
            display: flex;
            width: max-content;
            animation: scrollTeam 25s linear infinite;
        }
        .animate-team-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    <div class="relative min-h-[100dvh]">
        
        <main class="max-w-7xl mx-auto px-6 pt-8 pb-25">
            
            <div class="mb-6 flex justify-end">
                <h1 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight leading-tight">
                    Menata Ruang <br>
                    <span class="bg-[#d4e9d4] px-4 py-1 rounded-full italic font-normal text-3xl md:text-4xl">Menanam</span> Masa Depan
                </h1>
            </div>

            <div class="grid grid-cols-12 gap-6 items-start">
                <div class="col-span-12 md:col-span-3">
                    <a href="#our-team" 
                    class="block bg-emerald-900 p-6 rounded-[2.5rem] shadow-sm relative overflow-hidden h-40 hover:shadow-md transition-shadow duration-200 cursor-pointer flex flex-col justify-between bg-cover bg-center"
                    style="background-image: url('{{ asset('img/wallpaper.jpg') }}');">
                    
                        <!-- Lapisan Gelap (Overlay) agar teks tetap mudah dibaca -->
                        <div class="absolute inset-0 bg-emerald-950/40 z-0"></div>

                        <!-- Konten Atas: Avatar Tim -->
                        <div class="flex -space-x-2 relative z-10">
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                        </div>
                        
                        <!-- Konten Bawah: Teks dan Ikon -->
                        <div class="p-3 h-fit w-fit rounded-[1rem] bg-white/10 backdrop-blur-md relative z-10">
                            <p class="text-lg font-bold text-white">
                                Tim Kami 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block text-white ms-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </p>
                        </div>
                    </a>
                    <div class="flex gap-3 pt-12">
                        <button class="px-6 py-2 border border-gray-300 rounded-full text-xs font-medium bg-white hover:bg-gray-100 transition-colors duration-200">Jelajahi</button>
                        <button class="px-6 py-2 bg-[#063b2a] text-white rounded-full text-xs font-medium hover:bg-[#052a1d] transition-colors duration-200">Bekerja dengan Kami</button>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-9 flex flex-col gap-4">
                    <div class="bg-gray-200 w-full h-56 md:h-64 rounded-[3.5rem] relative overflow-hidden shadow-inner">
                        
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 italic">
                            <img src="{{ asset('img/img.jpeg') }}" alt="">
                        </div>

                        <div class="absolute bottom-6 left-6 bg-white/10 backdrop-blur-md p-6 rounded-[2.5rem] max-w-[280px] shadow-sm">
                            <p class="text-xs md:text-sm text-white leading-relaxed font-medium">
                                Kami percaya bahwa masa depan kota terletak pada solusi cerdas dan ramah lingkungan yang mengatasi tantangan mendesak urbanisasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <section id="our-team" class="py-16 bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 mb-10">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold mb-2">Tim Kami</p>
                        <h2 class="text-3xl md:text-4xl font-medium text-gray-900 tracking-tight">
                            Orang-orang di balik <br>
                            <span class="bg-[#d4e9d4] px-3 py-1 rounded-full italic font-normal text-2xl md:text-3xl">Verte-Maison</span>
                        </h2>
                    </div>
                    <a href="{{ route('team') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-medium text-emerald-700 hover:text-emerald-900 transition">
                        Lihat semua
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                </div>
            </div>
        
            <div class="relative overflow-hidden mx-6">
                <div class="animate-team-marquee">
                    @php
                        $team = [
                                        [
                                            'name' => 'Bintang Putra Sugiarta',
                                            'role' => 'Ketua Tim & Konseptor',
                                            'bg'   => 'bg-emerald-100',
                                            'photo' => 'img/team/bintang-putra.jpg',
                                        ],
                                        [
                                            'name' => 'Bintang Adi Alvaro',
                                            'role' => 'Website & Maket Developer',
                                            'bg'   => 'bg-[#d4e9d4]',
                                            'photo' => 'img/team/bintang-adi.jpg',
                                        ],
                                        [
                                            'name' => 'Hardiansyah Aditya',
                                            'role' => 'UI/UX Designer & Maket Specialist',
                                            'bg'   => 'bg-lime-100',
                                            'photo' => 'img/team/hardiansyah.jpg',
                                        ],
                                        [
                                            'name' => 'Ajeng Nielza Itsna Mufida',
                                            'role' => 'WordPress & Maket Specialist',
                                            'bg'   => 'bg-emerald-50',
                                            'photo' => 'img/team/ajeng.jpg',
                                        ],
                                        [
                                            'name' => 'Akmal Wildan Pratama',
                                            'role' => 'Data Analyst & Maket Engineer',
                                            'bg'   => 'bg-green-100',
                                            'photo' => 'img/team/akmal.jpg',
                                        ],
                                        [
                                            'name' => 'Arweyn Abbygail',
                                            'role' => 'Technical Report & Maket Coordinator',
                                            'bg'   => 'bg-teal-100',
                                            'photo' => 'img/team/arweyn.jpg',
                                        ],
                                        [
                                            'name' => 'Bilqys Thalita Efendy',
                                            'role' => 'WordPress & Maket Specialist',
                                            'bg'   => 'bg-emerald-100',
                                            'photo' => 'img/team/bilqys.jpg',
                                        ],
                                        [
                                            'name' => 'Ayda Sazmita',
                                            'role' => 'Marketing & Maket Designer',
                                            'bg'   => 'bg-[#d4e9d4]',
                                            'photo' => 'img/team/ayda.jpg',
                                        ],
                                    ];
                    @endphp
        
                    @for ($i = 0; $i < 2; $i++)
                        @foreach ($team as $member)
                        <div class="mx-3 w-52 flex-shrink-0">
                            <div class="{{ $member['bg'] }} rounded-[2rem] p-6 h-64 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                                {{-- Foto --}}
                                <div class="absolute inset-0 opacity-30 bg-cover bg-center" style="background-image: url('{{ asset($member['photo']) }}')"></div>
                                <div class="relative z-10 w-14 h-14 rounded-full bg-white/70 flex items-center justify-center shadow-sm overflow-hidden">
                                    @if (file_exists(public_path($member['photo'])))
                                        <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-emerald-700">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="relative z-10">
                                    <p class="font-semibold text-gray-900 text-base">{{ $member['name'] }}</p>
                                    <p class="text-sm text-emerald-700 font-medium mt-1">{{ $member['role'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        </section>

        <section class="py-16 bg-[#f7faf7]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12">
                    <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold mb-2">Arah & Tujuan</p>
                    <h2 class="text-3xl md:text-4xl font-medium text-gray-900 tracking-tight">Visi & Misi Kami</h2>
                </div>
        
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-[#063b2a] text-white rounded-[2.5rem] p-8 md:p-10 flex flex-col justify-between min-h-[280px]">
                        <div>
                            <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 mb-6">
                                <div class="w-2 h-2 rounded-full bg-[#d4e9d4]"></div>
                                <span class="text-xs font-semibold uppercase tracking-widest text-[#d4e9d4]">Visi</span>
                            </div>
                            <p class="text-xl md:text-2xl font-medium leading-relaxed text-white/90">
                                "Menjadikan website kami teknologi yang dapat membantu lingkungan dan para pegiat tanaman yang selalu ada disaat manusia membutuhkan pangan dalam bentuk nabati."
                            </p>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="w-12 h-12 rounded-full bg-[#d4e9d4]/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#d4e9d4]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
        
                    <div class="bg-[#d4e9d4] rounded-[2.5rem] p-8 md:p-10 flex flex-col justify-between min-h-[280px]">
                        <div>
                            <div class="inline-flex items-center gap-2 bg-[#063b2a]/10 rounded-full px-4 py-1.5 mb-6">
                                <div class="w-2 h-2 rounded-full bg-[#063b2a]"></div>
                                <span class="text-xs font-semibold uppercase tracking-widest text-[#063b2a]">Misi</span>
                            </div>
                            <ul class="space-y-4">
                                @php
                                    $misi = [
                                        'Membantu para petani mengembangkan hasil pangan.',
                                        'Mempermudah pekerjaan petani dengan teknologi modern.',
                                        'Memberikan fasilitas terbaik bagi para petani Indonesia.',
                                    ];
                                @endphp
                                @foreach ($misi as $index => $item)
                                <li class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-7 h-7 rounded-full bg-[#063b2a] text-white text-xs font-bold flex items-center justify-center mt-0.5">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-gray-800 font-medium leading-relaxed">{{ $item }}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <div class="w-12 h-12 rounded-full bg-[#063b2a]/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#063b2a]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-[#063b2a] rounded-[2.5rem] px-8 md:px-16 py-12 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <p class="text-[#d4e9d4] text-xs uppercase tracking-widest font-semibold mb-2">Hubungi Kami</p>
                        <h2 class="text-2xl md:text-3xl font-medium text-white leading-snug">
                            Ada pertanyaan atau ingin <br class="hidden md:block">
                            bekerja sama dengan kami?
                        </h2>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#d4e9d4] text-[#063b2a] rounded-full text-sm font-semibold hover:bg-white transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            Hubungi Kami
                        </a>
                        <a href="{{ route('tutorial') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-white/30 text-white rounded-full text-sm font-medium hover:bg-white/10 transition-colors duration-200">
                            Lihat Tutorial
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="fixed bottom-0 left-0 w-full h-20 bg-white border-t border-gray-200 flex items-center z-[50]">
            <div class="animate-marquee">
                @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-12 px-6">
                    <span class="text-2xl font-light text-emerald-900 uppercase tracking-tighter whitespace-nowrap">
                        Green Infrastructure Design
                    </span>
                    <div class="w-8 h-8 bg-emerald-900 rounded-lg rotate-12 flex-shrink-0"></div>
                    <span class="text-2xl font-light text-emerald-900 uppercase tracking-tighter whitespace-nowrap">
                        environmental impact assessment
                    </span>
                    <div class="w-8 h-8 bg-emerald-900 rounded-full flex-shrink-0"></div>
                </div>
                @endfor
            </div>
        </footer>
    </div>
</x-app-layout>