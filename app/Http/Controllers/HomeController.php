<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Banner hero slider (đổ từ DB)
        $banners = Banner::where('is_active', true)->orderBy('thu_tu')->get();

        // Sản phẩm Sale (Flash Sale)
        $sanPhamSale = SanPham::with(['hinhAnh', 'thuongHieu', 'danhMuc'])
            ->where('is_active', true)
            ->where('is_sale', true)
            ->orderByDesc('luot_ban')
            ->limit(8)
            ->get();

        // Sản phẩm nổi bật / mới (featured grid)
        $sanPhamNoiBat = SanPham::with(['hinhAnh', 'thuongHieu', 'danhMuc'])
            ->where('is_active', true)
            ->orderByDesc('luot_ban')
            ->orderByDesc('luot_xem')
            ->limit(12)
            ->get();

        // Top bán chạy sidebar
        $topBanChay = SanPham::with('hinhAnh')
            ->where('is_active', true)
            ->orderByDesc('luot_ban')
            ->limit(3)
            ->get();

        // Danh mục sidebar
        $danhMucs = DanhMuc::where('is_active', true)
            ->orderBy('thu_tu')
            ->get();

        return view('home', compact('banners', 'sanPhamSale', 'sanPhamNoiBat', 'topBanChay', 'danhMucs'));
    }
}
