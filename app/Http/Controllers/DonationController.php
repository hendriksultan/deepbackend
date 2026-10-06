<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('is_active', true)->latest()->get();
        return view('donations.index', compact('campaigns'));
    }

    public function show($slug)
    {
        $campaign = Campaign::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('donations.show', compact('campaign'));
    }

    // Proses penyimpanan form donasi
    public function store(Request $request, $slug)
    {
        $campaign = Campaign::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Validasi inputan form (Tripay dihapus karena fokus manual)
        $request->validate([
            'amount' => 'required|numeric|min:10000', // Minimal donasi 10rb
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:manual', 
            'message' => 'nullable|string'
        ]);

        // Buat Kode Unik Invoice
        $reference = 'DQA-' . strtoupper(uniqid());

        // ========================================================
        // KODE SAKTI: Generate 3 Digit Unik & Tambahkan ke Nominal
        // ========================================================
        $kodeUnik = rand(111, 999); // Menghasilkan angka acak antara 111 sampai 999
        $totalTransfer = $request->amount + $kodeUnik; // Menjumlahkan donasi asli + kode unik

        // Simpan ke database
        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'donor_name' => $request->donor_name,
            'donor_phone' => $request->donor_phone,
            'amount' => $totalTransfer, // <--- Simpan nominal yang sudah ditambah kode unik
            'payment_method' => $request->payment_method,
            'is_anonymous' => $request->has('is_anonymous'),
            'message' => $request->message,
            'status' => 'pending',
            'reference' => $reference,
        ]);

        // Arahkan ke Halaman Instruksi Transfer Manual
        return redirect()->route('donasi.success', $donation->reference);
    }

    // Halaman Instruksi Transfer Manual
    public function success($reference)
    {
        $donation = Donation::where('reference', $reference)->firstOrFail();
        return view('donations.success', compact('donation'));
    }
}