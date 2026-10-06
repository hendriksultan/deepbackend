<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfaqResource\Pages;
use App\Models\Infaq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

// Import Notifikasi Bawaan
use Filament\Notifications\Notification;

// Import WA Fonnte & Collection
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class InfaqResource extends Resource
{
    protected static ?string $model = Infaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationLabel = 'Verifikasi Infaq';
    protected static ?string $pluralModelLabel = 'Data Infaq';
    protected static ?string $navigationGroup = 'Manajemen Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Nama Santri')
                            ->disabled(), 

                        Forms\Components\TextInput::make('periode_bulan')
                            ->label('Periode (Bulan & Tahun)')
                            ->required(),

                        Forms\Components\TextInput::make('nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\FileUpload::make('bukti_transfer')
                            ->label('Bukti Transfer')
                            ->image()
                            ->openable() 
                            ->disabled() 
                            ->columnSpanFull(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'unpaid' => 'Belum Bayar', 
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Sudah Diverifikasi',
                                'rejected' => 'Ditolak',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan (Jika ditolak)')
                            ->columnSpanFull(),
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Santri')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('periode_bulan')
                    ->label('Periode')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nominal')
                    ->money('idr') 
                    ->sortable(),

                Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->label('Bukti')
                    ->circular(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'unpaid' => 'gray', 
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'unpaid' => 'Belum Bayar',
                        'pending' => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make('lihat_bukti')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Infaq $record) => $record->status === 'pending')
                    ->action(function (Infaq $record) {
                        $record->update(['status' => 'verified']);

                        Notification::make()
                            ->title('Infaq Diterima')
                            ->body("Alhamdulillah, pembayaran infaq Anda untuk bulan {$record->periode_bulan} telah diverifikasi. Jazakumullah khairan.")
                            ->success()
                            ->sendToDatabase($record->user);

                        // =======================================================
                        // [MODIFIKASI] PENCUCI NOMOR HP (Aksi Verifikasi)
                        // =======================================================
                        $hpKotor = $record->user->phone ?? null; 
                        $noHpSantri = null;

                        if ($hpKotor) {
                            // 1. Buang karakter non-angka (seperti + atau spasi)
                            $hpBersih = preg_replace('/[^0-9]/', '', $hpKotor);
                            // 2. Cek apakah depannya angka 0
                            if (substr($hpBersih, 0, 1) === '0') {
                                $noHpSantri = '62' . substr($hpBersih, 1);
                            } else {
                                $noHpSantri = $hpBersih; // Biarkan utuh untuk nomor luar negeri/sudah 62
                            }
                        }

                        $tokenFonnte = env('FONNTE_TOKEN'); 

                        if (empty($tokenFonnte)) {
                            Notification::make()
                                ->title('Gagal Kirim WA')
                                ->body('Token Fonnte Kosong! Pastikan FONNTE_TOKEN sudah ada di file .env dan hapus cache.')
                                ->danger()
                                ->send();
                        } elseif (empty($noHpSantri)) {
                            Notification::make()
                                ->title('Peringatan WA')
                                ->body('Santri ini belum memasukkan Nomor HP. Pesan WA tidak dikirim.')
                                ->warning()
                                ->send();
                        } else {
                            $nominalRp = number_format($record->nominal, 0, ',', '.');
                            $pesanWa = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n"
                                        . "Alhamdulillah, pembayaran infaq atas nama *{$record->user->name}* "
                                        . "untuk periode *{$record->periode_bulan}* sebesar *Rp {$nominalRp}* "
                                        . "telah kami terima dan verifikasi.\n\n"
                                        . "Terima kasih atas kepercayaan dan dukungan Anda. "
                                        . "Semoga Allah memberkahi rezeki dan keluarga Anda, "
                                        . "serta memberikan kemudahan dan keberkahan dalam proses belajar.\n\n"
                                        . "Jazakumullahu khairan.\n\n"
                                        . "_Pesan ini dikirim secara otomatis oleh Sistem Informasi Deep Quran Academy._";

                            try {
                                Http::withHeaders([
                                    'Authorization' => $tokenFonnte,
                                ])->post('https://api.fonnte.com/send', [
                                    'target' => $noHpSantri,
                                    'message' => $pesanWa,
                                ]);
                            } catch (\Exception $e) {
                                // Diamkan jika error jaringan
                            }
                        }

                        Notification::make()
                            ->title('Berhasil Diverifikasi')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make('edit_tagihan')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),

                Tables\Actions\DeleteAction::make('hapus_tagihan')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('kirim_tagihan_wa')
                        ->label('Kirim Tagihan via WA')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Kirim Pemberitahuan Tagihan WA')
                        ->modalDescription('Pesan tagihan hanya akan dikirim kepada santri yang berstatus "Belum Bayar" (Unpaid). Lanjutkan?')
                        ->action(function (Collection $records) {
                            
                            $tokenFonnte = env('FONNTE_TOKEN'); 

                            if (empty($tokenFonnte)) {
                                Notification::make()
                                    ->title('ERROR: Token Fonnte Kosong!')
                                    ->body('Token tidak terbaca, coba bersihkan cache.')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            $berhasil = 0;
                            $gagal = 0;
                            $alasanTerakhir = "";

                            foreach ($records as $record) {
                                
                                // =======================================================
                                // [MODIFIKASI] PENCUCI NOMOR HP (Aksi Massal)
                                // =======================================================
                                $hpKotor = $record->user->phone ?? null; 
                                $noHpSantri = null;

                                if ($hpKotor) {
                                    $hpBersih = preg_replace('/[^0-9]/', '', $hpKotor);
                                    if (substr($hpBersih, 0, 1) === '0') {
                                        $noHpSantri = '62' . substr($hpBersih, 1);
                                    } else {
                                        $noHpSantri = $hpBersih;
                                    }
                                }

                                if (empty($noHpSantri)) {
                                    $gagal++;
                                    $alasanTerakhir = "Beberapa santri tidak punya Nomor HP atau format salah.";
                                    continue;
                                }

                                if ($record->status === 'unpaid') {
                                    $nominalRp = number_format($record->nominal, 0, ',', '.');
                                    
                                    // HEADER SISTEM
                                    $pesan = "🤖 *PESAN OTOMATIS SISTEM*\n";
                                    $pesan .= "---------------------------------------\n\n";
                                    
                                    $pesan .= "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n";
                                    $pesan .= "Kepada Yth. Wali Santri / Peserta:\n";
                                    $pesan .= "*{$record->user->name}*\n\n";
                                    $pesan .= "Ini adalah pengingat otomatis dari *Sistem Informasi Deep Quran Academy* bahwa terdapat kewajiban Infaq yang belum ditunaikan untuk:\n\n";
                                    $pesan .= "Periode : *{$record->periode_bulan}*\n";
                                    $pesan .= "Nominal : *Rp {$nominalRp}*\n\n";
                                    $pesan .= "Silakan login ke aplikasi untuk melihat instruksi pembayaran dan mengunggah bukti transfer.\n\n";
                                    
                                    // Tambahan kalimat abaikan jika sudah membayar
                                    $pesan .= "_(Catatan: Mohon abaikan pesan ini apabila Anda sudah menunaikan Infaq bulan tersebut)_\n\n";
                                    
                                    $pesan .= "Jazakumullah Khairan.\n\n";
                                    
                                    // FOOTER (PERINGATAN JANGAN DIBALAS)
                                    $pesan .= "---------------------------------------\n";
                                    $pesan .= "⛔ _Pesan ini dibuat dan dikirim secara otomatis oleh komputer. Mohon untuk **TIDAK MEMBALAS** (No-Reply) ke nomor ini._";

                                    try {
                                        $response = Http::withHeaders([
                                            'Authorization' => $tokenFonnte,
                                        ])->post('https://api.fonnte.com/send', [
                                            'target' => $noHpSantri,
                                            'message' => $pesan,
                                            'delay' => '2',
                                        ]);

                                        if ($response->successful() && $response->json('status') == true) {
                                            $berhasil++;
                                        } else {
                                            $gagal++;
                                            $alasanTerakhir = $response->json('reason') ?? "Ditolak oleh Server Fonnte";
                                        }
                                    } catch (\Exception $e) {
                                        $gagal++;
                                        $alasanTerakhir = "Gagal koneksi internet ke Fonnte";
                                    }
                                } else {
                                    $gagal++;
                                    $alasanTerakhir = "Status bukan Unpaid";
                                }
                            }

                            if ($gagal > 0) {
                                Notification::make()
                                    ->title('Proses Selesai (Ada Kendala)')
                                    ->body("Sukses: $berhasil. Gagal/Dilewati: $gagal.\nInfo: $alasanTerakhir")
                                    ->warning()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Proses Broadcast Selesai')
                                    ->body("Berhasil terkirim ke $berhasil santri.")
                                    ->success()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfaqs::route('/'),
        ];
    }
}