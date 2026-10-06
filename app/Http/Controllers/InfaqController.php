<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfaqController extends Controller
{
    /**
     * Memproses upload bukti transfer untuk tagihan infaq yang sudah ada
     */
    public function upload(Request $request, $id)
    {
        // 1. Validasi file gambar
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Cari data tagihan berdasarkan ID
        $infaq = Infaq::findOrFail($id);

        // Keamanan: Pastikan yang upload adalah pemilik tagihan yang sah
        if ($infaq->user_id != Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses tagihan ini.');
        }

        // 3. Simpan foto ke folder storage
        $path = $request->file('bukti_transfer')->store('bukti-infaq', 'public');

        // 4. Update data tagihan (masukkan foto dan ubah status jadi 'pending')
        $infaq->update([
            'bukti_transfer' => $path,
            'status' => 'pending', // Status berubah, menunggu verifikasi Admin
        ]);

        // =====================================================================
        // [BARU] MENGIRIM NOTIFIKASI KE LONCENG DASHBOARD ADMIN
        // =====================================================================
        
        // Cari semua user yang memiliki role 'admin'
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('Bukti Infaq Baru!')
                ->body(Auth::user()->name . ' telah mengunggah bukti pembayaran infaq untuk periode ' . ($infaq->periode_bulan ?? 'ini') . '.')
                ->icon('heroicon-o-banknotes')
                ->success()
                ->sendToDatabase($admin);
        }
        
        // =====================================================================

        // 5. Kembali ke dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Jazakumullah khairan. Bukti transfer berhasil diunggah. Banner tagihan akan hilang setelah diverifikasi oleh Admin.');
    }
}