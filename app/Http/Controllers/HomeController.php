<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;
use App\Models\Review; 
// use App\Models\Gallery; // Bisa di-import di sini jika mau

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Landing Page)
     */
    public function index()
    {
        // 1. Ambil data guru (Dibatasi 8 secara acak)
        $teachers = \App\Models\TeacherProfile::with('user')
            ->where('is_verified', true)
            ->inRandomOrder() 
            ->take(8)  
            ->get();

        // 2. Ambil data ulasan
        $reviews = \App\Models\Review::where('is_visible', true)
            ->latest()
            ->get();

        // 3. Ambil data 5 siswa terbaru (Untuk Popup)
        $recentStudents = \App\Models\User::where('role', 'student')
            ->where('is_verified', true)
            ->latest()
            ->take(5)
            ->get(['name', 'address', 'created_at']);

        return view('welcome', compact('teachers', 'reviews', 'recentStudents'));
    }

    /**
     * Menangani Form "Kirim Ulasan"
     */
    public function storeReview(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:50',
            'role'    => 'nullable|string|max:50',
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:500',
        ]);

        Review::create([
            'name'       => $request->name,
            'role'       => $request->role ?? 'Pengunjung',
            'rating'     => $request->rating,
            'content'    => $request->content,
            'is_visible' => false, 
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda telah dikirim dan menunggu persetujuan admin.');
    }

    /**
     * [BARU] Menampilkan Halaman Khusus Galeri
     */
    public function galeri()
    {
        // Ambil data dari model Gallery Filament (Ganti \App\Models\Gallery jika nama modelnya berbeda)
        // Dibatasi 12 foto per halaman agar loading tetap ringan
        $galeris = \App\Models\Gallery::latest()->paginate(12); 
        
        return view('galeri', compact('galeris'));
    }
}