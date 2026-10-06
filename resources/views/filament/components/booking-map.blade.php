<div wire:ignore>
    <div
        x-data="{
            map: null,
            marker: null,
            // $entangle otomatis melacak posisi state form (Page maupun Modal)
            state: $wire.$entangle('{{ $getStatePath() }}'),
            
            init() {
                this.loadAssets();
            },
            loadAssets() {
                if (!document.querySelector('link[href=\'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css\']')) {
                    let link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                    document.head.appendChild(link);
                }

                if (typeof window.L === 'undefined') {
                    let script = document.createElement('script');
                    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    script.onload = () => {
                        this.renderMap();
                    };
                    document.head.appendChild(script);
                } else {
                    this.renderMap();
                }
            },
            renderMap() {
                // Pastikan fitur zoomControl dan scrollWheelZoom aktif
                this.map = L.map(this.$refs.mapContainer, {
                    zoomControl: true,
                    scrollWheelZoom: true,
                    dragging: true
                }).setView([-6.9200, 106.9200], 12);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);

                // MENCEGAH MODAL FILAMENT MEMBLOKIR ZOOM MOUSE
                this.$refs.mapContainer.addEventListener('wheel', (e) => {
                    e.stopPropagation();
                });

                // ResizeObserver memaksa peta me-render ulang ukuran 
                // setiap kali modal dibuka/ditutup/dianimasikan
                let observer = new ResizeObserver(() => {
                    if (this.map) {
                        this.map.invalidateSize();
                    }
                });
                observer.observe(this.$refs.mapContainer);

                // Pantau perubahan dari state tersembunyi
                this.$watch('state', (value) => {
                    this.updateMarker(value);
                });

                // Cek data awal jika dibuka dalam mode edit
                if (this.state) {
                    setTimeout(() => { this.updateMarker(this.state); }, 300);
                }
            },
            updateMarker(info) {
                if (!info || !info.lat || !info.lng) return;

                if (this.marker) {
                    this.map.removeLayer(this.marker);
                }

                let lat = parseFloat(info.lat);
                let lng = parseFloat(info.lng);
                let jumlahPeserta = info.jumlah ? info.jumlah : 1;
                
                // ========================================================
                // [BARU] LOGIKA PRIORITAS LINK MAPS
                // ========================================================
                // Jika maps_link ada di database, gunakan itu. 
                // Jika NULL/kosong, buatkan link otomatis dari koordinat.
                let targetUrl = info.maps_link 
                    ? info.maps_link 
                    : `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;

                this.marker = L.marker([lat, lng]).addTo(this.map)
                    .bindPopup(`
                        <div style='font-family: sans-serif; min-width: 170px;'>
                            <strong style='color: #111827; font-size: 14px;'>${info.group_name}</strong><br>
                            <span style='font-size: 12px; color: #6B7280; display: block; margin-top: 4px;'>${info.address}</span>
                            
                            <div style='margin-top: 8px; padding: 4px 8px; background: #10B981; color: white; border-radius: 4px; display: inline-block; font-size: 11px; font-weight: bold;'>
                                👥 Peserta: ${jumlahPeserta} Orang
                            </div><br>
                            
                            <a href='${targetUrl}' target='_blank' style='display:inline-block; margin-top:10px; color:#2563eb; text-decoration:none; font-size:12px; font-weight: 600;'>
                                📍 Buka Rute Maps
                            </a>
                        </div>
                    `).openPopup();

                this.map.flyTo([lat, lng], 16);
            }
        }"
    >
        <div x-ref="mapContainer" style="height: 350px; width: 100%; border-radius: 0.5rem; z-index: 10; margin-top: 10px; border: 1px solid #e5e7eb;"></div>
    </div>
</div>