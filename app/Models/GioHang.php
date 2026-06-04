<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GioHang extends Model
{
    protected $table = 'gio_hangs';

    protected $fillable = [
        'tai_khoan_id',
        'session_id',
    ];

    public function taiKhoan(): BelongsTo
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GioHangItem::class, 'gio_hang_id');
    }

    public function tongSoLuong(): int
    {
        return $this->items->sum('so_luong');
    }

    public function tongTien(): float
    {
        return $this->items->sum(fn($item) => $item->gia_tai_thoi_diem * $item->so_luong);
    }
}
