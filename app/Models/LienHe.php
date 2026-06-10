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
        'tu-van' => 'Tư vấn sản phẩm',
        'bao-hanh' => 'Bảo hành',
        'setup' => 'Build setup',
    ];

    public function tenChuDe(): string
    {
        return self::NHAN_CHU_DE[$this->chu_de] ?? 'Khác';
    }
}
