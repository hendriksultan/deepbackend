<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMobileStudent
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        // API mobile wajib menggunakan personal access token, bukan sesi browser.
        if (!$request->bearerToken() || !$user ||
            !($user->currentAccessToken() instanceof \Laravel\Sanctum\PersonalAccessToken)) {
            return response()->json(['message' => 'Token login diperlukan.'], 401);
        }
        if (!in_array($user->role, ['student', 'santri'], true) ||
            !$user->is_verified || !$user->tokenCan('student')) {
            return response()->json(['message' => 'Akses peserta tidak diizinkan.'], 403);
        }
        return $next($request);
    }
}
