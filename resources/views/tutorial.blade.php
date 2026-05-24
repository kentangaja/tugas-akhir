<x-app-layout>
    <div class="min-h-screen bg-white py-16 px-6">
        <div class="max-w-5xl mx-auto">
            
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-bold tracking-widest uppercase text-sm">Mari Kita Mulai</span>
                <h1 class="text-5xl font-black text-gray-900 mt-4 tracking-tight">Tutorial</h1>
                <p class="text-gray-500 mt-4 text-lg max-w-2xl mx-auto">Ikuti langkah-langkah di bawah ini untuk menghubungkan perangkat kamu ke ekosistem <span class="text-emerald-600 font-semibold">Verte-Maison</span>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">
                
                <div class="bg-gray-50 p-10 rounded-[3rem] border-2 border-transparent hover:border-emerald-400/30 transition-all group">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">01</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Daftar & Masuk</h3>
                    <p class="text-gray-500 leading-relaxed">Buat akun Verte-Maison untuk mulai mengelola perangkat. Kamu akan mendapatkan dashboard pribadi untuk memantau sensor secara real-time.</p>
                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('register') }}" class="text-emerald-600 font-bold text-sm hover:underline">Register Now →</a>
                    </div>
                </div>

                <div class="bg-gray-50 p-10 rounded-[3rem] border-2 border-transparent hover:border-emerald-400/30 transition-all group">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">02</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Rakit Perangkat</h3>
                    <p class="text-gray-500 leading-relaxed">Hubungkan sensor DHT11 ke pin D4 dan sensor Soil Moisture ke pin A0 pada NodeMCU ESP8266 kamu.</p>
                </div>

                <div class="bg-gray-50 p-10 rounded-[3rem] border-2 border-transparent hover:border-emerald-400/30 transition-all group">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">03</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Upload Program</h3>
                    <p class="text-gray-500 leading-relaxed">Salin kode yang tersedia di halaman perangkat, masukkan API Key kamu, lalu upload menggunakan Arduino IDE.</p>
                </div>

                <div class="bg-gray-50 p-10 rounded-[3rem] border-2 border-transparent hover:border-emerald-400/30 transition-all group relative overflow-hidden">
                    <div class="w-14 h-14 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">04</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Pantau Tanaman</h3>
                    <p class="text-gray-500 leading-relaxed">Selamat! Perangkat kamu sekarang aktif. Kamu bisa memantau kesehatan tanaman dari mana saja secara otomatis.</p>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-emerald-500/20 rounded-full blur-2xl"></div>
                </div>

            </div>

            <div class="mt-16">
                <div class="bg-[#063b2a] rounded-[3rem] p-8 md:p-12">
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-[#d4e9d4]/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#d4e9d4]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[#d4e9d4] text-xs uppercase tracking-widest font-semibold">Wiring Diagram</p>
                            <h2 class="text-white text-2xl font-bold">Schema Alat</h2>
                        </div>
                    </div>

                    <div class="bg-white/10 rounded-[2rem] p-4 backdrop-blur-sm">
                        <img 
                            src="{{ asset('img/schema.png') }}" 
                            alt="Schema Alat" 
                            class="w-full h-auto rounded-[1.5rem] object-contain"
                            style="max-height: 500px;"
                        >
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <div class="flex items-center gap-2 bg-white/10 rounded-full px-4 py-2">
                            <div class="w-2 h-2 rounded-full bg-[#d4e9d4]"></div>
                            <span class="text-white/80 text-xs font-medium">DHT11 → Pin D4</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 rounded-full px-4 py-2">
                            <div class="w-2 h-2 rounded-full bg-[#d4e9d4]"></div>
                            <span class="text-white/80 text-xs font-medium">Soil Moisture → Pin A0</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/10 rounded-full px-4 py-2">
                            <div class="w-2 h-2 rounded-full bg-[#d4e9d4]"></div>
                            <span class="text-white/80 text-xs font-medium">NodeMCU ESP8266</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-12 bg-emerald-50 p-12 rounded-[4rem] text-center border border-emerald-100">
                <h2 class="text-2xl font-bold text-emerald-900">Butuh bantuan teknis?</h2>
                <p class="text-emerald-700/70 mt-2 mb-8 italic text-sm">"Semua perubahan besar dimulai dari satu baris kode yang berhasil di-upload."</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <div class="px-6 py-3 bg-white rounded-2xl shadow-sm flex items-center gap-3">
                        <span class="text-xs font-bold text-gray-400 uppercase">Library</span>
                        <span class="font-mono text-sm font-bold">ArduinoJson</span>
                    </div>
                    <div class="px-6 py-3 bg-white rounded-2xl shadow-sm flex items-center gap-3">
                        <span class="text-xs font-bold text-gray-400 uppercase">Baudrate</span>
                        <span class="font-mono text-sm font-bold">115200</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>