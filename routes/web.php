<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');
Route::get('/products/{sanPham:slug}', [SanPhamController::class, 'show'])->name('products.show');
Route::get('/categories/sidebar', [DanhMucController::class, 'sidebar'])->name('categories.sidebar');

Route::middleware('guest.module')->group(function () {
    Route::get('/dang-nhap', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap', [LoginController::class, 'login']);

    Route::get('/dang-ky', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky', [RegisterController::class, 'register']);

    Route::get('/quen-mat-khau', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/quen-mat-khau', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/dat-lai-mat-khau/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/dat-lai-mat-khau', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth.module')->group(function () {
    Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
    Route::post('/products/{sanPham:slug}/reviews', [DanhGiaController::class, 'store'])->name('products.reviews.store');

    Route::get('/admin', function () {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return view('admin.dashboard');
    })->name('admin.dashboard');
});
