<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HinhAnhSanPham extends Model
{
    protected $table = 'hinh_anh_san_pham';

    public $timestamps = false;

    protected $fillable = [
        'san_pham_id',
        'duong_dan',
        'thu_tu',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
