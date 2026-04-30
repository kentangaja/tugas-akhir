<x-app-layout>
    <div class="min-h-screen text-gray-900 pb-20">
        <main class="max-w-7xl mx-auto px-6 pt-12">
            
            <div class="mb-12 mx-auto mx-5 flex justify-between gap-4">
                <div class="mb-8">
                    <a href="{{ route('devices.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm mb-4 inline-block">
                        ← Back to Devices
                    </a>
                    <h1 class="text-4xl md:text-5xl font-medium tracking-tight text-gray-900">
                        Edit <span class="italic font-normal text-emerald-700">Station</span>
                    </h1>
                    <p class="text-gray-500 mt-2">Update your greenhouse monitoring station configuration.</p>
                </div>
                <div class="max-w-2xl">
                    <div class="bg-[#f8faf8] p-8 rounded-[3rem] shadow-sm border border-gray-100">
                        <form method="POST" action="{{ route('devices.update', $device->id) }}" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Device Name -->
                            <div>
                                <label for="device_name" class="block text-sm font-semibold text-gray-800 mb-2">
                                    Station Name
                                    <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="device_name"
                                    name="device_name" 
                                    required
                                    value="{{ old('device_name', $device->device_name) }}"
                                    placeholder="e.g., Main Greenhouse, Urban Farm #1"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('device_name') border-red-500 @enderror"
                                >
                                @error('device_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fan Threshold -->
                            <div>
                                <label for="fan_threshold" class="block text-sm font-semibold text-gray-800 mb-2">
                                    Fan Temperature Threshold (°C)
                                    <span class="text-gray-400 font-normal text-xs">Optional</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="fan_threshold"
                                    step="0.1" 
                                    name="fan_threshold"
                                    value="{{ old('fan_threshold', $device->fan_threshold) }}"
                                    placeholder="e.g., 28.5"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('fan_threshold') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-gray-500">Temperature at which the cooling fan will activate.</p>
                                @error('fan_threshold')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Soil Humidity Threshold -->
                            <div>
                                <label for="soil_threshold" class="block text-sm font-semibold text-gray-800 mb-2">
                                    Soil Humidity Threshold (%)
                                    <span class="text-gray-400 font-normal text-xs">Optional</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="soil_threshold"
                                    name="soil_threshold"
                                    value="{{ old('soil_threshold', $device->soil_threshold) }}"
                                    placeholder="e.g., 40"
                                    min="0"
                                    max="100"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all @error('soil_threshold') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-gray-500">Minimum soil humidity percentage for irrigation trigger.</p>
                                @error('soil_threshold')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-4 pt-4">
                                <button 
                                    type="submit"
                                    class="flex-1 bg-[#063b2a] text-white py-3 px-6 rounded-2xl font-semibold hover:bg-[#052a1d] transition-all shadow-lg hover:scale-105 text-sm"
                                >
                                    Update Station
                                </button>
                                <a 
                                    href="{{ route('devices.index') }}"
                                    class="flex-1 bg-white border-2 border-gray-200 text-gray-800 py-3 px-6 rounded-2xl font-semibold hover:bg-gray-50 transition-all text-sm text-center"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
