<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThuongHieu extends Model
{
    protected $table = 'thuong_hieu';

    public $timestamps = false;

    protected $fillable = [
        'ten',
        'slug',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sanPhams(): HasMany
    {
        return $this->hasMany(SanPham::class, 'thuong_hieu_id');
    }
}
