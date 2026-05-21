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
        }

        .team-card:hover .card-overlay {
            opacity: 1;
        }
        .team-card:hover .card-photo {
            transform: scale(1.05);
        }
        .card-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .card-photo {
            transition: transform 0.4s ease;
        }
    </style>

    <div class="relative min-h-[100dvh] overflow-y-auto overflow-x-hidden pb-24">

        {{-- HERO --}}
        <main class="max-w-7xl mx-auto px-6 pt-8 pb-10">
            <div class="mb-6 flex justify-end">
                <h1 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight leading-tight">
                    Kenali orang-orang di balik <br>
                    <span class="bg-[#d4e9d4] px-4 py-1 rounded-full italic font-normal text-3xl md:text-4xl">Tim</span> Kami
                </h1>
            </div>

            <div class="grid grid-cols-12 gap-6 items-start">
                <div class="col-span-12 md:col-span-3">
                    <div 
                    class="block bg-emerald-900 p-6 rounded-[2.5rem] shadow-sm relative overflow-hidden h-40 hover:shadow-md transition-shadow duration-200 cursor-pointer flex flex-col justify-between bg-cover bg-center"
                    style="background-image: url('{{ asset('img/wallpaper.jpg') }}');">
                    
                        <div class="absolute inset-0 bg-emerald-950/40 z-0"></div>

                        <div class="flex -space-x-2 relative z-10">
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-emerald-900"></div>
                        </div>
                        
                        <div class="p-3 h-fit w-fit rounded-[1rem] bg-white/10 backdrop-blur-md relative z-10">
                            <p class="text-lg font-bold text-white">
                                Tim Kami 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block text-white ms-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-6">
                        <a href="{{ route('contact') }}" class="px-6 py-2 border border-gray-300 rounded-full text-xs font-medium bg-white hover:bg-gray-100 transition-colors duration-200">Hubungi Kami</a>
                        <a href="{{ route('home') }}" class="px-6 py-2 bg-[#063b2a] text-white rounded-full text-xs font-medium hover:bg-[#052a1d] transition-colors duration-200">Beranda</a>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-9">
                    <div class="bg-[#063b2a] w-full h-56 md:h-64 rounded-[3.5rem] relative overflow-hidden shadow-inner flex items-center px-10">
                        <div class="max-w-sm">
                            <p class="text-[#d4e9d4] text-xs uppercase tracking-widest font-semibold mb-3">Tim Verte-Maison</p>
                            <p class="text-white text-xl md:text-2xl font-medium leading-relaxed">
                                Bersama-sama kami membangun teknologi untuk masa depan pertanian Indonesia.
                            </p>
                        </div>
                        {{-- Decorative circles --}}
                        <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-white/5"></div>
                        <div class="absolute -right-4 -bottom-12 w-36 h-36 rounded-full bg-[#d4e9d4]/10"></div>
                    </div>
                </div>
            </div>
        </main>

        {{-- GRID TEAM --}}
        <section class="max-w-7xl mx-auto px-6 pb-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold mb-1">Anggota</p>
                    <h2 class="text-2xl md:text-3xl font-medium text-gray-900 tracking-tight">Semua Anggota Tim</h2>
                </div>
                <span class="text-sm text-gray-400 font-medium">8 Anggota</span>
            </div>

            @php
                $members = [
                    [
                        'name'      => 'Bintang Putra Sugiarta',
                        'role'      => 'Ketua Tim & Konseptor',
                        'desc'      => 'Visiener utama Verte-Maison yang mengoordinasi seluruh aspek proyek, mulai dari integrasi teknologi hingga manajemen tim.',
                        'bg'        => 'bg-emerald-100',
                        'photo'     => 'img/team/bintang-putra.jpg',
                        'instagram' => 'https://www.instagram.com/aanomastar_?igsh=MTExMW9jaHE4ajB5NA==',
                    ],
                    [
                        'name'      => 'Bintang Adi Alvaro',
                        'role'      => 'Web Developer & Konstruksi Maket',
                        'desc'      => 'Bertanggung jawab atas pengembangan platform web monitoring serta implementasi struktur fisik pada maket greenhouse.',
                        'bg'        => 'bg-[#d4e9d4]',
                        'photo'     => 'img/team/bintang-adi.jpg',
                        'instagram' => 'https://www.instagram.com/toru_isi?igsh=MTZmM2RwOTFjOGRxNg==',
                    ],
                    [
                        'name'      => 'Hardiansyah Aditya',
                        'role'      => 'UI/UX Designer & Konstruksi Maket',
                        'desc'      => 'Merancang antarmuka dashboard yang intuitif serta memastikan estetika visual pada detail maket prototipe.',
                        'bg'        => 'bg-lime-100',
                        'photo'     => 'img/team/hardiansyah.jpg',
                        'instagram' => 'https://www.instagram.com/hardiansyaaaditys?igsh=cGtzMjZuMTkxdGxz',
                    ],
                    [
                        'name'      => 'Ajeng Nielza Itsna Mufida',
                        'role'      => 'WordPress Developer & Konstruksi Maket',
                        'desc'      => 'Mengelola dokumentasi proyek berbasis web serta membantu perakitan sistem otomatisasi pada model maket.',
                        'bg'        => 'bg-emerald-50',
                        'photo'     => 'img/team/ajeng.jpg',
                        'instagram' => 'https://www.instagram.com/lowwbatryy19?igsh=MWl0ZTVpdDlwbG5zYQ==',
                    ],
                    [
                        'name'      => 'Akmal Wildan Pratama',
                        'role'      => 'Data Analyst & Konstruksi Maket',
                        'desc'      => 'Menganalisis data sensor untuk akurasi monitoring sekaligus memastikan fungsionalitas teknis pada maket.',
                        'bg'        => 'bg-green-100',
                        'photo'     => 'img/team/akmal.jpg',
                        'instagram' => 'https://www.instagram.com/wildannnp_?igsh=MWJ4cW92bmtwZG9heQ%3D%3D&utm_source=qr',
                    ],
                    [
                        'name'      => 'Arweyn Abbygail',
                        'role'      => 'Technical Writer & Konstruksi Maket',
                        'desc'      => 'Menyusun laporan teknis secara sistematis dan mengawasi kualitas pengerjaan maket agar sesuai spesifikasi.',
                        'bg'        => 'bg-teal-100',
                        'photo'     => 'img/team/arweyn.jpg',
                        'instagram' => 'https://www.instagram.com/__dontlookkiddos?igsh=cDdsbHBjaHV6ejV1',
                    ],
                    [
                        'name'      => 'Bilqys Thalita Efendy',
                        'role'      => 'WordPress Specialist & Konstruksi Maket',
                        'desc'      => 'Optimasi konten landing page proyek dan berkolaborasi dalam integrasi elemen visual pada maket.',
                        'bg'        => 'bg-emerald-100',
                        'photo'     => 'img/team/bilqys.jpg',
                        'instagram' => 'https://www.instagram.com/bilqis_thal?igsh=MXd0YWJkczljOGExcA==',
                    ],
                    [
                        'name'      => 'Ayda Sazmita',
                        'role'      => 'Marketing & Konstruksi Maket',
                        'desc'      => 'Mengomunikasikan nilai inovasi Verte-Maison ke audiens serta membantu presentasi visual melalui detail maket.',
                        'bg'        => 'bg-[#d4e9d4]',
                        'photo'     => 'img/team/ayda.jpg',
                        'instagram' => 'https://www.instagram.com/cncer_ay?igsh=djFyc2YzeHZ5Zndl',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($members as $member)
                <div class="team-card group relative rounded-[2rem] overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 {{ $member['bg'] }}">

                    {{-- Bagian Kontainer Foto (Diperbaiki agar tidak terpotong/nge-zoom) --}}
                    <div class="relative h-56 bg-white/40 flex items-center justify-center overflow-hidden">
                        
                        <div class="absolute inset-0 bg-cover bg-center blur-md opacity-25 scale-110" style="background-image: url('{{ asset($member['photo']) }}')"></div>

                        <img src="{{ asset($member['photo']) }}" 
                             class="card-photo relative z-10 h-full w-auto object-contain mx-auto transition-transform duration-400 group-hover:scale-105" 
                             alt="{{ $member['name'] }}">

                        {{-- Fallback jika file foto tidak ditemukan --}}
                        @if (!file_exists(public_path($member['photo'])))
                            <div class="absolute inset-0 z-20 flex items-center justify-center bg-white/40">
                                <div class="w-20 h-20 rounded-full bg-white/70 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-emerald-700">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                            </div>
                        @endif

                        {{-- Overlay social media saat hover --}}
                        <div class="card-overlay absolute inset-0 bg-[#063b2a]/80 flex items-center justify-center gap-4 z-30">
                            <a href="{{ $member['instagram'] }}" class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-[#d4e9d4] transition-colors duration-200" title="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#063b2a]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-5">
                        <p class="font-semibold text-gray-900 text-base">{{ $member['name'] }}</p>
                        <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wide mt-0.5 mb-2">{{ $member['role'] }}</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $member['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- FOOTER MARQUEE --}}
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