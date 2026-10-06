const CACHE_NAME = 'deepquran-pwa-v1';
const ASSETS_TO_CACHE = [
  '/images/pavicon.png',
  '/manifest.json'
  // Catatan: Kita sengaja TIDAK men-cache halaman '/' atau '/login' 
  // agar form login Laravel (CSRF Token) tidak error (Token Mismatch).
];

// Install Service Worker dan simpan asset statis ke cache
self.addEventListener('install', event => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(ASSETS_TO_CACHE);
      })
  );
});

// Hapus cache lama jika ada versi baru
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.filter(name => name !== CACHE_NAME)
          .map(name => caches.delete(name))
      );
    })
  );
});

// Strategi: Network First (Coba ambil dari server dulu, jika gagal baru cek cache)
self.addEventListener('fetch', event => {
  // Hanya tangani request GET
  if (event.request.method !== 'GET') return;

  event.respondWith(
    fetch(event.request)
      .catch(() => {
        return caches.match(event.request);
      })
  );
});