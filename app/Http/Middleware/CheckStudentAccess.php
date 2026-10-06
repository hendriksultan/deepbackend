<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStudentAccess
{
  public function handle(Request $request, Closure $next): Response
  {
    $user = Auth::user();

    // 1. Jika belum login, lempar ke login
    if (!$user) {
      return redirect()->route('login');
    }

    // 2. [PERBAIKAN] Jika BUKAN student/santri (misal: admin, teacher), lempar ke panel Filament
    if (!in_array($user->role, ['student', 'santri'])) {
      return redirect('/admin');
    }

    // 3. Jika belum verified, logout & error
    if (!$user->is_verified) {
      Auth::logout();
      return redirect()->route('login')
        ->withErrors(['email' => 'Akun belum diverifikasi admin.']);
    }

    return $next($request);
  }
}