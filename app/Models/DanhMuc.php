<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanhMuc extends Model
{
    protected $table = 'danh_mucs';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'ten',
        'slug',
        'icon',
        'mo_ta',
        'hinh_anh',
        'thu_tu',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ngay_tao' => 'datetime',
    ];

    public function sanPhams(): HasMany
    {
        return $this->hasMany(SanPham::class, 'danh_muc_id');
    }
}
