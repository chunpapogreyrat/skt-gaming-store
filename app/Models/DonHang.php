<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonHang extends Model
{
    use SoftDeletes;

    protected $table = 'don_hangs';

    protected $fillable = [
        'ma_don_hang',
        'tai_khoan_id',
        'ma_giam_gia_id',
        'ten_nguoi_nhan',
        'sdt_nguoi_nhan',
        'dia_chi_giao_hang',
        'tinh_thanh',
        'quan_huyen',
        'phuong_xa',
        'tam_tinh',
        'phi_ship',
        'giam_gia',
        'tong_tien',
        'phuong_thuc_thanh_toan',
        'trang_thai_thanh_toan',
        'trang_thai_don_hang',
        'ghi_chu',
    ];

    protected $casts = [
        'tam_tinh' => 'float',
        'phi_ship' => 'float',
        'giam_gia' => 'float',
        'tong_tien' => 'float',
    ];

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function maGiamGia(): BelongsTo
    {
        return $this->belongsTo(MaGiamGia::class, 'ma_giam_gia_id');
    }

    public function chiTiet(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }

    public function thanhToan(): HasOne
    {
        return $this->hasOne(ThanhToan::class, 'don_hang_id');
    }

    public function tenTrangThai(): string
    {
        return match ($this->trang_thai_don_hang) {
            'cho_xac_nhan' => 'Chờ xác nhận',
            'dang_chuan_bi' => 'Đang chuẩn bị',
            'dang_giao' => 'Đang giao',
            'da_giao' => 'Đã giao',
            'da_huy' => 'Đã hủy',
            default => 'Không xác định',
        };
    }

    public function tenPhuongThuc(): string
    {
        return match ($this->phuong_thuc_thanh_toan) {
            'cod' => 'COD - Thanh toán khi nhận hàng',
            'momo' => 'Ví MoMo',
            'vnpay' => 'VNPay',
            default => 'Khác',
        };
    }

    public function coTheHuy(): bool
    {
        return in_array($this->trang_thai_don_hang, ['cho_xac_nhan', 'dang_chuan_bi']);
    }

    public static function taoMaDonHang(): string
    {
        return 'SKT-' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }
}
