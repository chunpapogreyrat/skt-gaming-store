<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'tieu_de',
        'mo_ta',
        'hinh_anh',
        'link',
        'thu_tu',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'thu_tu' => 'integer',
    ];
}
