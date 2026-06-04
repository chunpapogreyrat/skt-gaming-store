<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPham extends Model
{
    use SoftDeletes;

    protected $table = 'san_phams';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'danh_muc_id',
        'thuong_hieu_id',
        'ten',
        'slug',
        'mo_ta_ngan',
        'mo_ta_day_du',
        'gia_ban',
        'gia_goc',
        'so_luong_ton',
        'luot_xem',
        'luot_ban',
        'diem_danh_gia',
        'so_luong_danh_gia',
        'is_hot',
        'is_sale',
        'is_active',
    ];

    protected $casts = [
        'gia_ban' => 'float',
        'gia_goc' => 'float',
        'diem_danh_gia' => 'float',
        'is_hot' => 'boolean',
        'is_sale' => 'boolean',
        'is_active' => 'boolean',
        'ngay_tao' => 'datetime',
        'ngay_cap_nhat' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }

    public function thuongHieu(): BelongsTo
    {
        return $this->belongsTo(ThuongHieu::class, 'thuong_hieu_id');
    }

    public function hinhAnh(): HasMany
    {
        return $this->hasMany(HinhAnhSanPham::class, 'san_pham_id')->orderByDesc('is_main')->orderBy('thu_tu');
    }

    public function bienThe(): HasMany
    {
        return $this->hasMany(BienTheSanPham::class, 'san_pham_id')->where('is_active', true);
    }

    public function danhGia(): HasMany
    {
        return $this->hasMany(DanhGiaSanPham::class, 'san_pham_id')->where('is_active', true)->latest('ngay_tao');
    }

    public function thongSo(): HasMany
    {
        return $this->hasMany(ThongSoSanPham::class, 'san_pham_id')->orderBy('thu_tu');
    }

    public function mainImagePath(): string
    {
        $path = $this->hinhAnh->first()?->duong_dan;

        return $path ?: 'assets/images/library/logo.png';
    }

    public function formattedPrice(): string
    {
        return number_format($this->gia_ban, 0, ',', '.') . 'đ';
    }

    public function formattedOldPrice(): ?string
    {
        if (! $this->gia_goc || $this->gia_goc <= $this->gia_ban) {
            return null;
        }

        return number_format($this->gia_goc, 0, ',', '.') . 'đ';
    }

    public function discountPercent(): ?int
    {
        if (! $this->gia_goc || $this->gia_goc <= $this->gia_ban) {
            return null;
        }

        return (int) round((($this->gia_goc - $this->gia_ban) / $this->gia_goc) * 100);
    }
}
