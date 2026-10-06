<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{StudyMaterial, User, QuranBookmark};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Validation\Rule;

class LearningController extends Controller
{
    private function ok($data, string $message = 'Berhasil')
    {
        return response()->json(['status' => 'success', 'message' => $message, 'data' => $data]);
    }

    private function materialsFor(Request $request)
    {
        // Match teacher, group and delivery method on the SAME active booking.
        return StudyMaterial::query()->where('is_active', true)->where(function ($q) use ($request) {
            $q->where(function ($global) {
                $global->whereNull('teacher_profile_id')->where('program_type', 'all')
                    ->where(fn ($g) => $g->whereNull('group_name')->orWhere('group_name', ''));
            })->orWhereExists(function ($booking) use ($request) {
                $booking->selectRaw('1')->from('bookings')->where('bookings.user_id', $request->user()->id)
                    ->where('bookings.status', 'active')
                    ->where(fn ($m) => $m->where('study_materials.program_type', 'all')->orWhereColumn('bookings.method', 'study_materials.program_type'))
                    ->where(fn ($t) => $t->whereNull('study_materials.teacher_profile_id')->orWhereColumn('bookings.teacher_profile_id', 'study_materials.teacher_profile_id'))
                    ->where(fn ($g) => $g->whereNull('study_materials.group_name')->orWhere('study_materials.group_name', '')->orWhereColumn('bookings.group_name', 'study_materials.group_name'));
            });
        });
    }

    public function materials(Request $request)
    {
        $items = $this->materialsFor($request)->with('teacherProfile.user:id,name')
            ->withExists(['completedByUsers as completed' => fn ($q) => $q->where('users.id', $request->user()->id)])
            ->latest()->paginate(20);
        $items->through(fn ($m) => [
            'id' => $m->id, 'title' => $m->title,
            'description' => trim(strip_tags(html_entity_decode($m->description ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'))),
            'type' => $m->type, 'method' => $m->program_type,
            'teacher_name' => $m->teacherProfile?->user?->name,
            'group_name' => $m->group_name, 'completed' => (bool) $m->completed,
            'file_url' => $m->file_path ? url(Storage::disk('public')->url($m->file_path)) : null,
            'video_url' => $m->video_url,
        ]);
        return $this->ok($items);
    }

    public function completeMaterial(Request $request, int $id)
    {
        $material = $this->materialsFor($request)->findOrFail($id);
        DB::transaction(function () use ($request, $material) {
            User::whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
            $query = DB::table('study_material_user')->where('user_id', $request->user()->id)->where('study_material_id', $material->id);
            if (!$query->exists()) DB::table('study_material_user')->insert([
                'user_id' => $request->user()->id, 'study_material_id' => $material->id,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        });
        return $this->ok(['id' => $material->id, 'completed' => true], 'Materi ditandai telah dipelajari.');
    }

    public function progress(Request $request)
    {
        return $this->ok([
            'student_program' => $request->user()->student_level,
            'completed' => DB::table('self_study_progress')->where('user_id', $request->user()->id)->pluck('lesson_key'),
        ]);
    }

    public function saveProgress(Request $request)
    {
        // Practice completion only; this never changes an official level or grade.
        $data = $request->validate([
            'lesson_ids' => 'required|array|max:50',
            'lesson_ids.*' => ['required', 'string', 'distinct', Rule::in(config('self_study.lessons'))],
        ]);
        $rows = array_map(fn ($key) => [
            'user_id' => $request->user()->id, 'lesson_key' => $key,
            'created_at' => now(), 'updated_at' => now(),
        ], $data['lesson_ids']);
        if ($rows) DB::table('self_study_progress')->upsert($rows, ['user_id', 'lesson_key'], ['updated_at']);
        return $this->progress($request);
    }

    public function bookmark(Request $request)
    {
        $item = QuranBookmark::where('user_id', $request->user()->id)->orderByDesc('updated_at')->orderByDesc('id')->first();
        return $this->ok($item ? ['surat_nomor' => (int) $item->surat_nomor, 'ayat_nomor' => (int) $item->ayat_nomor] : null);
    }

    public function saveBookmark(Request $request)
    {
        $data = $request->validate(['surat_nomor' => 'required|integer|min:1|max:114', 'ayat_nomor' => 'required|integer|min:1|max:286']);
        $data = array_map('intval', $data);
        $counts = config('self_study.verse_counts');
        if ($data['ayat_nomor'] > $counts[$data['surat_nomor'] - 1]) {
            return response()->json(['message' => 'Nomor ayat melebihi jumlah ayat surah.'], 422);
        }
        // Preserve other web bookmarks. The most recently updated one is resumed.
        QuranBookmark::upsert([[
            'user_id' => $request->user()->id, ...$data,
            'created_at' => now(), 'updated_at' => now(),
        ]], ['user_id', 'surat_nomor', 'ayat_nomor'], ['updated_at']);
        return $this->ok($data, 'Penanda bacaan tersimpan di server.');
    }
}
