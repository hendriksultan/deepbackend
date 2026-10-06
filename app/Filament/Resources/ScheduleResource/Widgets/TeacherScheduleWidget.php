<?php

namespace App\Filament\Resources\ScheduleResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Filament\Actions\EditAction; 
use App\Models\Schedule;
use App\Filament\Resources\ScheduleResource;
use Filament\Forms;
use Illuminate\Support\HtmlString;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class TeacherScheduleWidget extends FullCalendarWidget
{
    protected int | string | array $columnSpan = 'full';

    public function fetchEvents(array $fetchInfo): array
    {
        $schedules = Schedule::query()
            ->with(['teacherProfile.user', 'booking'])
            ->where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get();

        $groupedSchedules = $schedules->groupBy(function ($item) {
            return $item->teacher_profile_id . '_' . 
                   $item->title . '_' . 
                   Carbon::parse($item->start)->format('Y-m-d H:i') . '_' . 
                   Carbon::parse($item->end)->format('Y-m-d H:i');
        });

        $events = [];
        $now = Carbon::now();

        foreach ($groupedSchedules as $group) {
            $first = $group->first(); 
            $studentCount = $group->count();
            
            $studentNames = $group->map(function ($s) {
                return $s->booking ? $s->booking->student_name : null;
            })->filter()->unique()->implode(', ');

            // ========================================================
            // PENGECEKAN STATUS SEDANG BERLANGSUNG (LIVE)
            // ========================================================
            $eventStart = Carbon::parse($first->start);
            $eventEnd = Carbon::parse($first->end);
            $isOngoing = $now->betweenIncluded($eventStart, $eventEnd);

            $titlePrefix = '';
            $eventColor = '#16a34a'; // Hijau
            $statusDesc = '';

            // Jika sedang berlangsung
            if ($isOngoing) {
                $titlePrefix = '[LIVE] '; 
                $eventColor = '#ef4444'; // Merah
                $statusDesc = "⚠️ STATUS: KELAS SEDANG BERLANGSUNG\n";
            }
            // ========================================================

            $title = $titlePrefix . $first->title . ' (' . $studentCount . ' Santri)';

            $descArray = [
                $statusDesc . "Kelompok: " . $first->title,
                "Pengajar: " . ($first->teacherProfile->user->name ?? 'Guru'),
                "Waktu: " . $eventStart->translatedFormat('d M Y') . ' • ' . $eventStart->format('H:i') . ' - ' . $eventEnd->format('H:i'),
                "Santri: " . ($studentNames ?: 'Tanpa Data')
            ];

            $events[] = [
                'id'    => $first->id, 
                'title' => $title,
                'start' => $first->start,
                'end'   => $first->end,
                'color' => $eventColor,
                // INJEKSI CLASS UNTUK ANIMASI CSS
                'classNames' => $isOngoing ? ['animate-live'] : [], 
                'extendedProps' => [
                    'description' => implode("\n", $descArray),
                    'group_ids'   => $group->pluck('id')->toArray(), 
                ],
            ];
        }

        return $events;
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Jadwal Massal')
                ->icon('heroicon-o-calendar-days')
                ->form(ScheduleResource::getFormSchema())
                ->using(function (array $data, string $model) {
                    $bookingIds = $data['booking_ids'] ?? [];
                    unset($data['booking_ids']); 

                    $firstRecord = null;
                    foreach ($bookingIds as $bookingId) {
                        $schedule = $model::create(array_merge($data, ['booking_id' => $bookingId]));
                        if (!$firstRecord) {
                            $firstRecord = $schedule; 
                        }
                    }
                    return $firstRecord ?? new $model;
                })
                ->successNotificationTitle('Jadwal massal berhasil dibuat!')
        ];
    }

    protected function modalActions(): array
    {
        return [
            // 1. TOMBOL: DUPLIKASI JADWAL
            Action::make('duplicateSchedule')
                ->label('Duplikasi')
                ->icon('heroicon-o-document-duplicate')
                ->color('success')
                ->fillForm(fn (?Schedule $record): array => [
                    'start' => $record ? Carbon::parse($record->start)->addWeek()->format('Y-m-d H:i:s') : null,
                    'end'   => $record ? Carbon::parse($record->end)->addWeek()->format('Y-m-d H:i:s') : null,
                ])
                ->form([
                    Forms\Components\DateTimePicker::make('start')
                        ->label('Waktu Mulai (Baru)')
                        ->required(),
                    Forms\Components\DateTimePicker::make('end')
                        ->label('Waktu Selesai (Baru)')
                        ->required()
                        ->after('start'),
                ])
                ->action(function (array $data, ?Schedule $record) {
                    if (!$record) return;

                    $groupSchedules = Schedule::where('teacher_profile_id', $record->teacher_profile_id)
                        ->where('title', $record->title)
                        ->where('start', $record->start)
                        ->where('end', $record->end)
                        ->get();

                    foreach ($groupSchedules as $schedule) {
                        $newSchedule = $schedule->replicate(); 
                        $newSchedule->start = $data['start'];
                        $newSchedule->end   = $data['end'];
                        $newSchedule->save();
                    }

                    $this->dispatch('filament-fullcalendar--refresh');

                    Notification::make()
                        ->title('Jadwal Berhasil Diduplikasi!')
                        ->body('Seluruh santri pada kelompok ini telah disalin ke waktu yang baru.')
                        ->success()
                        ->send();
                }),

            // 2. TOMBOL: UBAH WAKTU MASSAL
            Action::make('updateTime')
                ->label('Ubah Waktu')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->fillForm(fn (?Schedule $record): array => [
                    'start' => $record?->start,
                    'end' => $record?->end,
                ])
                ->form([
                    Forms\Components\DateTimePicker::make('start')
                        ->label('Waktu Mulai')
                        ->required(),
                    Forms\Components\DateTimePicker::make('end')
                        ->label('Waktu Selesai')
                        ->required()
                        ->after('start'),
                ])
                ->action(function (array $data, ?Schedule $record) {
                    if (!$record) return;

                    Schedule::where('teacher_profile_id', $record->teacher_profile_id)
                        ->where('title', $record->title)
                        ->where('start', $record->start)
                        ->where('end', $record->end)
                        ->update([
                            'start' => $data['start'],
                            'end'   => $data['end'],
                        ]);

                    $this->dispatch('filament-fullcalendar--refresh');

                    Notification::make()
                        ->title('Waktu Diperbarui')
                        ->body('Waktu pelaksanaan berhasil diubah untuk seluruh santri di kelompok ini.')
                        ->success()
                        ->send();
                }),

            // 3. TOMBOL: UBAH LINK ZOOM
            Action::make('updateMeetingLink')
                ->label('Ubah Link Zoom')
                ->icon('heroicon-o-video-camera')
                ->color('info')
                ->visible(function (?Schedule $record) {
                    return $record?->booking?->method === 'online';
                })
                ->fillForm(fn (?Schedule $record): array => [
                    'meeting_link' => $record?->meeting_link,
                ])
                ->form([
                    Forms\Components\TextInput::make('meeting_link')
                        ->label('Masukkan Link Meeting (Zoom/GMeet)')
                        ->placeholder('https://zoom.us/j/...')
                        ->url()
                        ->required()
                ])
                ->action(function (array $data, ?Schedule $record) {
                    if (!$record) return;

                    Schedule::where('teacher_profile_id', $record->teacher_profile_id)
                        ->where('title', $record->title)
                        ->where('start', $record->start)
                        ->where('end', $record->end)
                        ->update([
                            'meeting_link' => $data['meeting_link']
                        ]);

                    $this->dispatch('filament-fullcalendar--refresh');

                    Notification::make()
                        ->title('Link Diperbarui')
                        ->body('Link meeting berhasil diubah untuk seluruh santri di kelompok ini.')
                        ->success()
                        ->send();
                }),

            // 4. TOMBOL: HAPUS JADWAL MASSAL
            Action::make('deleteSchedule')
                ->label('Hapus Jadwal')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation() 
                ->modalHeading('Hapus Jadwal Kelompok')
                ->modalDescription('Apakah Anda yakin ingin menghapus jadwal ini untuk SELURUH santri di kelompok ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->action(function (?Schedule $record) {
                    if (!$record) return;

                    // Ambil URL halaman saat ini untuk reload nanti
                    $currentUrl = request()->header('Referer');

                    // Hapus semua jadwal dengan kriteria kelompok dan waktu yang sama
                    Schedule::where('teacher_profile_id', $record->teacher_profile_id)
                        ->where('title', $record->title)
                        ->where('start', $record->start)
                        ->where('end', $record->end)
                        ->delete();

                    // Siapkan notifikasi
                    Notification::make()
                        ->title('Jadwal Berhasil Dihapus')
                        ->body('Jadwal untuk seluruh santri pada kelompok ini telah dihapus.')
                        ->success()
                        ->send();

                    // Lakukan Redirect (otomatis reload) agar tidak terjadi error 404 Not Found
                    return redirect($currentUrl);
                }),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\Placeholder::make('teacher')
                        ->label('Guru Pengajar')
                        ->content(fn (?Schedule $record) => $record?->teacherProfile?->user?->name ?? '-'),

                    Forms\Components\Placeholder::make('time')
                        ->label('Waktu Pelaksanaan')
                        ->content(function (?Schedule $record) {
                            if (!$record || !$record->start || !$record->end) return '-';
                            
                            $date = Carbon::parse($record->start)->translatedFormat('l, d F Y');
                            $time = Carbon::parse($record->start)->format('H:i') . ' - ' . Carbon::parse($record->end)->format('H:i') . ' WIB';
                            
                            return new HtmlString("
                                <div class='flex flex-col gap-0.5'>
                                    <span class='font-medium text-gray-900 dark:text-white'>{$date}</span>
                                    <span class='text-primary-600 dark:text-primary-400 font-bold'>{$time}</span>
                                </div>
                            ");
                        }),
                ]),

            Forms\Components\Placeholder::make('meeting_link_display')
                ->label('Tautan Meeting')
                ->visible(fn (?Schedule $record) => $record?->booking?->method === 'online')
                ->content(function (?Schedule $record) {
                    if (!$record || empty($record->meeting_link)) {
                        return new HtmlString('<span class="text-gray-500 italic text-sm">Belum ada tautan/link meeting disematkan. Klik tombol "Ubah Link Zoom" di bawah untuk mengatur.</span>');
                    }
                    return new HtmlString("<a href='{$record->meeting_link}' target='_blank' class='text-primary-600 dark:text-primary-400 font-bold underline hover:text-primary-500 flex items-center gap-1'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='w-5 h-5'>
                            <path d='M4.5 4.5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h8.25a3 3 0 0 0 3-3v-9a3 3 0 0 0-3-3H4.5ZM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06Z' />
                        </svg>
                        Buka Ruang Belajar (Zoom/Gmeet)
                    </a>");
                }),

            Forms\Components\Placeholder::make('students')
                ->label('Daftar Santri di Kelompok Ini')
                ->content(function (?Schedule $record) {
                    if (!$record) return new HtmlString('-');

                    $groupSchedules = Schedule::with('booking')
                        ->where('teacher_profile_id', $record->teacher_profile_id)
                        ->where('title', $record->title)
                        ->where('start', $record->start)
                        ->where('end', $record->end)
                        ->get();

                    $names = $groupSchedules->map(function($s) {
                        if (!$s->booking) return null;
                        
                        return "
                            <div class='flex items-center gap-2 mb-1'>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='w-5 h-5 text-success-500'>
                                    <path fill-rule='evenodd' d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z' clip-rule='evenodd' />
                                </svg>
                                <span class='text-gray-700 dark:text-gray-300'>{$s->booking->student_name}</span>
                            </div>
                        ";
                    })->filter()->implode('');

                    return new HtmlString($names ?: '-');
                }),
        ];
    }

    public function config(): array
    {
        return [
            'eventDidMount' => <<<'JS'
                function({ event, el }) {
                    // 1. Tooltip / Keterangan Event
                    var content = event.extendedProps.description;
                    if (content) {
                        el.setAttribute("title", content);
                        var safeContent = content.replace(/\n/g, '<br/>').replace(/'/g, "\\'");
                        el.setAttribute("x-tooltip", "{ content: '" + safeContent + "', theme: 'light', allowHTML: true }");
                        el.setAttribute("x-data", "{}");
                        if (window.Alpine) window.Alpine.initTree(el);
                    }

                    // 2. Suntik CSS Animasi Box-Shadow (hanya di-load 1 kali)
                    if (!document.getElementById('fc-live-pulse-style')) {
                        const style = document.createElement('style');
                        style.id = 'fc-live-pulse-style';
                        style.innerHTML = `
                            @keyframes live-pulse {
                                0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.8); }
                                70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
                                100% { box-shadow: 0 0 0 0 transparent; }
                            }
                            
                            /* Animasi hanya berjalan pada event yang memiliki class 'animate-live' */
                            .animate-live .fc-daygrid-event-dot,
                            .animate-live .fc-list-event-dot {
                                animation: live-pulse 1.5s infinite cubic-bezier(0.4, 0, 0.2, 1);
                                border-color: #ef4444 !important;
                                background-color: #ef4444 !important;
                            }
                            
                            /* Opsional jika menggunakan view timeGrid */
                            .animate-live.fc-timegrid-event {
                                animation: live-pulse 1.5s infinite cubic-bezier(0.4, 0, 0.2, 1);
                            }
                        `;
                        document.head.appendChild(style);
                    }
                }
            JS,
        ];
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        $groupIds = $event['extendedProps']['group_ids'] ?? [];

        if (!empty($groupIds)) {
            $start = \Carbon\Carbon::parse($event['start'])->toDateTimeString();

            if (isset($event['end'])) {
                $end = \Carbon\Carbon::parse($event['end'])->toDateTimeString();
            } else {
                $oldStart = \Carbon\Carbon::parse($oldEvent['start']);
                $oldEndString = $oldEvent['end'] ?? $oldEvent['start']; 
                $oldEnd = \Carbon\Carbon::parse($oldEndString);
                
                $durationInMinutes = $oldStart->diffInMinutes($oldEnd);
                $end = \Carbon\Carbon::parse($start)->addMinutes($durationInMinutes)->toDateTimeString();
            }

            Schedule::whereIn('id', $groupIds)->update([
                'start' => $start,
                'end'   => $end,
            ]);
            
            $this->dispatch('filament-fullcalendar--refresh');
            
            return true;
        }

        return false;
    }

    public function getModel(): string
    {
        return Schedule::class;
    }
}