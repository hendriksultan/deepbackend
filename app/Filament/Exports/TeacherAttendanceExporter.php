<?php

namespace App\Filament\Exports;

use App\Models\TeacherAttendance;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TeacherAttendanceExporter extends Exporter
{
    protected static ?string $model = TeacherAttendance::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')
                ->label('Tanggal'),
            ExportColumn::make('teacherProfile.user.name')
                ->label('Nama Guru'),
            ExportColumn::make('clock_in')
                ->label('Jam Masuk'),
            ExportColumn::make('clock_out')
                ->label('Jam Pulang'),
            ExportColumn::make('status')
                ->label('Status')
                ->state(fn(TeacherAttendance $record): string => match ($record->status) {
                    'present' => 'Hadir',
                    'sick' => 'Sakit',
                    'permit' => 'Izin',
                    'alpha' => 'Alpha',
                    default => $record->status,
                }),
            ExportColumn::make('note')
                ->label('Catatan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Data absensi guru berhasil diekspor. Ada ' . number_format($export->successful_rows) . ' baris data.';
    }
}
