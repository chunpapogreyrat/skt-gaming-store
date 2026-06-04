<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BienTheSanPham extends Model
{
    protected $table = 'bien_the_san_pham';

    public $timestamps = false;

    protected $fillable = [
        'san_pham_id',
        'ten_bien_the',
        'ma_hex',
        'gia_chenh_lech',
        'so_luong_ton',
        'is_active',
    ];

    protected $casts = [
        'gia_chenh_lech' => 'float',
        'is_active' => 'boolean',
    ];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
