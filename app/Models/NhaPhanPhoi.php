<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhaPhanPhoi extends Model
{
    use SoftDeletes;

    protected $table = 'nha_phan_phois';

    protected $fillable = [
        'ten',
        'mo_ta',
        'email',
        'sdt',
        'quoc_gia',
        'icon',
        'so_sku',
        'hop_dong_den',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'so_sku' => 'integer',
        'hop_dong_den' => 'date',
    ];

    /** Nhãn tiếng Việt cho từng trạng thái. */
    public const NHAN_TRANG_THAI = [
        'active' => 'Đang hợp tác',
        'paused' => 'Tạm dừng',
        'ended' => 'Đã kết thúc',
    ];

    /** Class badge tương ứng trạng thái (theo bộ màu admin có sẵn). */
    public const BADGE_TRANG_THAI = [
        'active' => 'done',
        'paused' => 'pending',
        'ended' => 'cancel',
    ];

    /** Map quốc gia (tiếng Việt) → emoji cờ. */
    public const CO_QUOC_GIA = [
        'mỹ' => '🇺🇸', 'hoa kỳ' => '🇺🇸',
        'hà lan' => '🇳🇱',
        'hàn quốc' => '🇰🇷',
        'đức' => '🇩🇪',
        'singapore' => '🇸🇬',
        'đan mạch' => '🇩🇰',
        'thụy sĩ' => '🇨🇭',
        'nhật bản' => '🇯🇵', 'nhật' => '🇯🇵',
        'trung quốc' => '🇨🇳',
        'đài loan' => '🇹🇼',
        'việt nam' => '🇻🇳',
        'anh' => '🇬🇧',
        'pháp' => '🇫🇷',
        'canada' => '🇨🇦',
        'úc' => '🇦🇺',
    ];

    public function tenTrangThai(): string
    {
        return self::NHAN_TRANG_THAI[$this->trang_thai] ?? $this->trang_thai;
    }

    public function coQuocGia(): string
    {
        if (! $this->quoc_gia) {
            return '';
        }

        return self::CO_QUOC_GIA[mb_strtolower(trim($this->quoc_gia))] ?? '';
    }

    public function badgeTrangThai(): string
    {
        return self::BADGE_TRANG_THAI[$this->trang_thai] ?? 'pending';
    }
}
