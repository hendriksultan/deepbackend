# API Peserta Deep Quran Academy — tahap 1

Paket perubahan berdasarkan core_deepquran(2).zip dan struktur SQL yang dilampirkan.
Ini paket backend API; belum aplikasi Android/APK. Tidak ada perubahan struktur database.
Model akun tetap mendukung role student dan santri; hanya akun is_verified yang bisa login.
Sanctum harus terpasang, tabel personal_access_tokens harus tersedia (sudah ada dalam SQL Anda).

## Pasang di lokal dahulu

1. Cadangkan project dan database.
2. Salin isi folder app, bootstrap, routes dari paket ini ke root project Laravel, sesuai jalurnya.
   Ada 5 file: User.php, bootstrap/app.php, routes/api.php, StudentController.php, EnsureMobileStudent.php.
   User.php dan bootstrap/app.php adalah file lengkap berdasarkan source yang dilampirkan.
   Jika file lokal sudah berubah setelah source dikirim, gabungkan perubahan dahulu; jangan menimpa versi yang lebih baru.
3. Di Terminal Laragon, dari C:\laragon\www\core_deepquran jalankan:
   composer install
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan storage:link
   php artisan route:list --path=api
4. Jika storage:link mengatakan link sudah ada, tidak perlu dibuat ulang.
5. Periksa APP_URL lokal agar URL foto/bukti benar. APP_URL produksi harus HTTPS.
6. Jalankan php artisan serve dan uji menggunakan Postman.

Tidak perlu migrate:fresh, db:wipe, key:generate, atau mengimpor ulang database.
Pastikan tabel personal_access_tokens ada di database lokal. Paket tidak membawa .env atau kredensial.

## Endpoint

Base lokal: http://127.0.0.1:8000/api/v1
Semua request: Accept: application/json
Setelah login: Authorization: Bearer TOKEN
Token berlaku 30 hari; login ulang saat 401. Logout menghapus token perangkat tersebut.
Ganti password menghapus semua token mobile; sesi web mengikuti mekanisme web yang sudah ada.

POST /login: JSON email, password, device_name
POST /logout
GET /me
POST /me: JSON biodata parsial; untuk photo gunakan multipart/form-data.
POST /password: current_password, password, password_confirmation
GET /dashboard
GET /bookings?page=1
GET /bookings/{id}
GET /schedules?booking_id=ID&from=2026-10-01&to=2026-10-31&page=1
GET /infaqs?page=1
POST /infaqs/{id}/proof: form-data bukti_transfer (File JPG/PNG, maksimal 2 MB)
GET /notifications?page=1
POST /notifications/{uuid}/read

Respons sukses: status, message, data.
Respons gagal menggunakan message dan errors bila validasi; status HTTP 401/403/404/409/422/429.
Daftar dipaginasi: data.data berisi item; data.current_page dan data.last_page untuk navigasi.
404 dipakai ketika ID tidak ditemukan atau bukan milik peserta, tanpa membocorkan pemilik sebenarnya.
Upload hanya untuk status unpaid/rejected; pending/verified mendapat 409.
Notifikasi upload dikirim ke database admin seperti alur web, belum push notification.
Link meeting dibaca saja: membuka link tidak otomatis mengubah kehadiran atau menyelesaikan kelas.
Bukti/foto menggunakan disk public mengikuti web saat ini.
Endpoint daftar guru dummy dan dashboard legacy tidak diaktifkan.
Belum mencakup daftar akun, lupa password, booking baru, rekening pembayaran, evaluasi,
materi, tugas, ujian, Al-Qur'an, atau push. Ini tahap fondasi empat menu peserta.

## Uji wajib sebelum produksi

- Login peserta terverifikasi: 200 + token. Password salah: 422.
- Admin/guru atau peserta belum terverifikasi: 403, tanpa token.
- Tanpa token atau token kedaluwarsa/dihapus: 401 dalam JSON, tanpa redirect ke login web.
- Dengan dua akun peserta A/B: A tidak bisa membaca booking B atau upload infaq B (404).
- A tidak dapat menandai notifikasi B sebagai dibaca (404).
- /dashboard, /bookings, /schedules, /infaqs hanya mengembalikan data A.
- Upload JPG/PNG valid ke unpaid: 200, status pending, notifikasi admin masuk.
- Upload ke pending/verified: 409; PDF/lebih dari 2 MB: 422.
- Profil: role/is_verified tidak bisa diubah melalui API; email duplikat: 422.
- Password lama salah: 422; password benar: semua token lama menghasilkan 401.
- Logout: token lama tidak lagi diterima.
- Pastikan login web peserta, panel admin/guru, dan verifikasi infaq web tetap berfungsi.

## Batas verifikasi paket ini

Kode diperiksa terhadap model, controller, dan struktur SQL source Anda.
PHP/Composer tidak tersedia di lingkungan penyusunan, sehingga lint PHP dan uji Laravel/database
belum dijalankan. Jalankan pemeriksaan berikut di Terminal Laragon sebelum memasang ke produksi:

php -l app/Http/Controllers/Api/V1/StudentController.php
php -l app/Http/Middleware/EnsureMobileStudent.php
php -l app/Models/User.php
php -l bootstrap/app.php
php -l routes/api.php

Setelah uji lokal lulus, tahap berikutnya adalah aplikasi Expo peserta yang mengakses API ini.
Untuk ponsel fisik, 127.0.0.1 menunjuk ke ponsel sendiri; gunakan alamat server LAN/tunnel yang sesuai.
