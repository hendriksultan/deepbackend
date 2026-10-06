<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    public function dashboard($booking_id)
    {
        // 1. Ambil data profil santri dari tabel bookings
        $santri = DB::table('bookings')->where('id', $booking_id)->first();

        if (!$santri) {
            return response()->json(['status' => 'error', 'message' => 'Data santri tidak ditemukan'], 404);
        }

        // 2. Ambil evaluasi terakhir (Contoh dari tabel evaluasi_iqras)
        $evaluasiTerakhir = DB::table('evaluasi_iqras')
            ->where('booking_id', $booking_id)
            ->orderBy('tanggal', 'desc')
            ->first();

        // 3. Ambil status infaq terakhir
        $infaqTerakhir = DB::table('infaqs')
            ->where('user_id', $santri->user_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // 4. Susun format JSON yang rapi untuk React Native
        return response()->json([
            'status' => 'success',
            'data' => [
                'profil' => [
                    'nama' => $santri->student_name,
                    'program' => strtoupper($santri->program_type),
                    'grup' => $santri->group_name,
                ],
                'evaluasi_terakhir' => $evaluasiTerakhir ? [
                    'tanggal' => $evaluasiTerakhir->tanggal,
                    'jilid' => $evaluasiTerakhir->jilid,
                    'halaman' => $evaluasiTerakhir->halaman,
                    'nilai' => $evaluasiTerakhir->nilai,
                    'catatan' => $evaluasiTerakhir->catatan_guru,
                ] : null,
                'tagihan_terakhir' => $infaqTerakhir ? [
                    'periode' => $infaqTerakhir->periode_bulan,
                    'nominal' => $infaqTerakhir->nominal,
                    'status' => $infaqTerakhir->status,
                ] : null,
            ]
        ], 200);
    }
}
