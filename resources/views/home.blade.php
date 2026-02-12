<x-app-layout>
    <style>
        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: scroll 30s linear infinite;
        }
        html, body { 
            height: 100%; 
            overflow: hidden !important; 
        }
    </style>

    <div class="relative min-h-[100dvh] overflow-hidden">
        
        <main class="max-w-7xl mx-auto px-6 pt-8 pb-32">
            
            <div class="mb-6 flex justify-end">
                <h1 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight leading-tight">
                    Reimagining Urban Spaces <br>
                    <span class="bg-[#d4e9d4] px-4 py-1 rounded-full italic font-normal text-3xl md:text-4xl">Greening</span> the World
                </h1>
            </div>

            <div class="grid grid-cols-12 gap-6 items-start">
                <div class="col-span-12 md:col-span-3">
                    <div class="bg-[#d4e9d4] p-6 rounded-[2.5rem] shadow-sm relative overflow-hidden h-40">
                        <div class="flex -space-x-2 mb-4">
                            <div class="w-8 h-8 rounded-full bg-gray-400 border-2 border-[#d4e9d4]"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-500 border-2 border-[#d4e9d4]"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-500 border-2 border-[#d4e9d4]"></div>
                        </div>
                        <p class="text-lg font-bold text-emerald-900">Our Team 
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6" class="w-5 h-5 inline-block text-emerald-700 ms-1">
                            <path strokeLinecap="round" strokeLinejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </p>
                    </div>
                    <div class="flex gap-3 pt-12">
                        <button class="px-6 py-2 border border-gray-300 rounded-full text-xs font-medium bg-white hover:bg-gray-100 transition-colors duration-200">Explore</button>
                        <button class="px-6 py-2 bg-[#063b2a] text-white rounded-full text-xs font-medium hover:bg-[#052a1d] transition-colors duration-200">Work with Us</button>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-9 flex flex-col gap-4">
                    <div class="bg-gray-200 w-full h-56 md:h-64 rounded-[3.5rem] relative overflow-hidden shadow-inner">
                        
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 italic">
                            [ Gambar Utama ]
                        </div>

                        <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-6 rounded-[2.5rem] max-w-[280px] shadow-sm">
                            <p class="text-xs md:text-sm text-gray-800 leading-relaxed font-medium">
                                We believe that the future of cities lies in smart, eco-friendly solutions that address the pressing challenges of urbanization.
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>

        <footer class="fixed bottom-0 left-0 w-full h-20 bg-white border-t border-gray-200 flex items-center z-[50]">
            <div class="animate-marquee">
                @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-12 px-6">
                    <span class="text-2xl font-light text-gray-800 uppercase tracking-tighter whitespace-nowrap">
                        Green Infrastructure Design
                    </span>
                    <div class="w-8 h-8 bg-gray-300 rounded-lg rotate-12 flex-shrink-0"></div>
                    <span class="text-2xl font-light text-gray-800 uppercase tracking-tighter whitespace-nowrap">
                        Smart Irrigation Systems
                    </span>
                    <div class="w-8 h-8 bg-gray-400 rounded-full flex-shrink-0"></div>
                </div>
                @endfor
            </div>
        </footer>
    </div>
</x-app-layout>