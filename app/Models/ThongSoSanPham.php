<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThongSoSanPham extends Model
{
    protected $table = 'thong_so_san_pham';

    public $timestamps = false;

    protected $fillable = [
        'san_pham_id',
        'ten',
        'gia_tri',
        'thu_tu',
    ];

    public function sanPham(): BelongsTo
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
