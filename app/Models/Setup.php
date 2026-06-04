<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setup extends Model
{
    use SoftDeletes;

    protected $table = 'setups';

    protected $fillable = [
        'ten_setup',
        'ten_game_thu',
        'anh_chinh',
        'mo_ta',
        'san_phams_trong_setup',
        'noi_bat',
        'thu_tu',
    ];

    protected $casts = [
        'san_phams_trong_setup' => 'array',
        'noi_bat' => 'boolean',
    ];
}
