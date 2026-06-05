<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LombaController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\LombaRequestController;
use App\Http\Controllers\Api\PremiumRequestController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\ArtikelController;


// Test route
Route::get('/test', function () {
    return response()->json(['status' => 'API berjalan!']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Lomba public routes
Route::get('/lombas',      [LombaController::class, 'index']);
Route::get('/lombas/{id}', [LombaController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/me',               [AuthController::class, 'me']);
    Route::put('/profile',          [AuthController::class, 'updateProfile']);
    Route::put('/profile/password', [AuthController::class, 'updatePassword']);

    Route::get('/bookmarks',             [BookmarkController::class, 'index']);
    Route::post('/bookmarks/{lomba_id}', [BookmarkController::class, 'toggle']);
    Route::get('/bookmarks/{lomba_id}',  [BookmarkController::class, 'check']);

    // Lomba request
    Route::post('/lomba-requests',           [LombaRequestController::class, 'store']);
    Route::get('/lomba-requests/milik-saya', [LombaRequestController::class, 'milikSaya']);

    // Premium request
    Route::post('/premium-requests',        [PremiumRequestController::class, 'store']);
    Route::get('/premium-requests/status',  [PremiumRequestController::class, 'statusSaya']);

    // Artikel
    Route::get('/artikels',      [ArtikelController::class, 'index']);
    Route::get('/artikels/{id}', [ArtikelController::class, 'show']);
    Route::post('/artikels',     [ArtikelController::class, 'store']);
    Route::post('/artikels/{id}', [ArtikelController::class, 'update']);
    Route::delete('/artikels/{id}', [ArtikelController::class, 'destroy']);

    // Notifikasi
    Route::get('/notifikasi',                [NotifikasiController::class, 'index']);
    Route::post('/notifikasi/baca-semua',    [NotifikasiController::class, 'bacaSemua']);
    Route::post('/notifikasi/{id}/baca',     [NotifikasiController::class, 'baca']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/lombas',         [AdminController::class, 'index']);
    Route::post('/lombas',        [AdminController::class, 'store']);
    Route::post('/lombas/{id}',   [AdminController::class, 'update']);
    Route::delete('/lombas/{id}', [AdminController::class, 'destroy']);

    Route::get('/lomba-requests',               [LombaRequestController::class, 'adminIndex']);
    Route::post('/lomba-requests/{id}/approve', [LombaRequestController::class, 'approve']);
    Route::post('/lomba-requests/{id}/reject',  [LombaRequestController::class, 'reject']);

    Route::get('/premium-requests',               [PremiumRequestController::class, 'adminIndex']);
    Route::post('/premium-requests/{id}/approve', [PremiumRequestController::class, 'approve']);
    Route::post('/premium-requests/{id}/reject',  [PremiumRequestController::class, 'reject']);
});