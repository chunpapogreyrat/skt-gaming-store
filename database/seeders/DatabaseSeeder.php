<?php

namespace Database\Seeders;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\TaiKhoan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        TaiKhoan::updateOrCreate(
            ['email' => 'admin@skt.test'],
            [
                'ho_ten' => 'SKT Admin',
                'mat_khau' => Hash::make('Admin@12345'),
                'hang_thanh_vien' => 'diamond',
                'diem_tich_luy' => 9999,
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        TaiKhoan::updateOrCreate(
            ['email' => 'khach@skt.test'],
            [
                'ho_ten' => 'Khach Hang Demo',
                'mat_khau' => Hash::make('User@12345'),
                'hang_thanh_vien' => 'gold',
                'diem_tich_luy' => 1250,
                'role' => 'customer',
                'is_active' => true,
            ]
        );

        if (! Schema::hasTable('san_phams') || ! Schema::hasTable('don_hangs') || ! Schema::hasTable('chi_tiet_don_hang')) {
            return;
        }

        $customer = TaiKhoan::where('email', 'khach@skt.test')->first();
        $product = SanPham::with('hinhAnh')->where('slug', 'akitsu')->first();

        if (! $customer || ! $product) {
            return;
        }

        $order = DonHang::updateOrCreate(
            ['ma_don' => '#SKT-DEMO-001'],
            [
                'tai_khoan_id' => $customer->id,
                'ten_nguoi_nhan' => $customer->ho_ten,
                'so_dien_thoai' => '0900000000',
                'dia_chi_giao_hang' => 'Demo address',
                'trang_thai' => 'da_giao',
                'tam_tinh' => $product->gia_ban,
                'tong_tien' => $product->gia_ban,
            ]
        );

        ChiTietDonHang::updateOrCreate(
            [
                'don_hang_id' => $order->id,
                'san_pham_id' => $product->id,
            ],
            [
                'ten_san_pham' => $product->ten,
                'hinh_anh' => $product->mainImagePath(),
                'so_luong' => 1,
                'don_gia' => $product->gia_ban,
                'thanh_tien' => $product->gia_ban,
            ]
        );
    }
}
