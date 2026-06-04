<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'tai_khoan_id',
        'san_pham_id',
    ];

    protected $casts = [
        'ngay_tao' => 'datetime',
    ];

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
