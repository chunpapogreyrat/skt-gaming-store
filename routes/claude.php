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

// MoMo callback: return (browser redirect) + ipn (server-to-server)
Route::get('/thanh-toan/momo/return', [CheckoutController::class, 'momoReturn'])->name('momo.return');
Route::post('/thanh-toan/momo/ipn', [CheckoutController::class, 'momoIpn'])->name('momo.ipn');

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

    // Doanh thu (M8)
    Route::get('/doanh-thu', [\App\Http\Controllers\Admin\DoanhThuController::class, 'index'])->name('revenue');

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
    Route::get('/ma-giam-gia/them', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'create'])->name('coupons.create');
    Route::post('/ma-giam-gia', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'store'])->name('coupons.store');
    Route::get('/ma-giam-gia/{id}/sua', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'edit'])->name('coupons.edit');
    Route::put('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'update'])->name('coupons.update');
    Route::patch('/ma-giam-gia/{id}/trang-thai', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'toggle'])->name('coupons.toggle');
    Route::delete('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'destroy'])->name('coupons.destroy');

    // Liên hệ khách gửi (M9)
    Route::get('/lien-he', [\App\Http\Controllers\Admin\LienHeController::class, 'index'])->name('contacts.index');
    Route::patch('/lien-he/{id}/xu-ly', [\App\Http\Controllers\Admin\LienHeController::class, 'toggle'])->name('contacts.toggle');
    Route::delete('/lien-he/{id}', [\App\Http\Controllers\Admin\LienHeController::class, 'destroy'])->name('contacts.destroy');

    // Nhà phân phối (M7)
    Route::get('/nha-phan-phoi', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'index'])->name('suppliers.index');
    Route::post('/nha-phan-phoi', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'store'])->name('suppliers.store');
    Route::put('/nha-phan-phoi/{id}', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'update'])->name('suppliers.update');
    Route::delete('/nha-phan-phoi/{id}', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'destroy'])->name('suppliers.destroy');

    // Setup trưng bày
    Route::get('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'index'])->name('setups.index');
    Route::post('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'store'])->name('setups.store');
    Route::put('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'update'])->name('setups.update');
    Route::delete('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'destroy'])->name('setups.destroy');
});
