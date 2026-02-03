@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-900 text-white p-6">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">
                Device: {{ $device->device_name }}
            </h2>

            <a href="{{ route('devices.index') }}"
               class="text-sm text-slate-400 hover:text-white">
                ← Back
            </a>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Threshold Card -->
            <div class="bg-slate-800 rounded-xl p-6 shadow">
                <h3 class="text-lg font-semibold mb-4">Threshold Settings</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Fan Threshold</span>
                        <span class="font-medium">
                            {{ $device->fan_threshold ?? '-' }} °C
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Soil Threshold</span>
                        <span class="font-medium">
                            {{ $device->soil_threshold ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Latest Sensor Card -->
            <div class="bg-slate-800 rounded-xl p-6 shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Latest Sensor Data</h3>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse" id="liveIndicator"></div>
                        <span class="text-xs text-slate-400">Live</span>
                    </div>
                </div>

                <div id="sensorData">
                    @if($latest)
                        <div class="grid grid-cols-2 gap-4 text-sm">

                            <div>
                                <p class="text-slate-400">Temperature</p>
                                <p class="text-xl font-bold text-emerald-400" id="tempDisplay">
                                    {{ $latest->temperature ?? '-' }} °C
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-400">Humidity</p>
                                <p class="text-xl font-bold text-sky-400" id="humidityDisplay">
                                    {{ $latest->humidity ?? '-' }} %
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-400">Soil</p>
                                <p class="text-xl font-bold text-amber-400" id="soilDisplay">
                                    {{ $latest->soil ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-400">Updated</p>
                                <p class="text-xs" id="updatedDisplay">
                                    {{ $latest->created_at->diffForHumans() }}
                                </p>
                            </div>

                        </div>
                    @else
                        <p class="text-slate-400 text-sm">
                            No data received yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('devices.code', $device->id) }}"
               class="bg-indigo-500 hover:bg-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold shadow">
                View ESP8266 Source Code
            </a>
        </div>

    </div>
</div>

<script>
// Auto-refresh data setiap 5 detik
const deviceId = {{ $device->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

function updateSensorData() {
    fetch(`/devices/${deviceId}/latest-data`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.data) {
            const latest = data.data;
            
            // Update temperature
            const tempEl = document.getElementById('tempDisplay');
            if (tempEl) tempEl.textContent = (latest.temperature ?? '-') + ' °C';
            
            // Update humidity
            const humidityEl = document.getElementById('humidityDisplay');
            if (humidityEl) humidityEl.textContent = (latest.humidity ?? '-') + ' %';
            
            // Update soil
            const soilEl = document.getElementById('soilDisplay');
            if (soilEl) soilEl.textContent = latest.soil ?? '-';
            
            // Update timestamp
            const now = new Date();
            const createdAt = new Date(latest.created_at);
            const diffMs = now - createdAt;
            const diffMins = Math.floor(diffMs / 60000);
            const diffSecs = Math.floor((diffMs % 60000) / 1000);
            
            let timeStr = '';
            if (diffMins > 0) {
                timeStr = `${diffMins}m ago`;
            } else {
                timeStr = `${diffSecs}s ago`;
            }
            
            const updatedEl = document.getElementById('updatedDisplay');
            if (updatedEl) updatedEl.textContent = timeStr;
            
            // Blink indicator
            const indicator = document.getElementById('liveIndicator');
            if (indicator) {
                indicator.style.opacity = '0.5';
                setTimeout(() => {
                    indicator.style.opacity = '1';
                }, 300);
            }
        }
    })
    .catch(error => {
        console.log('Error fetching sensor data:', error);
        // Still retry even if error
    });
}

// Polling setiap 5 detik (5000ms)
setInterval(updateSensorData, 5000);

// Update pertama kali langsung
updateSensorData();
</script>
@endsection
