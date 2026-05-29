<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LombaController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\ArtikelController;

// Test route
Route::get('/test', function () {
    return response()->json(['status' => 'API berjalan!']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Lomba public routes (tidak perlu login)
Route::get('/lombas',      [LombaController::class, 'index']);
Route::get('/lombas/{id}', [LombaController::class, 'show']);
// Artikel public routes
Route::apiResource('artikels', ArtikelController::class);

// Protected routes (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/me',               [AuthController::class, 'me']);
    Route::put('/profile',          [AuthController::class, 'updateProfile']);
    Route::put('/profile/password', [AuthController::class, 'updatePassword']);
    Route::get('/bookmarks',              [BookmarkController::class, 'index']);
    Route::post('/bookmarks/{lomba_id}',  [BookmarkController::class, 'toggle']);
    Route::get('/bookmarks/{lomba_id}',   [BookmarkController::class, 'check']);
});

// Admin routes (butuh login + role admin)
Route::middleware(['auth:sanctum', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/lombas',         [AdminController::class, 'index']);
    Route::post('/lombas',        [AdminController::class, 'store']);
    Route::put('/lombas/{id}',    [AdminController::class, 'update']);
    Route::delete('/lombas/{id}', [AdminController::class, 'destroy']);
});