<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\TrangTinhController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');
Route::get('/products/{sanPham:slug}', [SanPhamController::class, 'show'])->name('products.show');
Route::get('/categories/sidebar', [DanhMucController::class, 'sidebar'])->name('categories.sidebar');
Route::get('/gioi-thieu', [TrangTinhController::class, 'about'])->name('static.about');
Route::get('/lien-he', [TrangTinhController::class, 'contact'])->name('static.contact');
Route::get('/setups', [TrangTinhController::class, 'setups'])->name('static.setups');
Route::get('/404', [TrangTinhController::class, 'notFound'])->name('static.404');

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
    Route::get('/nguoi-dung', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/nguoi-dung/ho-so', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/nguoi-dung/mat-khau', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/nguoi-dung/dia-chi', [DiaChiController::class, 'store'])->name('profile.addresses.store');
    Route::patch('/nguoi-dung/dia-chi/{diaChi}', [DiaChiController::class, 'update'])->name('profile.addresses.update');
    Route::delete('/nguoi-dung/dia-chi/{diaChi}', [DiaChiController::class, 'destroy'])->name('profile.addresses.destroy');
    Route::patch('/nguoi-dung/dia-chi/{diaChi}/mac-dinh', [DiaChiController::class, 'makeDefault'])->name('profile.addresses.default');

    Route::post('/products/{sanPham:slug}/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');
    Route::post('/products/{sanPham:slug}/reviews', [DanhGiaController::class, 'store'])->name('products.reviews.store');

    Route::get('/admin', function () {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::fallback([TrangTinhController::class, 'notFound']);
