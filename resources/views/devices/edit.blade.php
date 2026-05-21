<x-app-layout>
    <div class="min-h-screen bg-white pb-20">
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-12">
            
            <div class="mb-8 sm:mb-12">
                <a href="{{ route('devices.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm mb-4 inline-block">
                    ← Kembali ke Perangkat
                </a>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-2">
                    Edit <span class="text-emerald-700">Stasiun</span>
                </h1>
                <p class="text-gray-600 text-sm sm:text-base">Perbarui konfigurasi dan batas ambang batas stasiun pemantauan rumah kaca Anda.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6 lg:gap-8">
                
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                        <form method="POST" action="{{ route('devices.update', $device->id) }}" class="p-6 sm:p-8 space-y-8">
                            @csrf
                            @method('PATCH')

                            <div>
                                <h3 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Informasi Dasar</h3>
                                
                                <div>
                                    <label for="device_name" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Nama Stasiun
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="device_name"
                                        name="device_name" 
                                        required
                                        value="{{ old('device_name', $device->device_name) }}"
                                        placeholder="contoh: Rumah Kaca Utama, Pertanian Urban #1"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('device_name') border-red-500 @enderror"
                                    >
                                    @error('device_name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <h3 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Batas Ambang Sensor</h3>
                                
                                <div class="mb-6">
                                    <label for="fan_threshold" class="block text-sm font-semibold text-gray-800 mb-2">
                                        <span class="flex items-center gap-2">
                                            Batas Suhu Kipas (°C)
                                            <span class="text-gray-400 font-normal text-xs">Opsional</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            id="fan_threshold"
                                            step="0.1" 
                                            name="fan_threshold"
                                            value="{{ old('fan_threshold', $device->fan_threshold) }}"
                                            placeholder="contoh: 32.5"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('fan_threshold') border-red-500 @enderror"
                                        >
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Ketika suhu melebihi nilai ini, kipas pendingin akan menyala secara otomatis.</p>
                                    @error('fan_threshold')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="soil_dry_threshold" class="block text-sm font-semibold text-gray-800 mb-2">
                                            <span class="flex items-center gap-2">
                                                Batas Kering (%)
                                                <span class="text-gray-400 font-normal text-xs">Opsional</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                id="soil_dry_threshold"
                                                name="soil_dry_threshold"
                                                value="{{ old('soil_dry_threshold', $device->soil_dry_threshold ?? 70) }}"
                                                placeholder="contoh: 40"
                                                min="0"
                                                max="100"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('soil_dry_threshold') border-red-500 @enderror"
                                            >
                                            <span class="absolute right-4 top-3.5 text-gray-400 font-semibold">%</span>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500"><strong>Pompa menyala</strong> ketika kelembapan tanah turun di bawah tingkat ini.</p>
                                        @error('soil_dry_threshold')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="soil_wet_threshold" class="block text-sm font-semibold text-gray-800 mb-2">
                                            <span class="flex items-center gap-2">
                                                Batas Basah (%)
                                                <span class="text-gray-400 font-normal text-xs">Opsional</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                id="soil_wet_threshold"
                                                name="soil_wet_threshold"
                                                value="{{ old('soil_wet_threshold', $device->soil_wet_threshold ?? 40) }}"
                                                placeholder="contoh: 70"
                                                min="0"
                                                max="100"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('soil_wet_threshold') border-red-500 @enderror"
                                            >
                                            <span class="absolute right-4 top-3.5 text-gray-400 font-semibold">%</span>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500"><strong>Pompa mati</strong> ketika kelembapan tanah telah mencapai tingkat ini.</p>
                                        @error('soil_wet_threshold')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <p class="text-xs sm:text-sm text-gray-700">
                                        <strong>Cara kerja:</strong> Pompa menggunakan sistem dua tingkat:
                                        <br>• Jika kelembapan <strong>turun di bawah</strong> Batas Kering → Pompa <strong>MENYALA</strong>
                                        <br>• Jika kelembapan <strong>naik melebihi</strong> Batas Basah → Pompa <strong>MATI</strong>
                                        <br>• Di antara kedua nilai tersebut → Pompa mempertahankan status saat ini (mencegah mesin mati-nyala terlalu cepat)
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 w-full">
                                <button 
                                    type="submit"
                                    class="flex-1 min-w-[140px] bg-[#059669] hover:bg-[#047857] text-white py-3 px-6 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg active:scale-95 text-sm sm:text-base cursor-pointer"
                                >
                                    Perbarui Stasiun
                                </button>
                                <a 
                                    href="{{ route('devices.index') }}"
                                    class="flex-1 min-w-[140px] bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#1f2937] py-3 px-6 rounded-lg font-semibold transition-all text-sm sm:text-base text-center"
                                >
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 sm:p-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">Informasi Perangkat</h3>
                        <div class="space-y-3 text-xs sm:text-sm text-gray-700">
                            <div>
                                <p class="text-gray-600 font-semibold mb-1">ID Stasiun</p>
                                <code class="block bg-white px-2 py-1.5 border border-gray-200 rounded font-mono text-xs break-all text-gray-800">{{ $device->id }}</code>
                            </div>
                            <div>
                                <p class="text-gray-600 font-semibold mb-1">Kunci API (API Key)</p>
                                <code class="block bg-white px-2 py-1.5 border border-gray-200 rounded font-mono text-xs break-all text-gray-800">{{ substr($device->api_key, 0, 20) }}...</code>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 sm:p-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">Nilai yang Disarankan</h3>
                        <div class="space-y-2 text-xs sm:text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>Suhu:</span>
                                <code class="bg-white px-2 py-1 border border-gray-200 rounded text-gray-800">28-35°C</code>
                            </div>
                            <div class="flex justify-between">
                                <span>Tingkat Basah:</span>
                                <code class="bg-white px-2 py-1 border border-gray-200 rounded text-gray-800">60-80%</code>
                            </div>
                            <div class="flex justify-between">
                                <span>Tingkat Kering:</span>
                                <code class="bg-white px-2 py-1 border border-gray-200 rounded text-gray-800">30-50%</code>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 sm:p-6">
                        <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-3">Terakhir Diperbarui</h3>
                        <p class="text-xs sm:text-sm text-gray-600">
                            {{ $device->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>