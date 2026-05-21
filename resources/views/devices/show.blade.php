<x-app-layout>
    <div class="relative min-h-screen bg-white overflow-hidden">
        <main class="h-full w-full max-w-7xl mx-auto px-6 py-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <a href="{{ route('devices.index') }}" class="text-sm text-gray-400 hover:text-black transition-colors">
                        ← Back to Devices
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $device->device_name }}
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 min-h-[70vh] items-stretch">
                
                <div class="col-span-12 md:col-span-7 lg:col-span-6 h-full">
                    <div class="bg-gray-100 h-full rounded-[3.5rem] p-10 flex flex-col justify-between shadow-inner relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <span class="px-4 py-1.5 bg-white/50 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider text-gray-500">Real-time Climate</span>
                            <div class="flex items-center gap-3">
                                <div class="text-right">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse" id="liveIndicator"></div>
                                        <span class="text-xs font-medium text-gray-400" id="statusText">LIVE</span>
                                    </div>
                                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full" id="onlineStatus">Online</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 relative z-10">
                            <p class="text-sm text-gray-400 font-medium">Current Temperature</p>
                            <h1 class="text-8xl font-black text-emerald-500 tracking-tighter" id="tempDisplay">
                                {{ $latest->temperature ?? '--' }}<span class="text-4xl">°C</span>
                            </h1>
                        </div>

                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            <div class="bg-white/40 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Humidity</p>
                                <p class="text-2xl font-bold text-sky-500" id="humidityDisplay">{{ $latest->humidity ?? '--' }}%</p>
                            </div>
                            <div class="bg-white/40 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Soil Moisture</p>
                                <p class="text-2xl font-bold text-amber-500" id="soilDisplay">{{ $latest->soil ? round(($latest->soil / 1023) * 100) : '--' }}%</p>
                            </div>
                        </div>
                        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-emerald-100 rounded-full blur-3xl opacity-50"></div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-5 lg:col-span-6 flex flex-col gap-6 h-full">
                    
                    <div class="flex-[1.5] bg-gray-100 border-[3px] border-emerald-400/30 rounded-[3rem] p-8 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Weekly Analytics</span>
                            <div class="relative inline-block text-left" id="dropdownContainer">
                                <button type="button" onclick="toggleDropdown()"
                                        class="flex items-center gap-2 bg-emerald-50 text-emerald-700 text-xs font-bold py-2 px-3 rounded-xl border border-emerald-100 hover:bg-emerald-100 transition-all focus:outline-none">
                                    <span id="selectedLabel">Temperature</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-200" id="dropdownArrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 origin-top-right bg-white border border-emerald-50 rounded-2xl shadow-xl z-50 overflow-hidden py-1">
                                    <button onclick="selectOption('temp', 'Temperature')" class="flex items-center w-full px-4 py-2 text-xs font-medium text-gray-700 hover:bg-emerald-50">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 me-2"></span> Temperature
                                    </button>
                                    <button onclick="selectOption('hum', 'Humidity')" class="flex items-center w-full px-4 py-2 text-xs font-medium text-gray-700 hover:bg-emerald-50">
                                        <span class="w-2 h-2 rounded-full bg-blue-400 me-2"></span> Humidity
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative flex-grow" style="min-height: 200px;">
                            <canvas id="weeklyChart"></canvas>
                        </div>
                    </div>

                    <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase mb-2 tracking-widest">Indikator Suhu</span>
                            <span id="tempIndicator" class="text-xl font-medium transition-colors">
                                @if ($latest)
                                    @if ($latest->getTemperatureStatus() === 'Panas')
                                        <span class="text-red-500 font-bold">Panas</span>
                                    @else
                                        <span class="text-green-500 font-bold">Normal</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No Data</span>
                                @endif
                            </span>
                        </div>

                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-sky-400 uppercase mb-2 tracking-widest">Status Kipas</span>
                            <span id="fanIndicator" class="text-xl font-medium transition-colors">
                                @if ($latest)
                                    @if ($latest->fan_status)
                                        <span class="text-sky-500 font-bold">Aktif</span>
                                    @else
                                        <span class="text-gray-600 font-bold">Mati</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No Data</span>
                                @endif
                            </span>
                        </div>

                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-amber-400 uppercase mb-2 tracking-widest">Status Penyiram</span>
                            <span id="pumpIndicator" class="text-xl font-medium transition-colors">
                                @if ($latest)
                                    @if ($latest->pump_status)
                                        <span class="text-amber-500 font-bold">Aktif</span>
                                    @else
                                        <span class="text-gray-600 font-bold">Mati</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No Data</span>
                                @endif
                            </span>
                        </div>

                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Last Sync</span>
                            <span class="text-xl font-medium text-gray-700" id="updatedDisplay">
                                {{ $latest ? $latest->created_at->diffForHumans() : 'No Data' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8 mt-8">
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h4 class="text-lg font-semibold text-gray-800">
                            Sensor Data
                        </h4>
                        <a href="{{ route('devices.export-pdf', $device->id) }}@if($startDate || $endDate || $minTemp || $maxTemp)?start_date={{$startDate}}&end_date={{$endDate}}&min_temp={{$minTemp}}&max_temp={{$maxTemp}}@endif"
                           class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l-4-2m4 2l4-2" />
                            </svg>
                            Export to PDF
                        </a>
                    </div>

                    {{-- Filter Form --}}
                    <div class="p-6 rounded-2xl bg-white border border-gray-200 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h5 class="text-sm font-bold text-gray-900">Filter Data Sensor</h5>
                                <p class="text-xs text-gray-500 mt-1">Sesuaikan filter untuk melihat data yang spesifik</p>
                            </div>
                        </div>

                        <form method="GET" class="space-y-5">
                            {{-- Filter Type Selection --}}
                            <div class="pb-5 border-b border-gray-200">
                                <p class="text-xs font-semibold text-gray-700 mb-3 uppercase tracking-wide">Pilih Jenis Filter</p>
                                <div class="relative">
                                    <select 
                                        name="filter_type" 
                                        class="w-full p-3 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer transition-colors appearance-none"
                                        onchange="setFilterType(this.value)"
                                    >
                                        <option value="all" @if(!($tempCondition || $specificTemp) || request('filter_type') === 'all') selected @endif>
                                            Semua Filter
                                        </option>
                                        
                                        <option value="temperature" @if(request('filter_type') === 'temperature') selected @endif>
                                            Filter Suhu
                                        </option>
                                        
                                        <option value="soil" @if(request('filter_type') === 'soil') selected @endif>
                                            Filter Kelembaban Tanah
                                        </option>
                                        
                                        <option value="date" @if(request('filter_type') === 'date') selected @endif>
                                            Filter Tanggal
                                        </option>
                                    </select>
                                    
                                    <!-- Ikon panah kecil di sebelah kanan dropdown -->
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Date Range --}}
                            <div id="dateSection" class="space-y-3">
                                <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Rentang Tanggal</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Dari Tanggal</label>
                                        <input type="date" name="start_date" value="{{ $startDate }}"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white text-gray-900 text-sm transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Sampai Tanggal</label>
                                        <input type="date" name="end_date" value="{{ $endDate }}"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white text-gray-900 text-sm transition-all">
                                    </div>
                                </div>
                            </div>

                            {{-- Temperature Filter --}}
                            <div id="temperatureSection" class="space-y-3">
                                <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Filter Suhu</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Suhu Minimal (°C)</label>
                                        <input type="number" name="min_temp" step="0.1" value="{{ $minTemp }}" placeholder="contoh: 20"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white text-gray-900 text-sm transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Suhu Maksimal (°C)</label>
                                        <input type="number" name="max_temp" step="0.1" value="{{ $maxTemp }}" placeholder="contoh: 35"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white text-gray-900 text-sm transition-all">
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <p class="text-xs font-medium text-gray-600 mb-2">Kondisi Suhu</p>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" name="temp_condition" value="" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if(!$tempCondition) checked @endif>
                                            <span class="text-sm text-gray-700">Semua Kondisi</span>
                                        </label>
                                        <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" name="temp_condition" value="panas" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if($tempCondition === 'panas') checked @endif>
                                            <span class="text-sm text-gray-700">Panas (di atas {{ $device->fan_threshold ?? 30 }}°C)</span>
                                        </label>
                                        <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" name="temp_condition" value="dingin" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if($tempCondition === 'dingin') checked @endif>
                                            <span class="text-sm text-gray-700">Dingin (di bawah {{ $device->fan_threshold ?? 30 }}°C)</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <label class="block text-xs font-medium text-gray-600 mb-2">Suhu Spesifik (±2°C)</label>
                                    <input type="number" name="specific_temp" step="0.1" value="{{ $specificTemp }}" placeholder="contoh: 28"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white text-gray-900 text-sm transition-all">
                                    <p class="text-xs text-gray-500 mt-1">Cari data dengan rentang ±2 derajat dari nilai yang Anda masukkan</p>
                                </div>
                            </div>

                            {{-- Soil Moisture Filter --}}
                            <div id="soilSection" class="space-y-3">
                                <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Filter Kelembaban Tanah</p>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="soil_condition" value="" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if(request('soil_condition') !== 'dry' && request('soil_condition') !== 'wet') checked @endif>
                                        <span class="text-sm text-gray-700">Semua Kondisi</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="soil_condition" value="dry" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if(request('soil_condition') === 'dry') checked @endif>
                                        <span class="text-sm text-gray-700">Kering (di bawah {{ $device->soil_dry_threshold ?? 70 }}%)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="soil_condition" value="wet" class="w-4 h-4 text-emerald-500 border-gray-300 focus:ring-emerald-500 focus:ring-offset-0" @if(request('soil_condition') === 'wet') checked @endif>
                                        <span class="text-sm text-gray-700">Basah (di atas {{ $device->soil_wet_threshold ?? 40 }}%)</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-3 pt-4 border-t border-gray-200">
                                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-all text-sm">
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('devices.show', $device->id) }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2.5 px-4 rounded-lg transition-all text-sm text-center">
                                    Reset Filter
                                </a>
                            </div>
                        </form>
                    </div>
                                
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="p-4 rounded-2xl border border-emerald-500">
                            <p class="text-sm text-emerald-500 font-medium mb-1">
                                Rata-rata Minggu Ini
                            </p>
                            <p class="text-2xl font-bold text-emerald-500">
                                {{ number_format($device->getWeeklyAverageTemperature() ?? 0, 1) }}°C
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl border border-emerald-500">
                            <p class="text-sm text-emerald-500 font-medium mb-1">
                                Rata-rata Hari Ini
                            </p>
                            <p class="text-2xl font-bold text-emerald-500">
                                {{ number_format($device->getDailyAverageTemperature() ?? 0, 1) }}°C
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl border border-emerald-500">
                            <p class="text-sm text-emerald-500 font-medium mb-1">
                                Threshold Panas
                            </p>
                            <p class="text-2xl font-bold text-emerald-500">
                                {{ $device->fan_threshold ?? 30 }}°C
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 border border-gray-200">
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Tanggal
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Suhu
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Kelembaban
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Tanah
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Data Points
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($weeklyData as $data)
                                @php
                                    $threshold = $device->fan_threshold ?? 30;
                                    $status = $data->avg_temperature > $threshold ? 'Panas' : 'Normal';
                                    $statusColor = $data->avg_temperature > $threshold ? 'red' : 'green';
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_temperature ?? 0, 1) }}°C
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($status === 'Panas')
                                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Panas
                                            </span>
                                        @else
                                            <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_humidity ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_soil ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $data->count }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500 italic">
                                        Tidak ada data sensor tersedia
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Daily Data Section --}}
                @if ($device->getDailyTemperatureByHour()->count() > 0)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h5 class="text-md font-semibold text-gray-800 mb-4">
                        Data Per Jam Hari Ini
                    </h5>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 border border-gray-200">
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Jam
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Suhu
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Kelembaban
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Rata-rata Tanah
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">
                                        Data Points
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($device->getDailyTemperatureByHour() as $data)
                                @php
                                    $threshold = $device->fan_threshold ?? 30;
                                    $status = $data->avg_temperature > $threshold ? 'Panas' : 'Normal';
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ str_pad($data->hour, 2, '0', STR_PAD_LEFT) }}:00
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_temperature ?? 0, 1) }}°C
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($status === 'Panas')
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Panas
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_humidity ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ number_format($data->avg_soil ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $data->count }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const deviceId = {{ $device->id }};
    let myChart;
    let currentMode = 'temp'; // Mode default chart

    // 1. Inisialisasi Chart saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels ?? []),
                datasets: [{
                    label: 'Value',
                    data: @json($tempData ?? []),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });
        
        // Jalankan update pertama kali
        updateSensorData();
    });

    // 2. Fungsi Update Sensor & Status (Real-time)
    function updateSensorData() {
        fetch(`/devices/${deviceId}/latest-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const latest = data.data;
                const fanThreshold = data.fan_threshold || 30;

                // Update Display Angka
                document.getElementById('tempDisplay').innerHTML = `${latest.temperature ?? '--'}<span class="text-4xl">°C</span>`;
                document.getElementById('humidityDisplay').textContent = (latest.humidity ?? '--') + '%';
                const soilPercent = latest.soil ? Math.round((latest.soil / 1023) * 100) : '--';
                document.getElementById('soilDisplay').textContent = soilPercent + '%';
                
                // Update Temperature Indicator - Dynamic berdasarkan threshold
                const tempIndicator = document.getElementById('tempIndicator');
                const temperature = parseFloat(latest.temperature);
                if (temperature > fanThreshold) {
                    tempIndicator.innerHTML = '<span class="text-red-500">Panas</span>';
                } else {
                    tempIndicator.innerHTML = '<span class="text-green-500">✓ Normal</span>';
                }

                // Update Online/Offline Status
                const isOnline = data.is_online;
                const onlineStatus = document.getElementById('onlineStatus');
                const liveIndicator = document.getElementById('liveIndicator');
                const statusText = document.getElementById('statusText');
                
                if (isOnline) {
                    onlineStatus.textContent = 'Online';
                    onlineStatus.className = 'text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full';
                    liveIndicator.className = 'w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse';
                    statusText.textContent = 'LIVE';
                    statusText.className = 'text-xs font-medium text-gray-400';
                } else {
                    onlineStatus.textContent = 'Offline';
                    onlineStatus.className = 'text-[10px] font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full';
                    liveIndicator.className = 'w-2.5 h-2.5 bg-red-500 rounded-full';
                    statusText.textContent = 'OFFLINE';
                    statusText.className = 'text-xs font-medium text-red-500';
                }

                // Update Fan Indicator
                const fanIndicator = document.getElementById('fanIndicator');
                if (latest.fan_status) {
                    fanIndicator.innerHTML = '<span class="text-sky-500 font-bold">Aktif</span>';
                } else {
                    fanIndicator.innerHTML = '<span class="text-gray-600 font-bold">Mati</span>';
                }

                // Update Pump Indicator
                const pumpIndicator = document.getElementById('pumpIndicator');
                if (latest.pump_status) {
                    pumpIndicator.innerHTML = '<span class="text-amber-500 font-bold">Aktif</span>';
                } else {
                    pumpIndicator.innerHTML = '<span class="text-gray-600 font-bold">Mati</span>';
                }

                // Update "Last Sync" text
                const lastSyncDate = new Date(latest.created_at);
                const now = new Date();
                const diffSecs = Math.floor((now - lastSyncDate) / 1000);
                document.getElementById('updatedDisplay').textContent = diffSecs < 60 ? `${diffSecs}s ago` : `${Math.floor(diffSecs/60)}m ago`;

                // Animasi Indikator hanya jika online
                if (isOnline) {
                    const indicator = document.getElementById('liveIndicator');
                    indicator.classList.add('animate-pulse');
                }
            }
        })
        .catch(err => console.error("Error fetching data:", err));
    }

    // 3. Dropdown Logika
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
        document.getElementById('dropdownArrow').classList.toggle('rotate-180');
    }

    function selectOption(mode, label) {
        currentMode = mode;
        document.getElementById('selectedLabel').innerText = label;
        toggleDropdown();
        
        // Logika ganti warna & data chart
        if (mode === 'temp') {
            myChart.data.datasets[0].data = @json($tempData ?? []);
            myChart.data.datasets[0].borderColor = '#10b981';
        } else {
            myChart.data.datasets[0].data = @json($humData ?? []);
            myChart.data.datasets[0].borderColor = '#38bdf8';
        }
        myChart.update();
    }

    // 4. Filter Type Toggle Function
    function setFilterType(type) {
        const dateSection = document.getElementById('dateSection');
        const temperatureSection = document.getElementById('temperatureSection');
        const soilSection = document.getElementById('soilSection');

        // Hide all sections
        dateSection.style.display = 'none';
        temperatureSection.style.display = 'none';
        soilSection.style.display = 'none';

        // Show selected sections
        if (type === 'all') {
            dateSection.style.display = 'block';
            temperatureSection.style.display = 'block';
            soilSection.style.display = 'block';
        } else if (type === 'date') {
            dateSection.style.display = 'block';
        } else if (type === 'temperature') {
            temperatureSection.style.display = 'block';
        } else if (type === 'soil') {
            soilSection.style.display = 'block';
        }
    }

    // Initialize filter display on page load
    document.addEventListener('DOMContentLoaded', function() {
        const filterType = document.querySelector('input[name="filter_type"]:checked');
        if (filterType) {
            setFilterType(filterType.value);
        }
    });

    // Interval Update tiap 5 detik
    setInterval(updateSensorData, 5000);
    </script>
</x-app-layout>