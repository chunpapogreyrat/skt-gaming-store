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

        // Sản phẩm: model có thể chưa tồn tại — đếm an toàn
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

    /**
     * Báo cáo doanh thu theo năm + tháng được chọn.
     * Doanh thu chỉ tính đơn ĐÃ GIAO (trang_thai_don_hang = da_giao).
     */
    public function baoCaoDoanhThu(int $nam, int $thang): array
    {
        $now = now();
        // Chỉ tính tới tháng hiện tại nếu là năm nay; năm cũ tính đủ 12 tháng; năm tương lai = 0
        $thangToiDa = $nam > $now->year ? 0 : ($nam === (int) $now->year ? (int) $now->month : 12);

        // Doanh thu + số đơn từng tháng trong năm
        $rows = DonHang::where('trang_thai_don_hang', 'da_giao')
            ->whereYear('created_at', $nam)
            ->selectRaw('MONTH(created_at) as thang, SUM(tong_tien) as doanh_thu, COUNT(*) as so_don')
            ->groupByRaw('MONTH(created_at)')
            ->get()
            ->keyBy('thang');

        $thangData = [];
        $maxDoanhThu = 0;
        for ($m = 1; $m <= $thangToiDa; $m++) {
            $dt = (float) ($rows[$m]->doanh_thu ?? 0);
            $sd = (int) ($rows[$m]->so_don ?? 0);
            $truoc = $m > 1 ? $thangData[$m - 2]['doanh_thu'] : null;
            $thangData[] = [
                'thang' => $m,
                'doanh_thu' => $dt,
                'so_don' => $sd,
                'tb_don' => $sd > 0 ? $dt / $sd : 0,
                'mom' => $this->phanTramThayDoi($dt, $truoc),
            ];
            $maxDoanhThu = max($maxDoanhThu, $dt);
        }

        // Thẻ thống kê cho tháng được chọn (so với tháng liền trước)
        $hienTai = $this->soLieuThang($nam, $thang);
        [$namTruoc, $thangTruoc] = $thang > 1 ? [$nam, $thang - 1] : [$nam - 1, 12];
        $truoc = $this->soLieuThang($namTruoc, $thangTruoc);

        $tbHienTai = $hienTai['so_don'] > 0 ? $hienTai['doanh_thu'] / $hienTai['so_don'] : 0;
        $tbTruoc = $truoc['so_don'] > 0 ? $truoc['doanh_thu'] / $truoc['so_don'] : 0;

        $card = [
            'doanh_thu' => $hienTai['doanh_thu'],
            'doanh_thu_mom' => $this->phanTramThayDoi($hienTai['doanh_thu'], $truoc['doanh_thu']),
            'don_hoan_thanh' => $hienTai['so_don'],
            'don_mom' => $this->phanTramThayDoi($hienTai['so_don'], $truoc['so_don']),
            'tb_don' => $tbHienTai,
            'tb_mom' => $this->phanTramThayDoi($tbHienTai, $tbTruoc),
            'khach_moi' => $hienTai['khach_moi'],
            'khach_mom' => $this->phanTramThayDoi($hienTai['khach_moi'], $truoc['khach_moi']),
        ];

        return [
            'nam' => $nam,
            'thang' => $thang,
            'thang_toi_da' => $thangToiDa,
            'thang_data' => $thangData,
            'max_doanh_thu' => $maxDoanhThu,
            'card' => $card,
            'cac_nam' => $this->cacNamCoData(),
        ];
    }

    private function soLieuThang(int $nam, int $thang): array
    {
        $don = DonHang::where('trang_thai_don_hang', 'da_giao')
            ->whereYear('created_at', $nam)
            ->whereMonth('created_at', $thang)
            ->selectRaw('COALESCE(SUM(tong_tien), 0) as doanh_thu, COUNT(*) as so_don')
            ->first();

        $khachMoi = TaiKhoan::where('role', 'customer')
            ->whereYear('ngay_tao', $nam)
            ->whereMonth('ngay_tao', $thang)
            ->count();

        return [
            'doanh_thu' => (float) ($don->doanh_thu ?? 0),
            'so_don' => (int) ($don->so_don ?? 0),
            'khach_moi' => $khachMoi,
        ];
    }

    /** % thay đổi so với kỳ trước. Trả null nếu không có kỳ trước để so. */
    private function phanTramThayDoi(float $hienTai, ?float $truoc): ?float
    {
        if ($truoc === null) {
            return null;
        }
        if ($truoc == 0) {
            return $hienTai > 0 ? 100.0 : 0.0;
        }

        return round(($hienTai - $truoc) / $truoc * 100, 1);
    }

    /** Danh sách năm có đơn hàng (kèm năm hiện tại) để đổ vào bộ lọc. */
    private function cacNamCoData(): array
    {
        $nams = DonHang::selectRaw('DISTINCT YEAR(created_at) as nam')
            ->orderByDesc('nam')
            ->pluck('nam')
            ->map(fn ($n) => (int) $n)
            ->all();

        $namNay = (int) now()->year;
        if (! in_array($namNay, $nams, true)) {
            $nams[] = $namNay;
            rsort($nams);
        }

        return $nams;
    }
}
