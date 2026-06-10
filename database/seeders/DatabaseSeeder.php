<?php

namespace Database\Seeders;

use App\Models\TaiKhoan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Tài khoản demo ──
        TaiKhoan::updateOrCreate(
            ['email' => 'admin@skt.test'],
            [
                'ho_ten'          => 'SKT Admin',
                'mat_khau'        => Hash::make('Admin@12345'),
                'so_dien_thoai'   => '0900000001',
                'hang_thanh_vien' => 'diamond',
                'diem_tich_luy'   => 9999,
                'role'            => 'admin',
                'is_active'       => true,
            ]
        );

        TaiKhoan::updateOrCreate(
            ['email' => 'khach@skt.test'],
            [
                'ho_ten'          => 'Khách Hàng Demo',
                'mat_khau'        => Hash::make('User@12345'),
                'so_dien_thoai'   => '0900000002',
                'hang_thanh_vien' => 'gold',
                'diem_tich_luy'   => 1250,
                'role'            => 'customer',
                'is_active'       => true,
            ]
        );

        // ── Danh mục + Thương hiệu + 40 sản phẩm + biến thể màu ──
        $this->call(ProductsSeeder::class);

        // ── Banner hero slider trang chủ ──
        $this->call(BannerSeeder::class);

        // ── Mã giảm giá demo ──
        $this->call(MaGiamGiaSeeder::class);

        // ── Nhà phân phối demo (M7) ──
        $this->call(NhaPhanPhoiSeeder::class);

        // ── Liên hệ demo (M9) ──
        $this->call(LienHeSeeder::class);
    }
}
