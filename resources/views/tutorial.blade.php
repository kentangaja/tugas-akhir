<x-app-layout>
    <div class="min-h-screen bg-white py-16 px-6">
        <div class="max-w-5xl mx-auto">
            
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-bold tracking-widest uppercase text-sm">Getting Started</span>
                <h1 class="text-5xl font-black text-gray-900 mt-4 tracking-tight">How it Works</h1>
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

            <div class="mt-20 bg-emerald-50 p-12 rounded-[4rem] text-center border border-emerald-100">
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