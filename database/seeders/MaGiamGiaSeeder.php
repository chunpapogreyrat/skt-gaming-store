<?php

namespace Database\Seeders;

use App\Models\MaGiamGia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MaGiamGiaSeeder extends Seeder
{
    public function run(): void
    {
        $ma = [
            // Mã HỢP LỆ để demo COUP-01
            [
                'ma_code' => 'YUKISALE',
                'loai' => 'phan_tram',
                'gia_tri' => 10,                       // giảm 10%
                'gia_tri_don_toi_thieu' => 500000,     // đơn từ 500K
                'so_lan_su_dung_toi_da' => null,       // không giới hạn
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subDays(7),
                'ngay_het_han' => Carbon::now()->addYear(),
                'trang_thai' => true,
            ],
            [
                'ma_code' => 'GIAM50K',
                'loai' => 'so_tien',
                'gia_tri' => 50000,                    // giảm 50.000đ
                'gia_tri_don_toi_thieu' => 800000,
                'so_lan_su_dung_toi_da' => 100,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subDays(3),
                'ngay_het_han' => Carbon::now()->addMonths(3),
                'trang_thai' => true,
            ],
            [
                'ma_code' => 'SALE20',
                'loai' => 'phan_tram',
                'gia_tri' => 20,                       // giảm 20%
                'gia_tri_don_toi_thieu' => 2000000,    // đơn lớn ≥ 2 triệu (test COUP-03)
                'so_lan_su_dung_toi_da' => null,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subDays(1),
                'ngay_het_han' => Carbon::now()->addMonth(),
                'trang_thai' => true,
            ],
            // Mã HẾT HẠN (test COUP-02)
            [
                'ma_code' => 'HETHAN',
                'loai' => 'phan_tram',
                'gia_tri' => 15,
                'gia_tri_don_toi_thieu' => 0,
                'so_lan_su_dung_toi_da' => null,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subMonths(2),
                'ngay_het_han' => Carbon::now()->subDays(1),   // đã qua → hết hạn
                'trang_thai' => true,
            ],
            // Mã HẾT LƯỢT (test COUP-02)
            [
                'ma_code' => 'HETLUOT',
                'loai' => 'so_tien',
                'gia_tri' => 30000,
                'gia_tri_don_toi_thieu' => 0,
                'so_lan_su_dung_toi_da' => 1,
                'so_lan_da_dung' => 1,                 // đã dùng hết
                'ngay_bat_dau' => Carbon::now()->subDays(5),
                'ngay_het_han' => Carbon::now()->addYear(),
                'trang_thai' => true,
            ],
            // Thêm vài mã nữa cho đủ dữ liệu (demo phân trang)
            [
                'ma_code' => 'FREESHIP',
                'loai' => 'so_tien',
                'gia_tri' => 30000,
                'gia_tri_don_toi_thieu' => 0,
                'so_lan_su_dung_toi_da' => null,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subDays(2),
                'ngay_het_han' => Carbon::now()->addMonths(6),
                'trang_thai' => true,
            ],
            [
                'ma_code' => 'NEWBIE10',
                'loai' => 'phan_tram',
                'gia_tri' => 10,
                'gia_tri_don_toi_thieu' => 0,
                'so_lan_su_dung_toi_da' => 200,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->subDays(1),
                'ngay_het_han' => Carbon::now()->addMonths(2),
                'trang_thai' => true,
            ],
            [
                'ma_code' => 'TET2026',
                'loai' => 'phan_tram',
                'gia_tri' => 25,
                'gia_tri_don_toi_thieu' => 1000000,
                'so_lan_su_dung_toi_da' => 500,
                'so_lan_da_dung' => 0,
                'ngay_bat_dau' => Carbon::now()->addMonths(6),  // chưa tới ngày bắt đầu
                'ngay_het_han' => Carbon::now()->addMonths(8),
                'trang_thai' => true,
            ],
        ];

        foreach ($ma as $row) {
            MaGiamGia::updateOrCreate(['ma_code' => $row['ma_code']], $row);
        }
    }
}
