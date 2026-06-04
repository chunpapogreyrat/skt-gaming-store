<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  CODEX — Module 1: Auth  |  Module 2: SanPham
//           Module 5: NguoiDung  |  Module 7: Static
// ══════════════════════════════════════════════════════

// ──────────────────────────────────────────────────────
// Module 1 — Auth (khách chưa đăng nhập)
// ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    Route::get('/dang-nhap', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'login']);

    Route::get('/dang-ky', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky', [AuthController::class, 'register']);

    Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/quen-mat-khau', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/dat-lai-mat-khau/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/dat-lai-mat-khau', [ForgotPasswordController::class, 'reset'])->name('password.update');

});

Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
});

// ──────────────────────────────────────────────────────
// Module 2 — SanPham (Codex thêm vào đây)
// ──────────────────────────────────────────────────────

// ──────────────────────────────────────────────────────
// Module 5 — NguoiDung (Codex thêm vào đây)
// ──────────────────────────────────────────────────────

// ──────────────────────────────────────────────────────
// Module 7 — Static (Codex thêm vào đây)
// ──────────────────────────────────────────────────────
