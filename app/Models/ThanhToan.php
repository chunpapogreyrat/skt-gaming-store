<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';

    protected $fillable = [
        'don_hang_id',
        'ma_giao_dich',
        'cong_thanh_toan',
        'so_tien',
        'trang_thai',
        'du_lieu_callback',
        'thoi_gian_thanh_toan',
    ];

    protected $casts = [
        'so_tien' => 'float',
        'du_lieu_callback' => 'array',
        'thoi_gian_thanh_toan' => 'datetime',
    ];

    public function donHang(): BelongsTo
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}
