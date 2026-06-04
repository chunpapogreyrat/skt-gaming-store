<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Support\Facades\Route;

// Trang chủ tạm (sẽ thay bằng HomeController sau)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');
Route::get('/products/{sanPham:slug}', [SanPhamController::class, 'show'])->name('products.show');
Route::get('/categories/sidebar', [DanhMucController::class, 'sidebar'])->name('categories.sidebar');

// ──────────────────────────────────────────────
// Auth — chỉ cho khách (chưa đăng nhập)
// ──────────────────────────────────────────────
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

// ──────────────────────────────────────────────
// Auth — cần đăng nhập
// ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
    Route::post('/products/{sanPham:slug}/reviews', [DanhGiaController::class, 'store'])->name('products.reviews.store');

    Route::get('/admin', function () {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return view('admin.dashboard');
    })->name('admin.dashboard');
});
