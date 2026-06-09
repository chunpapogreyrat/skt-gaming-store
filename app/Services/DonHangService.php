<?php

namespace App\Services;

use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\ThanhToan;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonHangService
{
    public function __construct(
        private GioHangService $gioHangService
    ) {}

    public function taoDonHang(array $data): DonHang
    {
        return DB::transaction(function () use ($data) {
            $gioHang = $this->gioHangService->layGioHang();

            if ($gioHang->items->isEmpty()) {
                throw new \Exception('Giỏ hàng trống — không thể đặt hàng');
            }

            // Chặn bán quá tồn kho (CART-05)
            foreach ($gioHang->items as $item) {
                $sp = $item->sanPham;
                if ($sp && $item->so_luong > (int) $sp->so_luong_ton) {
                    $conLai = (int) $sp->so_luong_ton;
                    throw new \Exception(
                        $conLai > 0
                            ? "Sản phẩm “{$sp->ten}” chỉ còn {$conLai} trong kho."
                            : "Sản phẩm “{$sp->ten}” đã hết hàng."
                    );
                }
            }

            $tamTinh = $gioHang->tongTien();
            $phiShip = $data['phi_ship'] ?? ($tamTinh >= 500000 ? 0 : 30000);
            $giamGia = 0;
            $maGiamGiaId = null;

            if ($maId = session('ma_giam_gia_id')) {
                $coupon = MaGiamGia::find($maId);
                if ($coupon && $coupon->conHieuLuc()) {
                    $giamGia = $coupon->tinhGiamGia($tamTinh);
                    $maGiamGiaId = $coupon->id;
                    $coupon->increment('so_lan_da_dung');
                }
            }

            $tongTien = $tamTinh + $phiShip - $giamGia;

            $donHang = DonHang::create([
                'ma_don_hang' => DonHang::taoMaDonHang(),
                'tai_khoan_id' => Auth::id(),
                'ma_giam_gia_id' => $maGiamGiaId,
                'ten_nguoi_nhan' => $data['ten_nguoi_nhan'],
                'sdt_nguoi_nhan' => $data['sdt_nguoi_nhan'],
                'dia_chi_giao_hang' => $data['dia_chi_giao_hang'],
                'tinh_thanh' => $data['tinh_thanh'] ?? null,
                'quan_huyen' => $data['quan_huyen'] ?? null,
                'phuong_xa' => $data['phuong_xa'] ?? null,
                'tam_tinh' => $tamTinh,
                'phi_ship' => $phiShip,
                'giam_gia' => $giamGia,
                'tong_tien' => $tongTien,
                'phuong_thuc_thanh_toan' => $data['phuong_thuc_thanh_toan'] ?? 'cod',
                'trang_thai_thanh_toan' => 'chua_thanh_toan',
                'trang_thai_don_hang' => 'cho_xac_nhan',
                'ghi_chu' => $data['ghi_chu'] ?? null,
            ]);

            foreach ($gioHang->items as $item) {
                $sanPham = $item->sanPham;

                ChiTietDonHang::create([
                    'don_hang_id' => $donHang->id,
                    'san_pham_id' => $item->san_pham_id,
                    'ten_san_pham' => $sanPham?->ten ?? 'Sản phẩm',
                    'anh_san_pham' => $sanPham?->mainImagePath(),
                    'mau_sac' => $item->mau_sac,
                    'so_luong' => $item->so_luong,
                    'don_gia' => $item->gia_tai_thoi_diem,
                    'thanh_tien' => $item->gia_tai_thoi_diem * $item->so_luong,
                ]);

                // Trừ tồn kho (không cho âm)
                if ($sanPham) {
                    $sanPham->decrement('so_luong_ton', min($item->so_luong, (int) $sanPham->so_luong_ton));
                }
            }

            ThanhToan::create([
                'don_hang_id' => $donHang->id,
                'cong_thanh_toan' => $donHang->phuong_thuc_thanh_toan,
                'so_tien' => $tongTien,
                'trang_thai' => 'pending',
            ]);

            $gioHang->items()->delete();
            $gioHang->delete();
            session()->forget('ma_giam_gia_id');

            $this->guiEmailXacNhan($donHang);

            return $donHang->load('chiTiet', 'thanhToan');
        });
    }

    public function huyDonHang(DonHang $donHang, ?string $lyDo = null): bool
    {
        if (!$donHang->coTheHuy()) {
            return false;
        }

        return DB::transaction(function () use ($donHang, $lyDo) {
            foreach ($donHang->chiTiet as $ct) {
                if ($ct->sanPham) {
                    $ct->sanPham->increment('so_luong_ton', $ct->so_luong);
                }
            }

            $donHang->update([
                'trang_thai_don_hang' => 'da_huy',
                'ghi_chu' => trim(($donHang->ghi_chu ?? '') . "\n[Hủy] " . ($lyDo ?? 'Khách hủy')),
            ]);

            if ($donHang->ma_giam_gia_id) {
                MaGiamGia::where('id', $donHang->ma_giam_gia_id)->decrement('so_lan_da_dung');
            }

            return true;
        });
    }

    public function capNhatTrangThai(DonHang $donHang, string $trangThai): bool
    {
        $hopLe = ['cho_xac_nhan', 'dang_chuan_bi', 'dang_giao', 'da_giao', 'da_huy'];
        if (!in_array($trangThai, $hopLe)) {
            return false;
        }

        $donHang->update(['trang_thai_don_hang' => $trangThai]);

        if ($trangThai === 'da_giao' && $donHang->phuong_thuc_thanh_toan === 'cod') {
            $donHang->update(['trang_thai_thanh_toan' => 'da_thanh_toan']);
            $donHang->thanhToan?->update([
                'trang_thai' => 'success',
                'thoi_gian_thanh_toan' => now(),
            ]);
        }

        return true;
    }

    protected function guiEmailXacNhan(DonHang $donHang): void
    {
        try {
            // TODO: gửi Mailable thực tế khi cấu hình SMTP xong
            Log::info("Email xác nhận đơn {$donHang->ma_don_hang} gửi tới: " . ($donHang->taiKhoan?->email ?? 'guest'));
        } catch (\Throwable $e) {
            Log::warning("Không gửi được email: {$e->getMessage()}");
        }
    }
}
