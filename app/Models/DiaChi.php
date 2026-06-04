<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaChi extends Model
{
    use SoftDeletes;

    protected $table = 'dia_chis';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'tai_khoan_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'tinh_thanh',
        'quan_huyen',
        'phuong_xa',
        'dia_chi_cu_the',
        'loai_dia_chi',
        'is_mac_dinh',
    ];

    protected $casts = [
        'is_mac_dinh' => 'boolean',
        'ngay_tao' => 'datetime',
        'ngay_cap_nhat' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function fullAddress(): string
    {
        return implode(', ', array_filter([
            $this->dia_chi_cu_the,
            $this->phuong_xa,
            $this->quan_huyen,
            $this->tinh_thanh,
        ]));
    }
}
