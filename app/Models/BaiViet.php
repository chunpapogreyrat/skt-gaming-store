<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'bai_viet';

    protected $fillable = [
        'danh_muc',
        'tieu_de',
        'slug',
        'mo_ta_ngan',
        'noi_dung',
        'anh_bia',
        'tac_gia',
        'thoi_gian_doc',
        'luot_xem',
        'is_featured',
        'is_active',
        'ngay_dang',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'ngay_dang' => 'datetime',
    ];

    /** Danh mục blog: slug => nhãn hiển thị */
    public const DANH_MUC = [
        'setup'     => 'Setup & Build',
        'review'    => 'Đánh giá',
        'huong-dan' => 'Hướng dẫn',
        'tin-tuc'   => 'Tin tức',
        'esports'   => 'Esports',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function tenDanhMuc(): string
    {
        return self::DANH_MUC[$this->danh_muc] ?? 'Bài viết';
    }

    public function anhBiaUrl(): string
    {
        return $this->anh_bia ?: 'assets/images/setups/setup-1.jpg';
    }

    public function ngayDangFormatted(): string
    {
        return optional($this->ngay_dang)->translatedFormat('d/m/Y') ?? '';
    }
}
