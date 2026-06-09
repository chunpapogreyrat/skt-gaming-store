<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Title/mô tả khớp ĐÚNG với từng ảnh (theo bản thiết kế gốc index.html)
        $banners = [
            ['tieu_de' => 'Lót Chuột Anime Cỡ Lớn', 'mo_ta' => 'Deskmat khổ rộng in sắc nét — nâng tầm góc chơi game', 'hinh_anh' => 'assets/images/slider/1.jpg'],
            ['tieu_de' => 'Finalmouse Prophecy', 'mo_ta' => 'Chuột siêu nhẹ vân tổ ong — 4 phiên bản màu sưu tầm', 'hinh_anh' => 'assets/images/slider/2.jpg'],
            ['tieu_de' => 'Arbiter Studio Akitsu', 'mo_ta' => 'Chuột gaming siêu nhẹ — khắc hoạ tiết thủ công độc bản', 'hinh_anh' => 'assets/images/slider/3.jpg'],
            ['tieu_de' => 'Wooting 60HE', 'mo_ta' => 'Bàn phím Hall Effect — Rapid Trigger phản hồi tức thì', 'hinh_anh' => 'assets/images/slider/4.jpg'],
            ['tieu_de' => 'Yuki Aim × Demon1', 'mo_ta' => 'Lót chuột Glass & Cloth — đặt trước phiên bản giới hạn', 'hinh_anh' => 'assets/images/slider/5.png'],
            ['tieu_de' => 'Setup Gaming RGB', 'mo_ta' => 'Góc chiến đồng bộ ánh sáng — từ PC đến phụ kiện', 'hinh_anh' => 'assets/images/slider/screen.png'],
        ];

        foreach ($banners as $i => $b) {
            Banner::updateOrCreate(
                ['hinh_anh' => $b['hinh_anh']],
                array_merge($b, ['thu_tu' => $i, 'is_active' => true, 'link' => route('products.index')]),
            );
        }
    }
}
