<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\QuranBookmark; // [BARU] Import Model Bookmark
use Illuminate\Support\Facades\Auth; // [BARU] Import Auth
use Illuminate\Http\Request; // [BARU] Import Request

class QuranController extends Controller
{
    // 1. DAFTAR SEMUA SURAT
    public function index()
    {
        // Cache selama 1 hari (60 * 60 * 24 detik) karena data surat tidak berubah
        $surat = Cache::remember('quran_list', 86400, function () {
            $response = Http::get('https://equran.id/api/v2/surat');
            return $response->successful() ? $response->json()['data'] : [];
        });

        return view('student.quran.index', compact('surat'));
    }

    // 2. DETAIL SURAT (BACAAN)
    public function show($nomor)
    {
        // Cache per surat selamanya (karena ayat tidak berubah)
        $detail = Cache::remember("quran_surat_{$nomor}", 86400, function () use ($nomor) {
            $response = Http::get("https://equran.id/api/v2/surat/{$nomor}");
            return $response->successful() ? $response->json()['data'] : null;
        });

        if (!$detail) {
            return back()->with('error', 'Gagal mengambil data surat.');
        }

        // [BARU] Ambil data Bookmark User untuk surat ini
        // Kita ambil array nomor ayat saja untuk pengecekan cepat di View (in_array)
        $bookmarks = QuranBookmark::where('user_id', Auth::id())
            ->where('surat_nomor', $nomor)
            ->pluck('ayat_nomor')
            ->toArray();

        return view('student.quran.show', compact('detail', 'bookmarks'));
    }

    // 3. TAFSIR SURAT
    public function tafsir($nomor)
    {
        $tafsir = Cache::remember("quran_tafsir_{$nomor}", 86400, function () use ($nomor) {
            $response = Http::get("https://equran.id/api/v2/tafsir/{$nomor}");
            return $response->successful() ? $response->json()['data'] : null;
        });

        return view('student.quran.tafsir', compact('tafsir'));
    }

    // 4. [BARU] FUNGSI TOGGLE MARKAH (AJAX)
    public function toggleBookmark(Request $request)
    {
        // Validasi input
        $request->validate([
            'surat_nomor' => 'required|integer',
            'ayat_nomor' => 'required|integer',
        ]);

        $user = Auth::user();

        // Cek apakah markah sudah ada di database
        $bookmark = QuranBookmark::where('user_id', $user->id)
            ->where('surat_nomor', $request->surat_nomor)
            ->where('ayat_nomor', $request->ayat_nomor)
            ->first();

        if ($bookmark) {
            // Jika ada, hapus (Unmark)
            $bookmark->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Markah dihapus'
            ]);
        } else {
            // Jika tidak ada, simpan baru (Mark)
            QuranBookmark::create([
                'user_id' => $user->id,
                'surat_nomor' => $request->surat_nomor,
                'ayat_nomor' => $request->ayat_nomor
            ]);

            return response()->json([
                'status' => 'added',
                'message' => 'Ditandai sebagai terakhir dibaca'
            ]);
        }
    }
}
