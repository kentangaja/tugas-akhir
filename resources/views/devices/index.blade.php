<x-app-layout>
    <div class="min-h-screen text-gray-900 pb-20">
        <main class="max-w-7xl mx-auto px-6 pt-12">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-medium tracking-tight">
                        Connected <span class="italic font-normal text-emerald-700">Greenhouses</span>
                    </h1>
                    <p class="text-gray-500 mt-2">Manage and monitor your automated urban spaces.</p>
                </div>
                
                @auth
                    <a href="{{ route('devices.create') }}"
                       class="bg-[#063b2a] text-white px-8 py-3 rounded-full text-sm font-medium hover:bg-[#052a1d] transition-all shadow-lg hover:scale-105">
                       + Add New Station
                    </a>
                @endauth
            </div>

            <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-[#d4e9d4] p-6 rounded-[2.5rem] flex items-center justify-between">
                    <span class="font-medium text-emerald-900">Total Systems</span>
                    <span class="text-3xl font-bold text-emerald-900">{{ $devices->count() }}</span>
                </div>
            </div> -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($devices as $device)
                    <div class="bg-[#f8faf8] p-8 rounded-[3rem] shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-[#d4e9d4] opacity-20 rounded-bl-[4rem] -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                        
                        <div class="relative">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-2xl">
                                    🌿
                                </div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] uppercase font-bold px-3 py-1 rounded-full">Active</span>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $device->device_name }}</h3>
                            <p class="text-sm text-gray-400 mb-6 flex items-center gap-2">
                                ID: <span class="font-mono">{{ substr($device->api_key, 0, 8) }}...</span>
                            </p>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('devices.code', $device->id) }}"
                                class="bg-white border border-[#d4e9d4] text-black px-5 py-2.5 rounded-2xl text-sm font-semibold transition-all shadow-sm">
                                    View Code
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke-width="1.5" 
                                        stroke="currentColor" 
                                        class="w-5 h-5 inline-block text-black group-hover/btn:text-black ms-1 transition-colors">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </a>
                                <a href="{{ route('devices.show', $device->id) }}"
                                class="group/btn flex-1 flex items-center justify-center bg-[#063b2a] text-white py-3 px-6 rounded-2xl font-medium text-sm hover:text-black hover:bg-[#f8faf8] hover:border hover:border-[#063b2a] transition-all">
                                    View Dashboard 
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke-width="1.5" 
                                        stroke="currentColor" 
                                        class="w-5 h-5 inline-block text-white group-hover/btn:text-black ms-1 transition-colors">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </a>

                                <button onclick="copyToClipboard('{{ $device->api_key }}', this)" 
                                        class="p-3 bg-gray-100 rounded-2xl hover:bg-gray-200 transition-colors shrink-0"
                                        title="Copy API Key">
                                    📋
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 italic">No devices found. Start your green journey today.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</x-app-layout>