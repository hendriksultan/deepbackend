<x-layout>
{{-- 1. HERO SECTION (MENGIKUTI DNA HOMEPAGE) --}}
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-32 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
        
        {{-- Background Elements & Pattern --}}
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

        {{-- Konten Teks Galeri --}}
        <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10 flex flex-col items-center text-center">
            
            {{-- Badge (Mengikuti gaya beranda dengan titik kuning berkedip) --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md" data-aos="fade-down">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Dokumentasi</span>
            </div>
            
            {{-- Teks Judul (Dengan efek gradasi kuning di kata "Kegiatan") --}}
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6 text-white" data-aos="fade-up" data-aos-delay="100">
                Galeri <br class="md:hidden">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Kegiatan</span>
            </h1>
            
            {{-- Teks Deskripsi --}}
            <p class="text-lg text-green-100/90 mb-8 leading-relaxed font-light max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Merekam jejak langkah, semangat, dan kebersamaan para santri dalam menuntut ilmu di Deep Quran Academy.
            </p>

        </div>
    </section>

    {{-- KONTEN UTAMA GALERI --}}
    <section class="py-16 md:py-24 bg-white" x-data="{ imageOpen: false, activeImage: '', activeTitle: '' }">
        <div class="container max-w-7xl mx-auto px-4 md:px-6">
            
            @if($galeris->isEmpty())
                <div class="py-20 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Galeri Belum Tersedia</h3>
                    <p class="text-gray-500 mt-2">Mohon maaf, saat ini belum ada foto dokumentasi yang diunggah.</p>
                </div>
            @else
                {{-- Grid Layout --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($galeris as $foto)
                        <div class="group relative overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 bg-white"
                             @click="imageOpen = true; activeImage = '{{ asset('storage/' . $foto->image) }}'; activeTitle = '{{ $foto->title }}'"
                             data-aos="fade-up" 
                             data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                            
                            {{-- Container Gambar --}}
                            <div class="aspect-w-16 aspect-h-12 overflow-hidden bg-gray-200">
                                <img src="{{ asset('storage/' . $foto->image) }}" 
                                     alt="{{ $foto->title }}" 
                                     class="w-full h-64 md:h-80 object-cover transition-transform duration-700 group-hover:scale-110">
                            </div>

                            {{-- Overlay Content --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-6">
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h3 class="text-white font-bold text-lg leading-tight mb-1">{{ $foto->title }}</h3>
                                    <div class="flex items-center text-green-400 text-xs font-semibold uppercase tracking-wider">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Perbesar Gambar
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16 flex justify-center">
                    {{ $galeris->links() }}
                </div>
            @endif
        </div>

        {{-- LIGHTBOX MODAL (Full Screen Zoom) --}}
        <div x-show="imageOpen" 
             x-cloak 
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/95 backdrop-blur-md p-4 md:p-12"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            {{-- Close Button --}}
            <button @click="imageOpen = false" class="absolute top-6 right-6 md:top-10 md:right-10 text-white/60 hover:text-white transition-all duration-300 z-50">
                <svg class="w-10 h-10 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Image View --}}
            <div class="relative w-full max-w-5xl flex flex-col items-center" @click.away="imageOpen = false">
                <img :src="activeImage" :alt="activeTitle" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl border border-white/10">
                <div class="mt-6 text-center">
                    <h4 x-text="activeTitle" class="text-white text-lg md:text-2xl font-bold tracking-wide"></h4>
                    <p class="text-green-400 text-sm mt-2 uppercase tracking-widest font-semibold">Deep Quran Academy</p>
                </div>
            </div>
        </div>
    </section>
</x-layout>