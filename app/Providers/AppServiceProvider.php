<?php

namespace App\Providers;

use App\Services\GioHangService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Phân trang dùng Bootstrap 5 (project load bootstrap, không dùng Tailwind)
        Paginator::useBootstrapFive();

        // Inject cart drawer data vào mọi view dùng layouts.app
        View::composer('layouts.app', function ($view) {
            try {
                $cart = app(GioHangService::class)->layGioHang();
                $tong = app(GioHangService::class)->tinhTong();
                $view->with([
                    'cartDrawerItems' => $cart->items,
                    'cartDrawerTotal' => $tong['tong_tien'],
                    'cartDrawerCount' => $cart->tongSoLuong(),
                ]);
            } catch (\Throwable $e) {
                $view->with([
                    'cartDrawerItems' => collect(),
                    'cartDrawerTotal' => 0,
                    'cartDrawerCount' => 0,
                ]);
            }
        });
    }
}
