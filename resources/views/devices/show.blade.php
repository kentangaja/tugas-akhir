<x-app-layout>
    <div class="relative min-h-screen bg-white overflow-hidden dark:bg-zinc-950">
        
        <main class="h-full w-full max-w-7xl mx-auto px-6 py-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <a href="{{ route('devices.index') }}" class="text-sm text-gray-400 hover:text-black transition-colors">
                        ← Back to Devices
                    </a>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $device->device_name }}
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('devices.code', $device->id) }}"
                       class="bg-[#063b2a] text-white hover:bg-emerald-900 px-5 py-2.5 rounded-2xl text-sm font-semibold transition-all shadow-sm">
                        View ESP8266 Code
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 min-h-[70vh] items-stretch">
                
                <div class="col-span-12 md:col-span-7 lg:col-span-6 h-full">
                    <div class="bg-gray-100 dark:bg-zinc-900 h-full rounded-[3.5rem] p-10 flex flex-col justify-between shadow-inner relative overflow-hidden">
                        <div class="flex justify-between items-start relative z-10">
                            <span class="px-4 py-1.5 bg-white/50 dark:bg-white/10 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider text-gray-500">Real-time Climate</span>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse" id="liveIndicator"></div>
                                <span class="text-xs font-medium text-gray-400">LIVE</span>
                            </div>
                        </div>

                        <div class="space-y-2 relative z-10">
                            <p class="text-sm text-gray-400 font-medium">Current Temperature</p>
                            <h1 class="text-8xl font-black text-emerald-500 tracking-tighter" id="tempDisplay">
                                {{ $latest->temperature ?? '--' }}<span class="text-4xl">°C</span>
                            </h1>
                        </div>

                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            <div class="bg-white/40 dark:bg-white/5 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Humidity</p>
                                <p class="text-2xl font-bold text-sky-500" id="humidityDisplay">{{ $latest->humidity ?? '--' }}%</p>
                            </div>
                            <div class="bg-white/40 dark:bg-white/5 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Soil Moisture</p>
                                <p class="text-2xl font-bold text-amber-500" id="soilDisplay">{{ $latest->soil ?? '--' }}</p>
                            </div>
                        </div>

                        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-emerald-100 dark:bg-emerald-900/20 rounded-full blur-3xl opacity-50"></div>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-5 lg:col-span-6 flex flex-col gap-6 h-full">
                    
                    <div class="flex-[1.5] bg-gray-100 dark:bg-zinc-900 border-[3px] border-emerald-400/30 rounded-[3rem] p-8 flex flex-col relative overflow-hidden">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Weekly Analytics</span>
                            <div class="relative inline-block text-left" id="dropdownContainer">
                                <button type="button" 
                                        onclick="toggleDropdown()"
                                        class="flex items-center gap-2 bg-emerald-50 text-emerald-700 text-xs font-bold py-2 px-3 rounded-xl border border-emerald-100 hover:bg-emerald-100 transition-all focus:outline-none">
                                    <span id="selectedLabel">Temperature</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-200" id="dropdownArrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="dropdownMenu" 
                                    class="hidden absolute right-0 mt-2 w-40 origin-top-right bg-white border border-emerald-50 rounded-2xl shadow-xl z-50 overflow-hidden py-1">
                                    
                                    <button onclick="selectOption('temp', 'Temperature')" 
                                            class="flex items-center w-full px-4 py-2 text-xs font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 me-2"></span>
                                        Temperature
                                    </button>

                                    <button onclick="selectOption('hum', 'Humidity')" 
                                            class="flex items-center w-full px-4 py-2 text-xs font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                        <span class="w-2 h-2 rounded-full bg-blue-400 me-2"></span>
                                        Humidity
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative flex-grow">
                            <canvas id="weeklyChart"></canvas>
                        </div>
                    </div>

                    <div class="flex-1 grid grid-cols-2 gap-6">
                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase mb-2 tracking-widest">Status</span>
                            @if($latest && $latest->created_at->diffInMinutes(now()) < 5)
                                <span class="text-xl font-medium text-white">System Active</span>
                            @else
                                <span class="text-xl font-medium text-red-400">Offline</span>
                            @endif
                        </div>

                        <div class="bg-gray-100 dark:bg-zinc-900 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase mb-2 tracking-widest">Last Sync</span>
                            <span class="text-xl font-medium text-gray-700 dark:text-gray-300" id="updatedDisplay">
                                {{ $latest ? $latest->created_at->diffForHumans() : 'No Data' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>

    <script>
    const deviceId = {{ $device->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    function updateSensorData() {
        fetch(`/devices/${deviceId}/latest-data`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const latest = data.data;

                const tempEl = document.getElementById('tempDisplay');
                if (tempEl) tempEl.innerHTML = `${latest.temperature ?? '--'}<span class="text-4xl">°C</span>`;

                const humidityEl = document.getElementById('humidityDisplay');
                if (humidityEl) humidityEl.textContent = (latest.humidity ?? '--') + '%';

                const soilEl = document.getElementById('soilDisplay');
                if (soilEl) soilEl.textContent = latest.soil ?? '--';
                
                const updatedEl = document.getElementById('updatedDisplay');
                if (updatedEl) {
                    const now = new Date();
                    const createdAt = new Date(latest.created_at);
                    const diffSecs = Math.floor((now - createdAt) / 1000);
                    updatedEl.textContent = diffSecs < 60 ? `${diffSecs}s ago` : `${Math.floor(diffSecs/60)}m ago`;
                }
                
                const indicator = document.getElementById('liveIndicator');
                if (indicator) {
                    indicator.classList.remove('bg-green-500');
                    indicator.classList.add('bg-white');
                    setTimeout(() => {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-green-500');
                    }, 500);
                }
            }
        })
        .catch(error => console.error('Fetch error:', error));
    }

    setInterval(updateSensorData, 5000);
        function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        const arrow = document.getElementById('dropdownArrow');
        
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function selectOption(value, label) {
        document.getElementById('selectedLabel').innerText = label;
        
        toggleDropdown();
        
        console.log("Filter diganti ke:", value);
    }

    window.onclick = function(event) {
        if (!event.target.closest('#dropdownContainer')) {
            const menu = document.getElementById('dropdownMenu');
            const arrow = document.getElementById('dropdownArrow');
            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    }
    </script>
</x-app-layout>