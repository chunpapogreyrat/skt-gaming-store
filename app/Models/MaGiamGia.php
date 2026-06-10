<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaGiamGia extends Model
{
    use SoftDeletes;

    protected $table = 'ma_giam_gias';

    protected $fillable = [
        'ma_code',
        'loai',
        'gia_tri',
        'gia_tri_don_toi_thieu',
        'so_lan_su_dung_toi_da',
        'so_lan_da_dung',
        'ngay_bat_dau',
        'ngay_het_han',
        'trang_thai',
    ];

    protected $casts = [
        'gia_tri' => 'float',
        'gia_tri_don_toi_thieu' => 'float',
        'trang_thai' => 'boolean',
        'ngay_bat_dau' => 'date',
        'ngay_het_han' => 'date',
    ];

    public function conHieuLuc(): bool
    {
        if (!$this->trang_thai) return false;
        if ($this->ngay_bat_dau && $this->ngay_bat_dau->isFuture()) return false;
        if ($this->ngay_het_han && $this->ngay_het_han->isPast()) return false;
        if ($this->so_lan_su_dung_toi_da && $this->so_lan_da_dung >= $this->so_lan_su_dung_toi_da) return false;
        return true;
    }

    public function tinhGiamGia(float $tongTien): float
    {
        if ($tongTien < $this->gia_tri_don_toi_thieu) return 0;

        if ($this->loai === 'phan_tram') {
            $phanTram = min($this->gia_tri, 100);
            return round($tongTien * $phanTram / 100);
        }

        return min($this->gia_tri, $tongTien);
    }
}
