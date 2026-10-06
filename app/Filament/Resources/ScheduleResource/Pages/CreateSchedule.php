<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    // FUNGSI INI WAJIB ADA UNTUK FITUR BULK CREATE
    // Fungsi ini akan memecah 1 Form menjadi Banyak Baris Jadwal
    protected function handleRecordCreation(array $data): Model
    {
        // 1. Ambil data santri dari field 'booking_ids' yang baru
        $bookingIds = $data['booking_ids'] ?? [];

        // Cek jika user ternyata cuma pilih 1, ubah jadi array biar aman
        if (!is_array($bookingIds)) {
            $bookingIds = [$bookingIds];
        }

        // 2. [PENTING] Buang 'booking_ids' dari data agar MySQL tidak error (karena kolom ini tidak ada di tabel)
        unset($data['booking_ids']);

        $firstRecord = null;

        // 3. Lakukan Looping untuk setiap Santri yang dipilih
        foreach ($bookingIds as $bookingId) {

            // Gabungkan data asli dengan booking_id satuan
            $scheduleData = array_merge($data, [
                'booking_id' => $bookingId,
            ]);

            // Simpan ke Database
            $record = static::getModel()::create($scheduleData);

            // Simpan record pertama untuk keperluan redirect Filament
            if (! $firstRecord) {
                $firstRecord = $record;
            }
        }

        // Kembalikan satu record agar Filament tidak error
        return $firstRecord ?? static::getModel()::create($data);
    }

    // (Opsional) Langsung arahkan kembali ke halaman tabel setelah sukses membuat jadwal
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}