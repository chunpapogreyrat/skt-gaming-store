<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';

    public $timestamps = false;

    protected $fillable = [
        'don_hang_id',
        'san_pham_id',
        'bien_the_id',
        'ten_san_pham',
        'hinh_anh',
        'bien_the_text',
        'so_luong',
        'don_gia',
        'thanh_tien',
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
