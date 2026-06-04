<?php

use App\Http\Controllers\GioHangController;
use App\Http\Controllers\MaGiamGiaController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  CLAUDE — Module 3: GioHang  |  Module 4: DonHang
//            Module 6: Admin
// ══════════════════════════════════════════════════════

// ──────────────────────────────────────────────────────
// Module 3 — GioHang
// ──────────────────────────────────────────────────────
Route::get('/gio-hang', [GioHangController::class, 'index'])->name('cart.index');
Route::post('/gio-hang', [GioHangController::class, 'them'])->name('cart.add');
Route::patch('/gio-hang/{itemId}', [GioHangController::class, 'capNhat'])->name('cart.update');
Route::delete('/gio-hang/{itemId}', [GioHangController::class, 'xoa'])->name('cart.remove');
Route::delete('/gio-hang', [GioHangController::class, 'xoaTatCa'])->name('cart.clear');
Route::get('/gio-hang/count', [GioHangController::class, 'demSoLuong'])->name('cart.count');

Route::post('/gio-hang/coupon', [MaGiamGiaController::class, 'apDung'])->name('coupon.apply');
Route::delete('/gio-hang/coupon', [MaGiamGiaController::class, 'huy'])->name('coupon.remove');

// ──────────────────────────────────────────────────────
// Module 4 — DonHang (sẽ thêm)
// ──────────────────────────────────────────────────────

// ──────────────────────────────────────────────────────
// Module 6 — Admin (sẽ thêm)
// ──────────────────────────────────────────────────────
