<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaiKhoan extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'tai_khoans';

    // tai_khoans dùng ngay_tao thay cho created_at, không có updated_at
    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'ngay_sinh',
        'gioi_tinh',
        'avatar',
        'hang_thanh_vien',
        'diem_tich_luy',
        'role',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'ngay_tao'          => 'datetime',
    ];

    // Laravel Auth dùng method này để lấy mật khẩu hash
    public function getAuthPassword(): string
    {
        return $this->mat_khau;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
