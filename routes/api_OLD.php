<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AsatidzController;
use App\Http\Controllers\Api\SantriController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/asatidz', [AsatidzController::class, 'index']);
Route::get('/santri/dashboard/{booking_id}', [SantriController::class, 'dashboard']);
