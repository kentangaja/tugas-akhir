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
                <h3 class="text-lg font-semibold mb-4">Latest Sensor Data</h3>

                @if($latest)
                    <div class="grid grid-cols-2 gap-4 text-sm">

                        <div>
                            <p class="text-slate-400">Temperature</p>
                            <p class="text-xl font-bold text-emerald-400">
                                {{ $latest->temperature ?? '-' }} °C
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-400">Humidity</p>
                            <p class="text-xl font-bold text-sky-400">
                                {{ $latest->humidity ?? '-' }} %
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-400">Soil</p>
                            <p class="text-xl font-bold text-amber-400">
                                {{ $latest->soil ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-slate-400">Updated</p>
                            <p class="text-xs">
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

        <!-- Action -->
        <div class="flex justify-end">
            <a href="{{ route('devices.code', $device->id) }}"
               class="bg-indigo-500 hover:bg-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold shadow">
                View ESP8266 Source Code
            </a>
        </div>

    </div>
</div>
@endsection
