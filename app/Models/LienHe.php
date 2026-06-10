<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LienHe extends Model
{
    protected $table = 'lien_hes';

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'chu_de',
        'noi_dung',
        'da_xu_ly',
    ];

    protected $casts = [
        'da_xu_ly' => 'boolean',
    ];

    public const NHAN_CHU_DE = [
        'ho-tro-ky-thuat' => 'Hỗ trợ kỹ thuật',
        'bao-hanh' => 'Bảo hành sản phẩm',
        'don-hang' => 'Thông tin đơn hàng',
        'hop-tac' => 'Hợp tác kinh doanh',
        'khac' => 'Khác',
    ];

    public function tenChuDe(): string
    {
        return self::NHAN_CHU_DE[$this->chu_de] ?? 'Khác';
    }
}
