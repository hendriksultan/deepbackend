<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Booking;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // =========================================================
    // Mencegat data sebelum form Edit ditampilkan
    // =========================================================
   protected function mutateFormDataBeforeFill(array $data): array
{
    if (isset($data['booking_id'])) {
        $booking = Booking::find($data['booking_id']);
        
        if ($booking) {
            $data['method_display'] = strtoupper($booking->method . ($booking->method == 'offline' ? ' (Home Visit)' : ''));
            $data['student_address_info'] = $booking->method == 'offline' ? $booking->student_address : '-';
            
            if ($booking->method === 'offline') {
                
                // Cari link otomatis dari kelompok
                $finalMapsLink = $booking->maps_link;
                if (empty($finalMapsLink) && !empty($booking->group_name)) {
                    $finalMapsLink = Booking::where('group_name', $booking->group_name)
                        ->where('teacher_profile_id', $booking->teacher_profile_id)
                        ->whereNotNull('maps_link')
                        ->value('maps_link'); 
                }

                $data['koordinat_display'] = $booking->latitude . ', ' . $booking->longitude;

                // ========================================================
                // SINKRONISASI LOGIKA PUBLIK: HITUNG BERDASARKAN KOORDINAT
                // ========================================================
                $jumlahPeserta = Booking::where('latitude', $booking->latitude)
                    ->where('longitude', $booking->longitude)
                    ->whereIn('status', ['active', 'verifying'])
                    ->count();
                    
                $jumlahPeserta = $jumlahPeserta > 0 ? $jumlahPeserta : 1;

                $data['map_info'] = [
                    'group_name' => $booking->group_name ?? 'Tanpa Nama',
                    'address'    => $booking->student_address ?? 'Alamat tidak tersedia',
                    'lat'        => $booking->latitude,
                    'lng'        => $booking->longitude,
                    'maps_link'  => $finalMapsLink,
                    'jumlah'     => $jumlahPeserta,
                ];
            }
        }
    }

    return $data;
}
}