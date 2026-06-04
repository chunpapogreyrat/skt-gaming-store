<?php

use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  ENTRY POINT — KHÔNG CODE TRỰC TIẾP VÀO ĐÂY
//  Thêm route vào codex.php hoặc claude.php tương ứng
// ══════════════════════════════════════════════════════

// Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Codex routes (Module 1, 2, 5, 7) ──
require __DIR__ . '/codex.php';

// ── Claude routes (Module 3, 4, 6) ──
require __DIR__ . '/claude.php';
