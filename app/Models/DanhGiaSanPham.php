<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanhGiaSanPham extends Model
{
    protected $table = 'danh_gia_san_pham';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'san_pham_id',
        'tai_khoan_id',
        'don_hang_id',
        'so_sao',
        'noi_dung',
        'hinh_anh',
        'is_verified_purchase',
        'is_active',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'is_active' => 'boolean',
        'ngay_tao' => 'datetime',
    ];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }
}
