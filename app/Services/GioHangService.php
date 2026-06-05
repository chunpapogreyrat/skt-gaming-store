<?php

namespace App\Services;

use App\Models\GioHang;
use App\Models\GioHangItem;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;

class GioHangService
{
    public function layGioHang(): GioHang
    {
        if (Auth::check()) {
            $gioHang = GioHang::with('items.sanPham')
                ->where('tai_khoan_id', Auth::id())
                ->first();

            if (!$gioHang) {
                $gioHang = GioHang::create(['tai_khoan_id' => Auth::id()]);
            }

            return $gioHang;
        }

        $sessionId = session()->getId();
        $gioHang = GioHang::with('items.sanPham')
            ->where('session_id', $sessionId)
            ->first();

        if (!$gioHang) {
            $gioHang = GioHang::create(['session_id' => $sessionId]);
        }

        return $gioHang;
    }

    public function themSanPham(int $sanPhamId, int $soLuong = 1, ?string $mauSac = null): GioHangItem
    {
        $gioHang = $this->layGioHang();
        $sanPham = SanPham::findOrFail($sanPhamId);

        $item = $gioHang->items()
            ->where('san_pham_id', $sanPhamId)
            ->where('mau_sac', $mauSac)
            ->first();

        if ($item) {
            $item->update(['so_luong' => $item->so_luong + $soLuong]);
        } else {
            $item = $gioHang->items()->create([
                'san_pham_id' => $sanPhamId,
                'so_luong' => $soLuong,
                'gia_tai_thoi_diem' => $sanPham->gia_ban,
                'mau_sac' => $mauSac,
            ]);
        }

        return $item->load('sanPham.hinhAnh');
    }

    public function capNhatSoLuong(int $itemId, int $soLuong): ?GioHangItem
    {
        $gioHang = $this->layGioHang();
        $item = $gioHang->items()->findOrFail($itemId);

        if ($soLuong <= 0) {
            $item->delete();
            return null;
        }

        $item->update(['so_luong' => $soLuong]);
        return $item->load('sanPham');
    }

    public function xoaItem(int $itemId): void
    {
        $gioHang = $this->layGioHang();
        $gioHang->items()->findOrFail($itemId)->delete();
    }

    public function xoaTatCa(): void
    {
        $gioHang = $this->layGioHang();
        $gioHang->items()->delete();
    }

    public function tinhTong(): array
    {
        $gioHang = $this->layGioHang();
        $tamTinh = $gioHang->tongTien();
        $phiShip = $tamTinh >= 500000 ? 0 : 30000;

        return [
            'tam_tinh' => $tamTinh,
            'phi_ship' => $phiShip,
            'giam_gia' => 0,
            'tong_tien' => $tamTinh + $phiShip,
        ];
    }

    public function apDungMaGiamGia(string $maCode): array
    {
        $coupon = MaGiamGia::where('ma_code', $maCode)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Mã giảm giá không tồn tại'];
        }

        if (!$coupon->conHieuLuc()) {
            return ['success' => false, 'message' => 'Mã giảm giá đã hết hạn hoặc hết lượt sử dụng'];
        }

        $gioHang = $this->layGioHang();
        $tamTinh = $gioHang->tongTien();

        if ($tamTinh < $coupon->gia_tri_don_toi_thieu) {
            return [
                'success' => false,
                'message' => 'Đơn hàng phải từ ' . number_format($coupon->gia_tri_don_toi_thieu) . 'đ để áp dụng mã này',
            ];
        }

        $giamGia = $coupon->tinhGiamGia($tamTinh);
        $phiShip = $tamTinh >= 500000 ? 0 : 30000;

        session(['ma_giam_gia_id' => $coupon->id]);

        return [
            'success' => true,
            'message' => 'Áp dụng mã thành công! Giảm ' . number_format($giamGia) . 'đ',
            'data' => [
                'tam_tinh' => $tamTinh,
                'phi_ship' => $phiShip,
                'giam_gia' => $giamGia,
                'tong_tien' => $tamTinh + $phiShip - $giamGia,
            ],
        ];
    }

    public function mergeGuestCart(): void
    {
        if (!Auth::check()) return;

        $sessionId = session()->getId();
        $guestCart = GioHang::with('items')
            ->where('session_id', $sessionId)
            ->whereNull('tai_khoan_id')
            ->first();

        if (!$guestCart || $guestCart->items->isEmpty()) return;

        $userCart = $this->layGioHang();

        foreach ($guestCart->items as $guestItem) {
            $existing = $userCart->items()
                ->where('san_pham_id', $guestItem->san_pham_id)
                ->where('mau_sac', $guestItem->mau_sac)
                ->first();

            if ($existing) {
                $existing->update(['so_luong' => $existing->so_luong + $guestItem->so_luong]);
            } else {
                $guestItem->update(['gio_hang_id' => $userCart->id]);
            }
        }

        $guestCart->items()->delete();
        $guestCart->delete();
    }

    public function demSoLuong(): int
    {
        $gioHang = $this->layGioHang();
        return $gioHang->tongSoLuong();
    }
}
