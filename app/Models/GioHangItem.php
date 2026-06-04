<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GioHangItem extends Model
{
    protected $table = 'gio_hang_items';

    protected $fillable = [
        'gio_hang_id',
        'san_pham_id',
        'so_luong',
        'gia_tai_thoi_diem',
        'mau_sac',
    ];

    public function gioHang(): BelongsTo
    {
        return $this->belongsTo(GioHang::class, 'gio_hang_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function thanhTien(): float
    {
        return $this->gia_tai_thoi_diem * $this->so_luong;
    }
}
