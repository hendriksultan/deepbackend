<div wire:ignore>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <div id="filament-map" style="height: 350px; width: 100%; border-radius: 0.5rem; z-index: 10; margin-top: 10px; border: 1px solid #e5e7eb;"></div>

  <script>
    document.addEventListener('livewire:initialized', () => {
      // Inisialisasi peta awal di Sukabumi
      var map = L.map('filament-map').setView([-6.9200, 106.9200], 12);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
      }).addTo(map);

      var marker;

      // Mendengarkan event dari form Filament
      Livewire.on('updateMapLocation', (eventData) => {
        // Livewire 3 kadang membungkus data dalam array
        let info = Array.isArray(eventData) ? eventData[0] : eventData;

        // Hapus pin lama jika admin mengganti pilihan
        if (marker) {
          map.removeLayer(marker);
        }

        // Jika data koordinat ada di database
        if (info.lat && info.lng) {
          var lat = parseFloat(info.lat);
          var lng = parseFloat(info.lng);

          // Buat Pin Baru
          marker = L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                            <div style="font-family: sans-serif; min-width: 150px;">
                                <strong style="color: #111827; font-size: 14px;">${info.group_name}</strong><br>
                                <span style="font-size: 12px; color: #6B7280;">${info.address}</span><br>
                                <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank" style="display:inline-block; margin-top:8px; color:#2563eb; text-decoration:none; font-size:12px;">📍 Buka di Google Maps</a>
                            </div>
                        `)
            .openPopup();

          // Animasi terbang ke lokasi
          map.flyTo([lat, lng], 16);
        } else {
          // Jika koordinat kosong, kembalikan tampilan ke default kota
          map.flyTo([-6.9200, 106.9200], 12);
        }
      });
    });
  </script>
</div>