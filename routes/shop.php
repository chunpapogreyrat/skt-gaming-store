<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\MaGiamGiaController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  SHOP — Module 3: GioHang  |  Module 4: DonHang
//         Module 6: Admin
//  Mỗi dòng route kèm comment công dụng để dễ tra cứu.
// ══════════════════════════════════════════════════════

// ──────────────────────────────────────────────────────
// Module 3 — Giỏ hàng
// ──────────────────────────────────────────────────────
// Trang xem giỏ hàng đầy đủ.
Route::get('/gio-hang', [GioHangController::class, 'index'])->name('cart.index');
// Thêm sản phẩm vào giỏ (kèm màu + số lượng) — trả JSON.
Route::post('/gio-hang', [GioHangController::class, 'them'])->name('cart.add');
// Cập nhật số lượng 1 dòng trong giỏ — trả JSON.
Route::patch('/gio-hang/{itemId}', [GioHangController::class, 'capNhat'])->name('cart.update');
// Xóa 1 sản phẩm khỏi giỏ — trả JSON.
Route::delete('/gio-hang/{itemId}', [GioHangController::class, 'xoa'])->name('cart.remove');
// Xóa toàn bộ giỏ hàng.
Route::delete('/gio-hang', [GioHangController::class, 'xoaTatCa'])->name('cart.clear');
// Đếm số lượng món trong giỏ (cập nhật badge ở header).
Route::get('/gio-hang/count', [GioHangController::class, 'demSoLuong'])->name('cart.count');

// Áp mã giảm giá vào giỏ.
Route::post('/gio-hang/coupon', [MaGiamGiaController::class, 'apDung'])->name('coupon.apply');
// Gỡ mã giảm giá đang áp.
Route::delete('/gio-hang/coupon', [MaGiamGiaController::class, 'huy'])->name('coupon.remove');

// ──────────────────────────────────────────────────────
// Module 4 — Đơn hàng & Thanh toán
// ──────────────────────────────────────────────────────
// Trang thanh toán (nhập thông tin nhận hàng + chọn phương thức).
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
// Đặt hàng: tạo đơn từ giỏ + trừ kho + gửi mail xác nhận.
Route::post('/thanh-toan', [CheckoutController::class, 'datHang'])->name('checkout.place');

// MoMo trả về trình duyệt sau khi thanh toán (redirect khách).
Route::get('/thanh-toan/momo/return', [CheckoutController::class, 'momoReturn'])->name('momo.return');
// MoMo gọi server-to-server xác nhận kết quả thanh toán (IPN).
Route::post('/thanh-toan/momo/ipn', [CheckoutController::class, 'momoIpn'])->name('momo.ipn');

// Trang "Đặt hàng thành công" (theo mã đơn).
Route::get('/don-hang/thanh-cong/{ma}', [DonHangController::class, 'success'])->name('orders.success');

Route::middleware('auth')->group(function () {
    // Danh sách đơn hàng của tài khoản đang đăng nhập.
    Route::get('/don-hang', [DonHangController::class, 'index'])->name('orders.index');
    // Chi tiết 1 đơn hàng (theo mã đơn).
    Route::get('/don-hang/{ma}', [DonHangController::class, 'show'])->name('orders.show');
    // Khách tự hủy đơn (khi đơn còn cho phép hủy) → hoàn kho.
    Route::post('/don-hang/{ma}/huy', [DonHangController::class, 'huy'])->name('orders.cancel');
});

// ──────────────────────────────────────────────────────
// Module 6 — Quản trị (prefix /admin, chỉ admin truy cập)
// ──────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    // Trang tổng quan: số liệu thống kê nhanh.
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Báo cáo doanh thu (biểu đồ theo thời gian) — M8.
    Route::get('/doanh-thu', [\App\Http\Controllers\Admin\DoanhThuController::class, 'index'])->name('revenue');

    // ── Quản lý danh mục ──
    Route::get('/danh-muc', [\App\Http\Controllers\Admin\DanhMucController::class, 'index'])->name('categories.index');          // Danh sách danh mục
    Route::post('/danh-muc', [\App\Http\Controllers\Admin\DanhMucController::class, 'store'])->name('categories.store');          // Thêm danh mục
    Route::put('/danh-muc/{id}', [\App\Http\Controllers\Admin\DanhMucController::class, 'update'])->name('categories.update');    // Sửa danh mục
    Route::patch('/danh-muc/{id}/trang-thai', [\App\Http\Controllers\Admin\DanhMucController::class, 'doiTrangThai'])->name('categories.toggle'); // Ẩn/hiện danh mục
    Route::delete('/danh-muc/{id}', [\App\Http\Controllers\Admin\DanhMucController::class, 'destroy'])->name('categories.destroy'); // Xóa danh mục

    // ── Quản lý sản phẩm (gồm cả biến thể màu) ──
    Route::get('/san-pham', [\App\Http\Controllers\Admin\SanPhamController::class, 'index'])->name('products.index');             // Danh sách sản phẩm
    Route::get('/san-pham/them', [\App\Http\Controllers\Admin\SanPhamController::class, 'create'])->name('products.create');       // Form thêm sản phẩm
    Route::post('/san-pham', [\App\Http\Controllers\Admin\SanPhamController::class, 'store'])->name('products.store');             // Lưu sản phẩm mới
    Route::get('/san-pham/{id}/sua', [\App\Http\Controllers\Admin\SanPhamController::class, 'edit'])->name('products.edit');       // Form sửa sản phẩm
    Route::put('/san-pham/{id}', [\App\Http\Controllers\Admin\SanPhamController::class, 'update'])->name('products.update');       // Cập nhật sản phẩm
    Route::patch('/san-pham/{id}/trang-thai', [\App\Http\Controllers\Admin\SanPhamController::class, 'doiTrangThai'])->name('products.toggle'); // Ẩn/hiện sản phẩm
    Route::delete('/san-pham/{id}', [\App\Http\Controllers\Admin\SanPhamController::class, 'destroy'])->name('products.destroy');  // Xóa sản phẩm

    // ── Quản lý đơn hàng ──
    Route::get('/don-hang', [\App\Http\Controllers\Admin\DonHangController::class, 'index'])->name('orders.index');               // Danh sách đơn
    Route::get('/don-hang/{id}', [\App\Http\Controllers\Admin\DonHangController::class, 'show'])->name('orders.show');             // Chi tiết đơn
    Route::put('/don-hang/{id}/trang-thai', [\App\Http\Controllers\Admin\DonHangController::class, 'capNhatTrangThai'])->name('orders.status'); // Đổi trạng thái đơn

    // ── Quản lý tài khoản ──
    Route::get('/tai-khoan', [\App\Http\Controllers\Admin\TaiKhoanController::class, 'index'])->name('users.index');              // Danh sách tài khoản
    Route::put('/tai-khoan/{id}/trang-thai', [\App\Http\Controllers\Admin\TaiKhoanController::class, 'doiTrangThai'])->name('users.status'); // Khóa/mở tài khoản

    // ── Quản lý mã giảm giá ──
    Route::get('/ma-giam-gia', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'index'])->name('coupons.index');         // Danh sách mã
    Route::get('/ma-giam-gia/them', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'create'])->name('coupons.create');   // Form thêm mã
    Route::post('/ma-giam-gia', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'store'])->name('coupons.store');         // Lưu mã mới
    Route::get('/ma-giam-gia/{id}/sua', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'edit'])->name('coupons.edit');   // Form sửa mã
    Route::put('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'update'])->name('coupons.update');   // Cập nhật mã
    Route::patch('/ma-giam-gia/{id}/trang-thai', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'toggle'])->name('coupons.toggle'); // Bật/tắt mã
    Route::delete('/ma-giam-gia/{id}', [\App\Http\Controllers\Admin\MaGiamGiaController::class, 'destroy'])->name('coupons.destroy'); // Xóa mã

    // ── Hộp thư liên hệ khách gửi (M9) ──
    Route::get('/lien-he', [\App\Http\Controllers\Admin\LienHeController::class, 'index'])->name('contacts.index');               // Danh sách liên hệ
    Route::patch('/lien-he/{id}/xu-ly', [\App\Http\Controllers\Admin\LienHeController::class, 'toggle'])->name('contacts.toggle'); // Đánh dấu đã/chưa xử lý
    Route::delete('/lien-he/{id}', [\App\Http\Controllers\Admin\LienHeController::class, 'destroy'])->name('contacts.destroy');    // Xóa liên hệ

    // ── Quản lý nhà phân phối (M7) ──
    Route::get('/nha-phan-phoi', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'index'])->name('suppliers.index');   // Danh sách NPP
    Route::post('/nha-phan-phoi', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'store'])->name('suppliers.store');   // Thêm NPP
    Route::put('/nha-phan-phoi/{id}', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'update'])->name('suppliers.update'); // Sửa NPP
    Route::delete('/nha-phan-phoi/{id}', [\App\Http\Controllers\Admin\NhaPhanPhoiController::class, 'destroy'])->name('suppliers.destroy'); // Xóa NPP

    // ── Quản lý setup trưng bày trang chủ ──
    Route::get('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'index'])->name('setups.index');                    // Danh sách setup
    Route::post('/setup', [\App\Http\Controllers\Admin\SetupController::class, 'store'])->name('setups.store');                   // Thêm setup
    Route::put('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'update'])->name('setups.update');             // Sửa setup
    Route::delete('/setup/{id}', [\App\Http\Controllers\Admin\SetupController::class, 'destroy'])->name('setups.destroy');         // Xóa setup
});
