<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\User; // (Buka komentar ini nanti jika ingin ambil data asli dari database)

class AsatidzController extends Controller
{
    public function index()
    {
        // Ini adalah contoh data statis (*dummy data*) untuk pengetesan.
        // Nanti bisa diganti dengan query database seperti: 
        // $data = User::where('role', 'asatidz')->get();

        $data = [
            ['id' => 1, 'nama' => 'Ustadz Ahmad', 'bidang' => 'Tahsin'],
            ['id' => 2, 'nama' => 'Ustadz Budi', 'bidang' => 'Bahasa Arab'],
            ['id' => 3, 'nama' => 'Pegawai TU', 'bidang' => 'Administrasi'],
        ];

        // Format standar response API
        return response()->json([
            'status' => 'success',
            'message' => 'Data asatidz dan pegawai berhasil diambil',
            'data' => $data
        ], 200);
    }
}
