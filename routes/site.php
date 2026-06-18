<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TrangTinhController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════
//  SITE — Module 1: Auth  |  Module 2: SanPham
//         Module 5: NguoiDung  |  Module 7: Static
//  Mỗi dòng route kèm comment công dụng để dễ tra cứu.
// ══════════════════════════════════════════════════════

// ── Module 2 — Sản phẩm (công khai, không cần đăng nhập) ──
// Trang danh sách sản phẩm: lọc theo danh mục/giá, tìm kiếm, sắp xếp, phân trang.
Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');
// Trang chi tiết 1 sản phẩm (tìm theo slug): ảnh, biến thể màu, thông số, đánh giá.
Route::get('/products/{sanPham:slug}', [SanPhamController::class, 'show'])->name('products.show');
// Trả về HTML sidebar danh mục (dùng cho AJAX/partial).
Route::get('/categories/sidebar', [DanhMucController::class, 'sidebar'])->name('categories.sidebar');

// ── Module 7 — Trang tĩnh ──
// Trang "Giới thiệu về chúng tôi".
Route::get('/gioi-thieu', [TrangTinhController::class, 'about'])->name('static.about');
// Trang "Liên hệ" (hiển thị form + thông tin shop).
Route::get('/lien-he', [TrangTinhController::class, 'contact'])->name('static.contact');
// Nhận dữ liệu form liên hệ khách gửi → lưu vào DB.
Route::post('/lien-he', [TrangTinhController::class, 'guiLienHe'])->name('static.contact.send');
// Trang gallery "Setups gaming" (trang tĩnh cũ).
Route::get('/setups', [TrangTinhController::class, 'setups'])->name('static.setups');
// Trang báo lỗi 404 (gọi trực tiếp khi cần).
Route::get('/404', [TrangTinhController::class, 'notFound'])->name('static.404');

// ── Blog "Góc game thủ" ──
// Trang danh sách bài viết: bài nổi bật, lọc theo danh mục, tìm kiếm, phân trang.
Route::get('/goc-game-thu', [BlogController::class, 'index'])->name('blog.index');
// Trang đọc 1 bài viết (theo slug): tăng lượt xem + gợi ý bài liên quan.
Route::get('/goc-game-thu/{baiViet:slug}', [BlogController::class, 'show'])->name('blog.show');

// ── Module 1 — Xác thực (chỉ cho khách CHƯA đăng nhập) ──
Route::middleware('guest.module')->group(function () {
    // Hiển thị trang đăng nhập.
    Route::get('/dang-nhap', [LoginController::class, 'showLogin'])->name('login');
    // Xử lý đăng nhập (kiểm tra email + mật khẩu, tạo phiên).
    Route::post('/dang-nhap', [LoginController::class, 'login']);

    // Hiển thị trang đăng ký tài khoản.
    Route::get('/dang-ky', [RegisterController::class, 'showRegister'])->name('register');
    // Xử lý đăng ký: validate + tạo tài khoản mới.
    Route::post('/dang-ky', [RegisterController::class, 'register']);

    // Hiển thị form "Quên mật khẩu".
    Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    // Gửi email chứa link đặt lại mật khẩu.
    Route::post('/quen-mat-khau', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    // Hiển thị form đặt lại mật khẩu (kèm token từ email).
    Route::get('/dat-lai-mat-khau/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    // Lưu mật khẩu mới sau khi đặt lại.
    Route::post('/dat-lai-mat-khau', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// ── Module 5 — Người dùng + đăng xuất + đánh giá (CẦN đăng nhập) ──
Route::middleware('auth.module')->group(function () {
    // Trang cá nhân: thông tin, đơn hàng, địa chỉ, wishlist.
    Route::get('/nguoi-dung', [ProfileController::class, 'show'])->name('profile.show');
    // Cập nhật hồ sơ (tên, SĐT…).
    Route::patch('/nguoi-dung/ho-so', [ProfileController::class, 'update'])->name('profile.update');
    // Đổi mật khẩu tài khoản.
    Route::patch('/nguoi-dung/mat-khau', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Thêm địa chỉ giao hàng mới.
    Route::post('/nguoi-dung/dia-chi', [DiaChiController::class, 'store'])->name('profile.addresses.store');
    // Sửa địa chỉ giao hàng.
    Route::patch('/nguoi-dung/dia-chi/{diaChi}', [DiaChiController::class, 'update'])->name('profile.addresses.update');
    // Xóa địa chỉ giao hàng.
    Route::delete('/nguoi-dung/dia-chi/{diaChi}', [DiaChiController::class, 'destroy'])->name('profile.addresses.destroy');
    // Đặt 1 địa chỉ làm mặc định.
    Route::patch('/nguoi-dung/dia-chi/{diaChi}/mac-dinh', [DiaChiController::class, 'makeDefault'])->name('profile.addresses.default');

    // Thêm sản phẩm vào danh sách yêu thích.
    Route::post('/products/{sanPham:slug}/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    // Bỏ 1 mục khỏi danh sách yêu thích.
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Đăng xuất (hủy phiên).
    Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
    // Gửi đánh giá (số sao + nội dung) cho 1 sản phẩm.
    Route::post('/products/{sanPham:slug}/reviews', [DanhGiaController::class, 'store'])->name('products.reviews.store');
});

// Mọi URL không khớp route nào ở trên → trả trang 404.
Route::fallback([TrangTinhController::class, 'notFound']);
