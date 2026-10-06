<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{User, Booking, Schedule, Infaq};
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage, DB};
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    private function ok($data = null, string $message = 'Berhasil')
    {
        return response()->json(['status' => 'success', 'message' => $message, 'data' => $data]);
    }

    private function profileData(User $user): array
    {
        $data = $user->only(['id', 'name', 'email', 'phone', 'birth_place', 'gender',
            'address', 'province', 'city', 'district', 'village', 'student_level', 'is_verified']);
        $data['birth_date'] = $user->birth_date?->format('Y-m-d');
        $data['photo_url'] = $user->profile_photo_path
            ? url(Storage::disk('public')->url($user->profile_photo_path)) : null;
        return $data;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email', 'password' => 'required|string',
            'device_name' => 'required|string|max:100',
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => 'Email atau password tidak sesuai.']);
        }
        if (!in_array($user->role, ['student', 'santri'], true) || !$user->is_verified) {
            return response()->json(['message' => 'Akun peserta belum diverifikasi atau tidak memiliki akses.'], 403);
        }
        $expires = now()->addDays(30);
        $token = $user->createToken($data['device_name'], ['student'], $expires);
        return $this->ok(['token' => $token->plainTextToken, 'token_type' => 'Bearer',
            'expires_at' => $expires->toIso8601String(), 'user' => $this->profileData($user)]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok(null, 'Berhasil keluar.');
    }

    public function profile(Request $request)
    {
        return $this->ok($this->profileData($request->user()));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'sometimes|nullable|string|max:20',
            'birth_place' => 'sometimes|nullable|string|max:100',
            'birth_date' => 'sometimes|nullable|date|before_or_equal:today',
            'gender' => 'sometimes|nullable|in:L,P',
            'address' => 'sometimes|nullable|string|max:2000',
            'province' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:255',
            'district' => 'sometimes|nullable|string|max:255',
            'village' => 'sometimes|nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        unset($data['photo']);
        if ($request->hasFile('photo')) {
            $data['profile_photo_path'] = $request->file('photo')->store('profile-photos', 'public');
        }
        $user->update($data);
        return $this->ok($this->profileData($user->fresh()), 'Profil diperbarui.');
    }

    public function password(Request $request)
    {
        $data = $request->validate(['current_password' => 'required|string',
            'password' => 'required|string|min:8|max:255|confirmed']);
        $user = $request->user();
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Password lama tidak sesuai.']);
        }
        DB::transaction(function () use ($user, $data) {
            $user->update(['password' => Hash::make($data['password'])]);
            $user->tokens()->delete();
        });
        return $this->ok(null, 'Password diubah. Silakan login kembali di semua perangkat mobile.');
    }

    private function bookingQuery(Request $request)
    {
        return Booking::where('user_id', $request->user()->id);
    }

    private function scheduleQuery(Request $request)
    {
        return Schedule::whereIn('booking_id', $this->bookingQuery($request)->select('id'));
    }

    private function bookingData(Booking $booking): array
    {
        return $booking->only(['id', 'student_name', 'program_type', 'method', 'group_name',
            'status', 'is_free']) + [
            'guru' => ['id' => $booking->teacher_profile_id,
                'name' => $booking->teacherProfile?->user?->name],
        ];
    }

    public function bookings(Request $request)
    {
        $items = $this->bookingQuery($request)->with('teacherProfile.user')->latest()->paginate(20);
        $items->through(fn ($booking) => $this->bookingData($booking));
        return $this->ok($items);
    }

    public function booking(Request $request, $id)
    {
        return $this->ok($this->bookingData($this->bookingQuery($request)
            ->with('teacherProfile.user')->findOrFail($id)));
    }

    public function schedules(Request $request)
    {
        $filters = $request->validate(['booking_id' => 'nullable|integer',
            'from' => 'nullable|date', 'to' => 'nullable|date|after_or_equal:from']);
        $query = $this->scheduleQuery($request);
        if (!empty($filters['booking_id'])) {
            $this->bookingQuery($request)->findOrFail($filters['booking_id']);
            $query->where('booking_id', $filters['booking_id']);
        }
        if (!empty($filters['from'])) $query->whereDate('start', '>=', $filters['from']);
        if (!empty($filters['to'])) $query->whereDate('start', '<=', $filters['to']);
        return $this->ok($query->select(['id', 'booking_id', 'title', 'start', 'end',
            'status', 'student_presence', 'teaching_note', 'meeting_link'])
            ->orderBy('start', 'desc')->paginate(20));
    }

    public function dashboard(Request $request)
    {
        $id = $request->user()->id;
        return $this->ok([
            'user' => $this->profileData($request->user()),
            'kelas_aktif' => $this->bookingQuery($request)->where('status', 'active')->count(),
            'total_hadir' => $this->scheduleQuery($request)->where('student_presence', 'present')->count(),
            'infaq_belum_lunas' => Infaq::where('user_id', $id)->whereIn('status', ['unpaid', 'rejected'])->sum('nominal'),
            'notifikasi_belum_dibaca' => $request->user()->unreadNotifications()->count(),
            'jadwal_terdekat' => $this->scheduleQuery($request)->where('start', '>=', now())
                ->where('status', 'pending')->orderBy('start')->limit(5)
                ->get(['id', 'booking_id', 'title', 'start', 'end', 'meeting_link']),
        ]);
    }

    private function infaqData(Infaq $infaq): array
    {
        return $infaq->only(['id', 'periode_bulan', 'nominal', 'status', 'catatan_admin', 'created_at']) + [
            'bukti_url' => $infaq->bukti_transfer
                ? url(Storage::disk('public')->url($infaq->bukti_transfer)) : null,
        ];
    }

    public function infaqs(Request $request)
    {
        $items = Infaq::where('user_id', $request->user()->id)->latest()->paginate(20);
        $items->through(fn ($item) => $this->infaqData($item));
        return $this->ok($items);
    }

    public function uploadInfaq(Request $request, $id)
    {
        $request->validate(['bukti_transfer' => 'required|image|mimes:jpeg,jpg,png|max:2048']);
        $item = DB::transaction(function () use ($request, $id) {
            $item = Infaq::where('user_id', $request->user()->id)->lockForUpdate()->findOrFail($id);
            if (!in_array($item->status, ['unpaid', 'rejected'], true)) {
                abort(409, 'Tagihan sudah diverifikasi atau sedang menunggu verifikasi.');
            }
            $path = $request->file('bukti_transfer')->store('bukti-infaq', 'public');
            try {
                $item->update(['bukti_transfer' => $path, 'status' => 'pending']);
                Notification::make()->title('Bukti Infaq Baru!')
                    ->body($request->user()->name . ' mengunggah bukti infaq periode ' . $item->periode_bulan . '.')
                    ->icon('heroicon-o-banknotes')->success()
                    ->sendToDatabase(User::where('role', 'admin')->get());
            } catch (\Throwable $e) {
                Storage::disk('public')->delete($path);
                throw $e;
            }
            return $item;
        });
        return $this->ok($this->infaqData($item), 'Bukti transfer menunggu verifikasi admin.');
    }

    public function notifications(Request $request)
    {
        return $this->ok($request->user()->notifications()->latest()->paginate(20));
    }

    public function readNotification(Request $request, $id)
    {
        $request->user()->notifications()->findOrFail($id)->markAsRead();
        return $this->ok(null, 'Notifikasi ditandai dibaca.');
    }
}
