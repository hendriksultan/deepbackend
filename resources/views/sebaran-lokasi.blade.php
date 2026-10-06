<x-layout>
    <x-slot:title>Peta Sebaran Lokasi Belajar - Deep Quran Academy</x-slot:title>

    {{-- ========================================================== --}}
    {{-- 1. HERO SECTION --}}
    {{-- ========================================================== --}}
    <section class="relative pt-24 pb-32 md:pt-28 md:pb-40 mb-10 bg-gradient-to-br from-green-900 via-green-800 to-green-600 overflow-hidden">
        
        <div class="absolute inset-0 opacity-20 mix-blend-overlay" style="background-image: url('{{ asset('arabesque.png') }}');"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>

        <div class="container max-w-7xl mx-auto px-4 md:px-6 relative z-10 flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-5 bg-green-800/50 border border-green-700 rounded-full backdrop-blur-md" data-aos="fade-down">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="text-xs font-semibold capitalize tracking-wider text-green-100">Home Visit Map</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 text-white" data-aos="fade-up" data-aos-delay="100">
                Peta Sebaran <br class="md:hidden">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Lokasi Belajar</span>
            </h1>
            
            <p class="text-xs md:text-base text-green-100/90 leading-relaxed font-light max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                "Khairukum man ta'allamal-Qur'ana wa 'allamahu." <br>
                <span class="font-light italic block mt-0.5 text-xs text-green-200">"Sebaik-baik kalian adalah orang yang belajar Al-Qur'an dan mengajarkannya."</span>
                <span class="font-semibold block mt-2 text-yellow-400 text-xs md:text-sm">(HR. Bukhari)</span>
            </p>
        </div>
    </section>

   {{-- ========================================================== --}}
    {{-- 2. AREA PETA UTAMA (Unified Card Layout) --}}
    {{-- ========================================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 relative z-20 -mt-16 md:-mt-24">
        
        {{-- FIX FATAL BUG: Atribut data-aos TELAH DIHAPUS dari sini agar Leaflet tidak error --}}
        <div x-data="publicMap()" class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden p-4 md:p-6 lg:p-8 w-full">
            
            {{-- Header di dalam Kartu --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Titik Halqoh & Kelas Aktif
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mt-1">Menampilkan seluruh lokasi pembelajaran tatap muka langsung (Offline) saat ini.</p>
                </div>
                
                {{-- Badge Total --}}
                <div class="bg-green-50 dark:bg-green-950/40 px-4 py-2.5 rounded-xl text-xs md:text-sm font-bold text-green-700 dark:text-green-400 border border-green-100 dark:border-green-900/30 shadow-sm flex items-center gap-2 whitespace-nowrap">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                    Total: <span x-text="totalTitik" class="text-green-600 dark:text-green-400 font-medium text-base md:text-base">0</span> Titik Terdaftar
                </div>
            </div>

            {{-- Kotak Peta --}}
            <div 
                x-init="initMap()" 
                x-ref="mapContainer"
                class="w-full rounded-xl md:rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 relative z-10"
                style="height: 60vh; min-height: 480px; max-height: 600px;"
            ></div>
            
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- 3. LOAD LIBRARY ASSETS & LEAFLET ENGINE --}}
    {{-- ========================================================== --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const dataLokasi = @json($lokasiSantri);

        document.addEventListener('alpine:init', () => {
            Alpine.data('publicMap', () => ({
                totalTitik: 0,

                initMap() {
                    const map = L.map(this.$refs.mapContainer).setView([-6.9200, 106.9200], 12);
                    
                    // Pilihan peta dasar: satelit ditampilkan saat pertama dibuka.
                    const peta = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    });

                    const satelit = L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                        // Gunakan citra hingga zoom 18; zoom selanjutnya memperbesar tile yang tersedia.
                        maxNativeZoom: 18,
                        maxZoom: 21,
                        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Maxar, Earthstar Geographics, and the GIS User Community'
                    }).addTo(map);

                    L.control.layers({
                        'Satelit': satelit,
                        'Peta': peta
                    }, null, {
                        position: 'topright',
                        collapsed: false
                    }).addTo(map);

                    let observer = new ResizeObserver(() => {
                        map.invalidateSize({ pan: false });
                    });
                    observer.observe(this.$refs.mapContainer);

                    let boundsArray = [];
                    let groupedData = {};

                    dataLokasi.forEach(lokasi => {
                        let lat = parseFloat(lokasi.latitude);
                        let lng = parseFloat(lokasi.longitude);

                        if (lat && lng) {
                            let key = `${lat},${lng}`;

                            if (!groupedData[key]) {
                                groupedData[key] = {
                                    lat: lat,
                                    lng: lng,
                                    group_name: lokasi.group_name || 'Tanpa Nama Kelompok',
                                    address: lokasi.student_address || 'Alamat tidak tersedia',
                                    program_type: lokasi.program_type || '-',
                                    maps_link: lokasi.maps_link || null, 
                                    jumlah_peserta: 0
                                };
                            }
                            groupedData[key].jumlah_peserta += 1;
                        }
                    });

                    this.totalTitik = Object.keys(groupedData).length;

                    Object.values(groupedData).forEach(info => {
                        boundsArray.push([info.lat, info.lng]);
                        let marker = L.marker([info.lat, info.lng]).addTo(map);
                        
                        // Perbaikan rute fallback menggunakan URL Universal Google Maps
                        let targetUrl = info.maps_link 
                            ? info.maps_link 
                            : `https://www.google.com/maps/search/?api=1&query=${info.lat},${info.lng}`;
                        
                        // Popup melekat pada marker; peta hanya bergeser jika popup keluar area. 
                        marker.bindPopup(`
                            <div style="font-family: sans-serif; min-width: 150px; padding: 0px;">
                                <div style="font-size: 10px; font-weight: bold; color: #16a34a; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">
                                    📖 Kelas Offline
                                </div>
                                <strong style="color: #111827; font-size: 13px; display: block; margin-bottom: 4px; line-height: 1.2;">
                                    ${info.group_name}
                                </strong>
                                <span style="font-size: 11px; color: #4B5563; display: block; line-height: 1.3; margin-bottom: 8px;">
                                    📍 ${info.address}
                                </span>
                                
                                <div style="display: flex; gap: 4px; align-items: center; margin-bottom: 8px;">
                                    <span style="background: #FEF3C7; color: #92400E; padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase;">
                                        Program: ${info.program_type}
                                    </span>
                                </div>
                                
                                <div style="padding: 4px 8px; background: #10B981; color: white; border-radius: 6px; display: inline-block; font-size: 10px; font-weight: bold;">
                                    👥 Peserta: ${info.jumlah_peserta} Orang
                                </div><br>

                                <a href="${targetUrl}" target="_blank" style="display:inline-block; margin-top:10px; color:#2563eb; text-decoration:none; font-size:11px; font-weight: 600;">
                                    📍 Buka Rute Maps
                                </a>
                            </div>
                        `, { autoPan: true, autoPanPadding: [20, 20] });

                    });

                    if (boundsArray.length > 0) {
                        map.fitBounds(boundsArray, { padding: [50, 50] });
                    }
                }
            }));
        });
    </script>
</x-layout>