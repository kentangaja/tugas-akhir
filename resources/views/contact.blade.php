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
        .input-field {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border-radius: 1rem;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            color: #111827;
            font-size: 0.875rem;
            transition: all 0.2s;
            outline: none;
        }
        .input-field::placeholder { color: #9ca3af; }
        .input-field:focus {
            border-color: #063b2a;
            box-shadow: 0 0 0 3px rgba(6,59,42,0.08);
        }
    </style>

    <div class="relative min-h-[100dvh] overflow-y-auto overflow-x-hidden pb-24">
        <main class="max-w-7xl mx-auto px-6 pt-8 pb-10">

            {{-- HEADER --}}
            <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold mb-2">Kontak</p>
                    <h1 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight leading-tight">
                        Get in Touch <br>
                        <span class="bg-[#d4e9d4] px-4 py-1 rounded-full italic font-normal text-3xl md:text-4xl">with Us</span>
                    </h1>
                </div>
                <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                    Kami siap membantu kamu. Isi form di bawah dan kami akan segera menghubungi kamu kembali.
                </p>
            </div>

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                {{-- LEFT: Info Cards --}}
                <div class="lg:col-span-2 flex flex-col gap-4">

                    {{-- Card Info Kontak --}}
                    <div class="bg-[#063b2a] rounded-[2rem] p-7 text-white flex flex-col gap-6">
                        <div>
                            <p class="text-[#d4e9d4] text-xs uppercase tracking-widest font-semibold mb-3">Info Kontak</p>
                            <p class="text-white/80 text-sm leading-relaxed">Jangan ragu untuk menghubungi kami kapan saja. Tim kami siap membantu!</p>
                        </div>

                        <div class="flex flex-col gap-4">
                            {{-- Email --}}
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-[#d4e9d4]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/50 text-xs">Email</p>
                                    <p class="text-white text-sm font-medium">hello@vertemaison.id</p>
                                </div>
                            </div>
                            {{-- Phone --}}
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-[#d4e9d4]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/50 text-xs">Telepon</p>
                                    <p class="text-white text-sm font-medium">+62 812 3456 7890</p>
                                </div>
                            </div>
                            {{-- Location --}}
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-[#d4e9d4]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/50 text-xs">Lokasi</p>
                                    <p class="text-white text-sm font-medium">Malang, Jawa Timur</p>
                                </div>
                            </div>
                        </div>

                        {{-- Social Media --}}
                        <div>
                            <p class="text-white/50 text-xs mb-3">Ikuti Kami</p>
                            <div class="flex gap-2">
                                <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#d4e9d4]/20 flex items-center justify-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-9 h-9 rounded-full bg-white/10 hover:bg-[#d4e9d4]/20 flex items-center justify-center transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Card Response Time --}}
                    <div class="bg-[#d4e9d4] rounded-[2rem] p-6 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#063b2a] flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#d4e9d4]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-900 text-sm">Respon Cepat</p>
                            <p class="text-emerald-800/70 text-xs mt-0.5">Kami biasanya membalas dalam <span class="font-bold">24 jam</span> kerja.</p>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Form --}}
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 h-full">
                        <p class="text-xs uppercase tracking-widest text-emerald-600 font-semibold mb-1">Form</p>
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Kirim Pesan</h2>

                        @if ($errors->any())
                            <div class="mb-4 p-4 rounded-2xl bg-red-50 border border-red-200">
                                <p class="text-red-800 font-medium text-sm mb-2">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside text-red-700 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div id="successNotification" class="fixed top-6 right-6 max-w-md z-[9999]" style="animation: slideIn 0.3s ease-out forwards;">
                                <div class="bg-green-50 border border-green-200 rounded-2xl p-5 shadow-lg">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-green-800 font-semibold text-sm">Pesan Terkirim!</p>
                                            <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                                        </div>
                                        <button onclick="closeNotification()" class="flex-shrink-0 text-green-400 hover:text-green-600 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <style>
                                @keyframes slideIn {
                                    from {
                                        opacity: 0;
                                        transform: translateY(-20px) translateX(20px);
                                    }
                                    to {
                                        opacity: 1;
                                        transform: translateY(0) translateX(0);
                                    }
                                }
                                @keyframes slideOut {
                                    from {
                                        opacity: 1;
                                        transform: translateY(0) translateX(0);
                                    }
                                    to {
                                        opacity: 0;
                                        transform: translateY(-20px) translateX(20px);
                                    }
                                }
                            </style>

                            <script>
                                function closeNotification() {
                                    const notification = document.getElementById('successNotification');
                                    if (notification) {
                                        notification.style.animation = 'slideOut 0.3s ease-out forwards';
                                        setTimeout(() => {
                                            notification.remove();
                                        }, 300);
                                    }
                                }

                                // Auto-hide after 5 seconds
                                setTimeout(() => {
                                    closeNotification();
                                }, 5000);
                            </script>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Nama</label>
                                    <input type="text" id="name" name="name" required placeholder="Nama kamu" class="input-field">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Email</label>
                                    <input type="email" id="email" name="email" required placeholder="email@kamu.com" class="input-field">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="phone" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" placeholder="+62 8xx xxxx xxxx" class="input-field">
                            </div>

                            <div class="mt-4">
                                <label for="subject" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Subjek</label>
                                <select id="subject" name="subject" class="input-field">
                                    <option value="disabled selected">Pilih subjek pesan</option>
                                    <option value="general">Pertanyaan Umum</option>
                                    <option value="technical">Bantuan Teknis</option>
                                    <option value="partnership">Kerja Sama</option>
                                    <option value="feedback">Saran & Masukan</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label for="message" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Pesan</label>
                                <textarea id="message" name="message" required placeholder="Tulis pesanmu di sini..." rows="5" class="input-field resize-none"></textarea>
                            </div>

                            <div class="mt-6 flex items-center justify-between">
                                <p class="text-xs text-gray-400">* Semua field wajib diisi kecuali telepon</p>
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-[#063b2a] text-white rounded-full text-sm font-medium hover:bg-[#052a1d] transition-colors duration-200">
                                    Kirim Pesan
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

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