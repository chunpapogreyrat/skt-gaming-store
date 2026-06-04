<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hangs';

    protected $fillable = [
        'don_hang_id',
        'san_pham_id',
        'ten_san_pham',
        'anh_san_pham',
        'mau_sac',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    protected $casts = [
        'don_gia' => 'float',
        'thanh_tien' => 'float',
    ];

    public function donHang(): BelongsTo
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
