<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  ENTRY POINT — KHÔNG CODE TRỰC TIẾP VÀO ĐÂY
//  Thêm route vào codex.php hoặc claude.php tương ứng
// ══════════════════════════════════════════════════════

// Trang chủ — hiển thị sản phẩm hot, sale, featured
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Codex routes (Module 1, 2, 5, 7) ──
require __DIR__ . '/codex.php';

// ── Claude routes (Module 3, 4, 6) ──
require __DIR__ . '/claude.php';
