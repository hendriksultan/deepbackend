<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Middleware\EnsureMobileStudent;

// API contoh lama tidak diaktifkan: dashboard booking belum memeriksa pemilik.
Route::prefix('v1')->group(function () {
    Route::post('login', [StudentController::class, 'login'])->middleware('throttle:5,1');
    Route::middleware(['auth:sanctum', EnsureMobileStudent::class, 'throttle:60,1'])
        ->group(function () {
            Route::post('logout', [StudentController::class, 'logout']);
            Route::get('me', [StudentController::class, 'profile']);
            Route::post('me', [StudentController::class, 'updateProfile']);
            Route::post('password', [StudentController::class, 'password'])->middleware('throttle:5,1');
            Route::get('dashboard', [StudentController::class, 'dashboard']);
            Route::get('bookings', [StudentController::class, 'bookings']);
            Route::get('bookings/{id}', [StudentController::class, 'booking'])->whereNumber('id');
            Route::get('schedules', [StudentController::class, 'schedules']);
            Route::get('infaqs', [StudentController::class, 'infaqs']);
            Route::post('infaqs/{id}/proof', [StudentController::class, 'uploadInfaq'])->whereNumber('id');
            Route::get('notifications', [StudentController::class, 'notifications']);
            Route::post('notifications/{id}/read', [StudentController::class, 'readNotification'])->whereUuid('id');
        });
});
