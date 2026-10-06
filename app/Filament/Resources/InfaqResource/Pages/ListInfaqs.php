<?php

namespace App\Filament\Resources\InfaqResource\Pages;

use App\Filament\Resources\InfaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Forms\Get; // [BARU] Untuk interaktivitas form

// Import yang dibutuhkan
use Filament\Notifications\Notification;
use App\Models\Infaq;
use App\Models\User;
use Carbon\Carbon;

class ListInfaqs extends ListRecords
{
    protected static string $resource = InfaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate_tagihan')
                ->label('Buat Tagihan Bulan Ini')
                ->icon('heroicon-o-megaphone')
                ->color('warning')
                ->modalHeading('Kirim Tagihan Infaq')
                ->modalDescription('Sistem akan mengakumulasi biaya (Online: 100rb, Offline: 150rb per kelas).')
                // =========================================================
                // [BARU] TAMBAHAN FORM DINAMIS UNTUK PILIH SANTRI SPESIFIK
                // =========================================================
                ->form([
                    Forms\Components\Select::make('target_type')
                        ->label('Target Pengiriman')
                        ->options([
                            'all' => 'Kirim ke Semua Santri Aktif',
                            'specific' => 'Pilih Santri Tertentu',
                        ])
                        ->default('all')
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('user_ids')
                        ->label('Pilih Santri (Bisa lebih dari 1)')
                        ->multiple()
                        ->searchable()
                        // Hanya tampilkan di dropdown santri yang punya jadwal aktif
                        ->options(User::whereHas('bookings', function ($q) {
                            $q->where('status', 'active');
                        })->pluck('name', 'id'))
                        ->visible(fn (Get $get) => $get('target_type') === 'specific')
                        ->required(fn (Get $get) => $get('target_type') === 'specific'),

                    Forms\Components\TextInput::make('periode_bulan')
                        ->label('Periode Tagihan')
                        ->default(Carbon::now()->translatedFormat('F Y'))
                        ->required(),
                ])
                ->action(function (array $data) {
                    $jumlahTerkirim = 0;
                    $periode = $data['periode_bulan'];

                    // 1. Base Query: Ambil USER yang memiliki minimal 1 kelas aktif
                    $query = User::whereHas('bookings', function ($q) {
                        $q->where('status', 'active');
                    })->with(['bookings' => function ($q) {
                        $q->where('status', 'active');
                    }]);

                    // 2. Jika pilih spesifik, saring query berdasarkan ID santri yang dipilih
                    if ($data['target_type'] === 'specific') {
                        $query->whereIn('id', $data['user_ids']);
                    }

                    $santriAktif = $query->get();

                    // 3. Looping per-Santri
                    foreach ($santriAktif as $santri) {
                        // Cek apakah santri ini sudah punya tagihan di bulan/periode ini
                        $cekTagihan = Infaq::where('user_id', $santri->id)
                            ->where('periode_bulan', $periode)
                            ->exists();

                        if (!$cekTagihan) {
                            // 4. HITUNG TOTAL NOMINAL UNTUK SEMUA KELAS DIA
                            $totalNominal = 0;
                            foreach ($santri->bookings as $booking) {
                                // Tambah 100rb jika online, 150rb jika offline (Sesuai kode asli Bapak)
                                $totalNominal += ($booking->method === 'online') ? 100000 : 150000;
                            }

                            // 5. Buat SATU tagihan gabungan
                            Infaq::create([
                                'user_id' => $santri->id,
                                'periode_bulan' => $periode,
                                'nominal' => $totalNominal,
                                'bukti_transfer' => null,
                                'status' => 'unpaid',
                            ]);
                            $jumlahTerkirim++;
                        }
                    }

                    if ($jumlahTerkirim > 0) {
                        Notification::make()
                            ->title("Berhasil! $jumlahTerkirim tagihan telah dikirim.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title("Dilewati. Santri yang dipilih sudah memiliki tagihan untuk $periode.")
                            ->warning()
                            ->send();
                    }
                }),
        ];
    }
}