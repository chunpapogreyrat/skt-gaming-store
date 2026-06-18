<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  ENTRY POINT — KHÔNG CODE TRỰC TIẾP VÀO ĐÂY
//  Thêm route vào site.php hoặc shop.php tương ứng
// ══════════════════════════════════════════════════════

// Trang chủ — hiển thị sản phẩm hot, sale, featured
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Nhóm route phần Khách & Trang tĩnh (Module 1, 2, 5, 7) ──
require __DIR__ . '/site.php';

// ── Nhóm route Giỏ hàng, Đơn hàng & Quản trị (Module 3, 4, 6) ──
require __DIR__ . '/shop.php';
