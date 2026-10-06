<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// --- LIBRARY WAJIB UNTUK INTERCEPT ERROR ---
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(\App\Http\Middleware\MeasureLocalApi::class);

        // 🔥 WAJIB untuk Cloudflare Tunnel
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'student.check' => \App\Http\Middleware\CheckStudentAccess::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            $user = Auth::user();

            // Jika belum login, cek dia mau akses halaman mana untuk diarahkan ke login yang pas
            if (!$user) {
                if ($request->is('admin') || $request->is('admin/*')) return '/admin/login';
                if ($request->is('teacher') || $request->is('teacher/*')) return '/teacher/login';
                return '/login'; // Default Santri
            }

            // Jika sudah login, arahkan ke dashboard masing-masing
            if ($user->role === 'admin') return '/admin';
            if ($user->role === 'teacher') return '/teacher';
            return route('student.dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(fn (Request $request, \Throwable $e) =>
            $request->is('api/*') || $request->expectsJson());
        
        // =========================================================================
        // RADAR URL: Mendeteksi pintu login mana yang harus dituju
        // =========================================================================
        $getLoginUrl = function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return '/admin/login';
            }
            if ($request->is('teacher') || $request->is('teacher/*')) {
                return '/teacher/login';
            }
            return '/login'; // URL login Santri
        };

        // =========================================================================
        // FUNGSI PINTAR: Mengembalikan user yang "Salah Kamar" ke tempat asalnya
        // =========================================================================
        $handleForbidden = function ($e, Request $request) use ($getLoginUrl) {
            // 1. Jika masih login tapi salah akses URL (misal: Admin iseng buka URL /teacher)
            if (Auth::check()) {
                $role = Auth::user()->role;
                if ($role === 'admin') return redirect('/admin');
                if ($role === 'teacher') return redirect('/teacher');
                return redirect()->route('student.dashboard');
            }
            
            // 2. Jika sesi sudah kacau, bersihkan dan tendang ke login yang sesuai
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect($getLoginUrl($request));
        };

        // Menangkap Error 403 (Forbidden) dan 419 (Expired) dari HttpException
        $exceptions->render(function (HttpException $e, Request $request) use ($handleForbidden, $getLoginUrl) {
            if ($request->is('api/*') || $request->expectsJson()) return null;
            if ($e->getStatusCode() === 403) {
                return $handleForbidden($e, $request);
            }
            if ($e->getStatusCode() === 419) {
                return redirect($getLoginUrl($request));
            }
        });

        // Menangkap Tolakan Akses dari Kebijakan Filament (AuthorizationException)
        $exceptions->render(function (AuthorizationException $e, Request $request) use ($handleForbidden) {
            if ($request->is('api/*') || $request->expectsJson()) return null;
            return $handleForbidden($e, $request);
        });

        // Menangkap Sesi yang Kedaluwarsa karena lama ditutup (TokenMismatch)
        $exceptions->render(function (TokenMismatchException $e, Request $request) use ($getLoginUrl) {
            if ($request->is('api/*') || $request->expectsJson()) return null;
            return redirect($getLoginUrl($request));
        });

    })->create();