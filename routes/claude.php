<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonHangController;
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
// Module 4 — DonHang
// ──────────────────────────────────────────────────────
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/thanh-toan', [CheckoutController::class, 'datHang'])->name('checkout.place');

Route::get('/don-hang/thanh-cong/{ma}', [DonHangController::class, 'success'])->name('orders.success');

Route::middleware('auth')->group(function () {
    Route::get('/don-hang', [DonHangController::class, 'index'])->name('orders.index');
    Route::get('/don-hang/{ma}', [DonHangController::class, 'show'])->name('orders.show');
    Route::post('/don-hang/{ma}/huy', [DonHangController::class, 'huy'])->name('orders.cancel');
});

// ──────────────────────────────────────────────────────
// Module 6 — Admin
// ──────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Danh mục
    Route::get('/danh-muc', [\App\Http\Controllers\Admin\DanhMucController::class, 'index'])->name('categories.index');
    Route::post('/danh-muc', [\App\Http\Controllers\Admin\DanhMucController::class, 'store'])->name('categories.store');
    Route::put('/danh-muc/{id}', [\App\Http\Controllers\Admin\DanhMucController::class, 'update'])->name('categories.update');
    Route::patch('/danh-muc/{id}/trang-thai', [\App\Http\Controllers\Admin\DanhMucController::class, 'doiTrangThai'])->name('categories.toggle');
    Route::delete('/danh-muc/{id}', [\App\Http\Controllers\Admin\DanhMucController::class, 'destroy'])->name('categories.destroy');

    // Sản phẩm (phụ thuộc model SanPham của Codex)
    Route::get('/san-pham', [\App\Http\Controllers\Admin\SanPhamController::class, 'index'])->name('products.index');
    Route::get('/san-pham/them', [\App\Http\Controllers\Admin\SanPhamController::class, 'create'])->name('products.create');
    Route::post('/san-pham', [\App\Http\Controllers\Admin\SanPhamController::class, 'store'])->name('products.store');
    Route::get('/san-pham/{id}/sua', [\App\Http\Controllers\Admin\SanPhamController::class, 'edit'])->name('products.edit');
    Route::put('/san-pham/{id}', [\App\Http\Controllers\Admin\SanPhamController::class, 'update'])->name('products.update');
    Route::patch('/san-pham/{id}/trang-thai', [\App\Http\Controllers\Admin\SanPhamController::class, 'doiTrangThai'])->name('products.toggle');
    Route::delete('/san-pham/{id}', [\App\Http\Controllers\Admin\SanPhamController::class, 'destroy'])->name('products.destroy');

    // Đơn hàng
    Route::get('/don-hang', [\App\Http\Controllers\Admin\DonHangController::class, 'index'])->name('orders.index');
    Route::get('/don-hang/{id}', [\App\Http\Controllers\Admin\DonHangController::class, 'show'])->name('orders.show');
    Route::put('/don-hang/{id}/trang-thai', [\App\Http\Controllers\Admin\DonHangController::class, 'capNhatTrangThai'])->name('orders.status');

    // Tài khoản
    Route::get('/tai-khoan', [\App\Http\Controllers\Admin\TaiKhoanController::class, 'index'])->name('users.index');
    Route::put('/tai-khoan/{id}/trang-thai', [\App\Http\Controllers\Admin\TaiKhoanController::class, 'doiTrangThai'])->name('users.status');

    // Mã giảm giá
    Route::get('/ma-giam-gia', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'index'])->name('coupons.index');
    Route::post('/ma-giam-gia', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'store'])->name('coupons.store');
    Route::put('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'update'])->name('coupons.update');
    Route::delete('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'destroy'])->name('coupons.destroy');

    // Setup trưng bày
    Route::get('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'index'])->name('setups.index');
    Route::post('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'store'])->name('setups.store');
    Route::put('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'update'])->name('setups.update');
    Route::delete('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'destroy'])->name('setups.destroy');
});
