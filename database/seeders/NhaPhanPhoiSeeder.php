<?php

namespace Database\Seeders;

use App\Models\NhaPhanPhoi;
use Illuminate\Database\Seeder;

class NhaPhanPhoiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ten' => 'Finalmouse Inc.', 'mo_ta' => 'Chuột gaming cao cấp', 'email' => 'contact@finalmouse.com', 'sdt' => '0800 100 200', 'quoc_gia' => 'Mỹ', 'icon' => 'fa-computer-mouse', 'so_sku' => 40, 'hop_dong_den' => '2026-12-31', 'trang_thai' => 'active'],
            ['ten' => 'Wooting B.V.', 'mo_ta' => 'Bàn phím analog', 'email' => 'info@wooting.io', 'sdt' => '0800 200 300', 'quoc_gia' => 'Hà Lan', 'icon' => 'fa-keyboard', 'so_sku' => 28, 'hop_dong_den' => '2026-06-30', 'trang_thai' => 'active'],
            ['ten' => 'Pulsar Gaming Gear', 'mo_ta' => 'Chuột & phụ kiện', 'email' => 'support@pulsargaminggear.com', 'sdt' => '0800 300 400', 'quoc_gia' => 'Hàn Quốc', 'icon' => 'fa-computer-mouse', 'so_sku' => 35, 'hop_dong_den' => '2027-03-31', 'trang_thai' => 'active'],
            ['ten' => 'Endgame Gear', 'mo_ta' => 'Lót chuột & phụ kiện', 'email' => 'hello@endgamegear.com', 'sdt' => '0800 400 500', 'quoc_gia' => 'Đức', 'icon' => 'fa-square', 'so_sku' => 22, 'hop_dong_den' => '2025-12-31', 'trang_thai' => 'active'],
            ['ten' => 'Razer Inc.', 'mo_ta' => 'Gaming peripherals', 'email' => 'biz@razer.com', 'sdt' => '0800 500 600', 'quoc_gia' => 'Singapore', 'icon' => 'fa-bolt', 'so_sku' => 18, 'hop_dong_den' => '2025-06-30', 'trang_thai' => 'paused'],
            ['ten' => 'SteelSeries ApS', 'mo_ta' => 'Peripheral gaming', 'email' => 'partner@steelseries.com', 'sdt' => '0800 600 700', 'quoc_gia' => 'Đan Mạch', 'icon' => 'fa-gamepad', 'so_sku' => 15, 'hop_dong_den' => '2025-01-31', 'trang_thai' => 'ended'],
        ];

        foreach ($data as $row) {
            NhaPhanPhoi::updateOrCreate(['ten' => $row['ten']], $row);
        }
    }
}
