<x-app-layout>
    <div class="min-h-screen text-gray-900 pb-20">
        <main class="max-w-7xl mx-auto px-6 pt-12">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-medium tracking-tight">
                        Connected <span class="italic font-normal text-emerald-700">Greenhouses</span>
                    </h1>
                    <p class="text-gray-500 mt-2">Kelola dan pantau ruang greenhouse Anda..</p>
                </div>
                
                @auth
                    <a href="{{ route('devices.create') }}"
                       class="bg-[#063b2a] text-white px-8 py-3 rounded-full text-sm font-medium hover:bg-[#052a1d] transition-all shadow-lg hover:scale-105">
                       + Add New Station
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-1 gap-8">
                @forelse ($devices as $device)
                    <div class="bg-[#f8faf8] p-8 rounded-[3rem] shadow-sm border border-gray-100 hover:shadow-md transition-shadow @if(!$device->is_active) opacity-60 @endif">
                        {{-- Device Header Card --}}
                        <div class="relative overflow-hidden group mb-8">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-[#d4e9d4] opacity-20 rounded-bl-[4rem] -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                            
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-2xl">
                                                🌿
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-800">{{ $device->device_name }}</h3>
                                                <p class="text-sm text-gray-400 flex items-center gap-2">
                                                    ID: <span class="font-mono">{{ substr($device->api_key, 0, 8) }}...</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="@if($device->is_active) bg-emerald-100 text-emerald-700 @else bg-gray-100 text-gray-600 @endif text-[10px] uppercase font-bold px-3 py-1 rounded-full">
                                        {{ $device->getStatusIndicator() }}
                                    </span>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('devices.code', $device->id) }}"
                                    class="bg-white border border-[#d4e9d4] text-black px-5 py-2.5 rounded-2xl text-sm font-semibold transition-all shadow-sm hover:bg-gray-50">
                                        Code
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke-width="1.5" 
                                            stroke="currentColor" 
                                            class="w-4 h-4 inline-block text-black ms-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('devices.show', $device->id) }}"
                                    class="flex-1 flex items-center justify-center bg-[#063b2a] text-white py-2.5 px-4 rounded-2xl font-medium text-sm hover:bg-[#052a1d] transition-all">
                                        Dashboard 
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke-width="1.5" 
                                            stroke="currentColor" 
                                            class="w-4 h-4 inline-block text-white ms-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('devices.edit', $device->id) }}"
                                    class="bg-white border border-blue-200 text-blue-600 px-5 py-2.5 rounded-2xl text-sm font-semibold transition-all shadow-sm hover:bg-blue-50">
                                        Edit
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke-width="1.5" 
                                            stroke="currentColor" 
                                            class="w-4 h-4 inline-block text-blue-600 ms-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>

                                    {{-- Toggle Status Button --}}
                                    <form method="POST" action="{{ route('devices.toggle-status', $device->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" style="background-color: white !important; color: #374151 !important; display: inline-flex !important; opacity: 1 !important; visibility: visible !important; border: 1px solid #e5e7eb;" class="min-w-[110px] @if($device->is_active) bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 @else bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 @endif px-5 py-2.5 rounded-2xl text-sm font-semibold transition-all shadow-sm hover:shadow-md cursor-pointer">
                                            @if($device->is_active) 
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block me-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Nonaktifkan
                                            @else 
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block me-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                                Aktifkan
                                            @endif
                                        </button>
                                    </form>

                                    <button onclick="copyToClipboard('{{ $device->api_key }}', this)" 
                                            class="p-2.5 bg-gray-100 rounded-2xl hover:bg-gray-200 transition-colors"
                                            title="Copy API Key">
                                        📋
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 italic">No devices found. Start your green journey today.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($devices->count())
                <div class="mt-12 flex justify-center">
                    {{ $devices->links() }}
                </div>
            @endif
        </main>
    </div>

    <script>
        function copyToClipboard(text, element) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = element.textContent;
                element.textContent = '✓ Copied!';
                setTimeout(() => {
                    element.textContent = originalText;
                }, 2000);
            });
        }
    </script>
</x-app-layout>