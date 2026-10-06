<?php

namespace App\Filament\Resources\TeacherApplicationResource\Pages;

use App\Filament\Resources\TeacherApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class EditTeacherApplication extends EditRecord
{
    protected static string $resource = TeacherApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // =========================================================================
    // [BARU] Fungsi ini akan berjalan otomatis SETELAH admin klik "Simpan"
    // =========================================================================
    protected function afterSave(): void
    {
        $pelamar = $this->record;

        // Mengecek apakah status benar-benar diubah (bukan cuma save data lain)
        if ($pelamar->wasChanged('status')) {
            $emailTujuan = $pelamar->email;
            $nama = $pelamar->name;
            $statusBaru = $pelamar->status;

            $subject = '';
            $pesanHTML = '';

            // Tentukan isi email berdasarkan status
            if ($statusBaru === 'accepted') {
                $subject = 'Selamat! Lamaran Anda Diterima 🎉';
                $pesanHTML = "
                    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                        <h3>Assalamu'alaikum, {$nama}</h3>
                        <p>Alhamdulillah, kami sampaikan bahwa lamaran Anda sebagai pengajar di <strong>Deep Quran Academy</strong> telah <strong style='color: #16a34a;'>DITERIMA</strong>.</p>
                        <p>Tim HRD kami akan segera menghubungi Anda melalui WhatsApp untuk koordinasi tahap selanjutnya.</p>
                        <br>
                        <p>Barakallahu fiik,<br><strong>Tim Deep Quran Academy</strong></p>
                    </div>
                ";
            } elseif ($statusBaru === 'interview') {
                $subject = 'Panggilan Wawancara Deep Quran Academy 📝';
                $pesanHTML = "
                    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                        <h3>Assalamu'alaikum, {$nama}</h3>
                        <p>Alhamdulillah, berkas lamaran Anda telah kami terima. Selanjutnya, kami ingin mengundang Anda untuk mengikuti tahap <strong style='color: #f59e0b;'>Wawancara & Test</strong>.</p>
                        <p>Proses wawancara ini memiliki dua opsi pelaksanaan, yaitu <strong>bertemu langsung (tatap muka)</strong> atau melalui <strong>sambungan telepon / Video Call</strong>.</p>
                        <p>Tim kami akan segera menghubungi Anda via WhatsApp untuk berdiskusi mengenai jadwal serta opsi pelaksanaan mana yang paling memungkinkan untuk Anda.</p>
                        <br>
                        <p>Barakallahu fiik,<br><strong>Tim Deep Quran Academy</strong></p>
                    </div>
                ";
            } elseif ($statusBaru === 'rejected') {
                $subject = 'Hasil Seleksi Pengajar Deep Quran Academy';
                $pesanHTML = "
                    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                        <h3>Assalamu'alaikum, {$nama}</h3>
                        <p>Terima kasih atas ketertarikan Anda untuk bergabung dengan <strong>Deep Quran Academy</strong>.</p>
                        <p>Mohon maaf, setelah melalui proses seleksi, saat ini kami <strong style='color: #dc2626;'>belum bisa</strong> menerima Anda untuk bergabung bersama tim pengajar kami.</p>
                        <p>Tetap semangat dan semoga Allah mudahkan rezeki serta karir Anda di tempat lain!</p>
                        <br>
                        <p>Wassalamu'alaikum,<br><strong>Tim Deep Quran Academy</strong></p>
                    </div>
                ";
            }

            // Eksekusi pengiriman email
            if ($subject && $pesanHTML) {
                try {
                    Mail::html($pesanHTML, function ($mail) use ($emailTujuan, $subject) {
                        $mail->to($emailTujuan)
                             ->subject($subject);
                    });

                    Notification::make()
                        ->title('Email Berhasil Dikirim!')
                        ->body("Pemberitahuan telah dikirim ke email pelamar.")
                        ->success()
                        ->send();

                } catch (\Exception $e) {
                    // Jika gagal, tampilkan pesan error aslinya agar mudah diperbaiki
                    Notification::make()
                        ->title('Status Berubah, Tapi Email Gagal Terkirim!')
                        ->body('Error SMTP: ' . $e->getMessage())
                        ->danger()
                        ->persistent() // Agar notif merah tidak otomatis hilang
                        ->send();
                }
            }
        }
    }
}