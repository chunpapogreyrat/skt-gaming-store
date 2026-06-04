<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonHang extends Model
{
    use SoftDeletes;

    protected $table = 'don_hangs';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'ma_don',
        'tai_khoan_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'dia_chi_giao_hang',
        'trang_thai',
        'tam_tinh',
        'tong_tien',
    ];

    protected $casts = [
        'tam_tinh' => 'float',
        'tong_tien' => 'float',
        'ngay_tao' => 'datetime',
        'ngay_cap_nhat' => 'datetime',
    ];

    public function chiTiet(): HasMany
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}
