<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiAssistantController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Mengambil kredensial dari .env (Aman & Rapi)
        $accountId = env('CLOUDFLARE_ACCOUNT_ID');
        $apiToken = env('CLOUDFLARE_API_TOKEN');

        // Nama AI Gateway
        $gatewayName = 'tahsin-app';

        // ======================================================
        // ⚡ Menggunakan Llama 3.1 versi standar
        // ======================================================
        $model = '@cf/meta/llama-3.1-8b-instruct';

        // URL menggunakan jalur AI Gateway
        $url = "https://gateway.ai.cloudflare.com/v1/{$accountId}/{$gatewayName}/workers-ai/{$model}";

        try {
            $response = Http::withToken($apiToken)
                ->withHeaders([
                    // Mengaktifkan memori Gateway selama 24 jam (86400 detik)
                    'cf-aig-cache-ttl' => 86400
                ])
                ->timeout(120)
                ->post($url, [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "Kamu adalah Asisten Cerdas (Customer Service) resmi untuk aplikasi belajar Al-Qur'an bernama 'Deep Quran Academy'. 
Tugasmu adalah membantu santri/siswa yang kebingungan menggunakan aplikasi ini.
Gunakan bahasa Indonesia yang ramah, profesional, dan solutif layaknya manusia sungguhan.

INFORMASI SISTEM APLIKASI (PENGETAHUANMU):
1. Pendaftaran: Siswa mencari guru di tab 'Rekomendasi', lalu klik 'Daftar'. Biaya pendaftaran adalah Rp 50.000, ditransfer ke Muamalat 1610055206.
2. Status Pendaftaran: Jika status 'Menunggu Pembayaran', siswa wajib upload bukti transfer. Jika 'Sedang Diverifikasi', tunggu admin mengecek. Jika 'Aktif', kelas siap dimulai.
3. Jadwal Kelas: Terdapat di bagian 'Jadwal Kelas Saya'. Jika kelas Online, tombol 'Mulai Belajar' untuk masuk ke Zoom/Gmeet HANYA AKAN AKTIF 20 menit sebelum jadwal kelas dimulai (sebelumnya akan berwarna abu-abu). Jika Offline, ustadz akan datang ke rumah (Home Visit).
4. Penilaian & Setoran: Nilai hafalan, tahsin (beserta koreksi tajwid), dan ujian bisa dilihat di tab 'Hafalan', 'Tahsin', dan 'Ujian' di halaman dashboard.
5. Materi Tambahan: Terdapat di tab 'Materi'. Siswa bisa membuka PDF atau menonton video dari ustadz. Saat siswa mengklik tombol tonton/buka, materi tersebut akan OTOMATIS ditandai 'Selesai' (muncul tanda hijau) dan tersimpan di sistem, jadi siswa tidak perlu mencentangnya secara manual.
6. Fitur Al-Qur'an: Terdapat fitur Al-Qur'an digital yang memiliki 'Markah Otomatis' untuk menyambung bacaan terakhir (Surah Al-Kahfi, Yasin, Al-Mulk ada pintasan khususnya).
7. Ganti Password/Profil: Bisa dilakukan dengan mengklik inisial nama di pojok kanan atas layar.
8. Infaq Bulanan: Besaran infaq berbeda, kelas online Rp. 100.000/bulan dan kelas offline (home visit) Rp. 150.000/bulan.
9. Tagihan Infaq: Akan otomatis muncul di dashboard siswa setiap bulannya dari tanggal 1 s/d tanggal 10.

ATURAN WAJIB: 
- JANGAN PERNAH menyebutkan kata 'panduan', 'buku panduan', atau 'berdasarkan informasi di atas'. Jawablah senatural mungkin seolah kamu memang mengetahui sistem ini luar dalam.
- Jawab HANYA berdasarkan informasi sistem di atas. Jangan mengarang fitur yang tidak ada.
- Jawab dengan ramah, santai, singkat, dan langsung ke inti (To the point).
- PENTING: Jika ada pertanyaan yang di luar pengetahuanmu (misal: cara ganti nama, jadwal libur), keluhan teknis (error/bug), atau hal yang butuh penanganan manusia, sampaikan permohonan maaf dengan natural dan arahkan siswa untuk chat Admin via WhatsApp. Wajib sertakan link ini di akhir kalimatmu: https://wa.me/6285860913931"
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->message
                        ]
                    ],
                    'temperature' => 0.1, // Dibuat rendah agar patuh pada buku panduan
                    
                    // ======================================================
                    // ⚡ [DIUBAH] Batas token diturunkan agar AI merespon lebih CEPAT
                    // ======================================================
                    'max_tokens' => 300
                ]);

            if ($response->successful()) {
                $result = $response->json();
                return response()->json([
                    'success' => true,
                    'reply' => $result['result']['response'] ?? 'Maaf, saya sedang tidak bisa merespon.'
                ]);
            }

            $errorData = $response->json();
            $errorMessage = $errorData['errors'][0]['message'] ?? 'Server Cloudflare sedang sibuk/menolak akses.';
            return response()->json(['success' => false, 'error' => 'API Error: ' . $errorMessage], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Sistem Error: ' . $e->getMessage()], 500);
        }
    }
}