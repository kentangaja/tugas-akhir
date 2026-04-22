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
                            <div class="bg-white/40 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Humidity</p>
                                <p class="text-2xl font-bold text-sky-500" id="humidityDisplay">{{ $latest->humidity ?? '--' }}%</p>
                            </div>
                            <div class="bg-white/40 p-6 rounded-[2rem]">
                                <p class="text-xs text-gray-400 uppercase">Soil Moisture</p>
                                <p class="text-2xl font-bold text-amber-500" id="soilDisplay">{{ $latest->soil ?? '--' }}</p>
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

                    <div class="flex-1 grid grid-cols-2 gap-6">
                        <div class="bg-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center">
                            <span class="text-[10px] font-bold text-emerald-400 uppercase mb-2 tracking-widest">Status</span>
                            <span id="statusBadge" class="text-xl font-medium transition-colors">
                                Loading...
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

                // Update Display Angka
                document.getElementById('tempDisplay').innerHTML = `${latest.temperature ?? '--'}<span class="text-4xl">°C</span>`;
                document.getElementById('humidityDisplay').textContent = (latest.humidity ?? '--') + '%';
                document.getElementById('soilDisplay').textContent = latest.soil ?? '--';
                
                // Update Status Online/Offline (Cek selisih waktu 5 menit)
                const statusBadge = document.getElementById('statusBadge');
                const lastSyncDate = new Date(latest.created_at);
                const now = new Date();
                const diffMinutes = (now - lastSyncDate) / 1000 / 60;

                if (diffMinutes < 5) {
                    statusBadge.textContent = "System Active";
                    statusBadge.className = "text-xl font-medium text-emerald-500";
                } else {
                    statusBadge.textContent = "Offline";
                    statusBadge.className = "text-xl font-medium text-red-400";
                }

                // Update "Last Sync" text
                const diffSecs = Math.floor((now - lastSyncDate) / 1000);
                document.getElementById('updatedDisplay').textContent = diffSecs < 60 ? `${diffSecs}s ago` : `${Math.floor(diffSecs/60)}m ago`;

                // Animasi Indikator
                const indicator = document.getElementById('liveIndicator');
                indicator.classList.replace('bg-green-500', 'bg-white');
                setTimeout(() => indicator.classList.replace('bg-white', 'bg-green-500'), 500);
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

    // Interval Update tiap 5 detik
    setInterval(updateSensorData, 5000);
    </script>
</x-app-layout>