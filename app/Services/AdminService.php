<?php

namespace App\Services;

use App\Models\DonHang;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public function thongKeTongQuan(): array
    {
        $doanhThu = DonHang::where('trang_thai_don_hang', 'da_giao')->sum('tong_tien');
        $soDonHang = DonHang::count();
        $soDonChoXuLy = DonHang::where('trang_thai_don_hang', 'cho_xac_nhan')->count();
        $soNguoiDung = TaiKhoan::count();

        // Sản phẩm: model của Codex có thể chưa tồn tại — đếm an toàn
        $soSanPham = 0;
        if (class_exists(\App\Models\SanPham::class)) {
            $soSanPham = \App\Models\SanPham::count();
        }

        return [
            'doanh_thu' => $doanhThu,
            'so_don_hang' => $soDonHang,
            'so_don_cho_xu_ly' => $soDonChoXuLy,
            'so_san_pham' => $soSanPham,
            'so_nguoi_dung' => $soNguoiDung,
        ];
    }

    public function doanhThu7Ngay(): array
    {
        $rows = DonHang::where('trang_thai_don_hang', 'da_giao')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(DB::raw('DATE(created_at) as ngay'), DB::raw('SUM(tong_tien) as tong'))
            ->groupBy('ngay')
            ->pluck('tong', 'ngay')
            ->toArray();

        $ketQua = [];
        for ($i = 6; $i >= 0; $i--) {
            $ngay = now()->subDays($i)->toDateString();
            $ketQua[$ngay] = (float) ($rows[$ngay] ?? 0);
        }

        return $ketQua;
    }

    public function donHangMoiNhat(int $limit = 5)
    {
        return DonHang::latest()->take($limit)->get();
    }
}
