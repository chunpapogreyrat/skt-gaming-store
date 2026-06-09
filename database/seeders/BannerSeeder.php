<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            ['tieu_de' => 'Gaming Gear Đỉnh Cao', 'mo_ta' => 'Trang bị vũ khí — chinh phục mọi chiến trường', 'hinh_anh' => 'assets/images/slider/1.jpg'],
            ['tieu_de' => 'Chuột Gaming Pro', 'mo_ta' => 'Cảm biến quang học bậc nhất — phản xạ 0 độ trễ', 'hinh_anh' => 'assets/images/slider/2.jpg'],
            ['tieu_de' => 'Bàn Phím Cơ Custom', 'mo_ta' => 'Hall Effect & Rapid Trigger — cú bấm hoàn hảo nhất', 'hinh_anh' => 'assets/images/slider/3.jpg'],
            ['tieu_de' => 'Màn Hình Esports 360Hz', 'mo_ta' => 'Từng khung hình là lợi thế — DyAc+ không bóng mờ', 'hinh_anh' => 'assets/images/slider/4.jpg'],
            ['tieu_de' => 'Setup RGB Cá Tính', 'mo_ta' => 'Góc chơi game nổi bật — đồng bộ từ bàn phím đến lót chuột', 'hinh_anh' => 'assets/images/slider/5.png'],
            ['tieu_de' => 'Màn Hình Gaming Sắc Nét', 'mo_ta' => 'Hiển thị mượt mà — tối ưu từng pha xử lý tốc độ cao', 'hinh_anh' => 'assets/images/slider/screen.png'],
        ];

        foreach ($banners as $i => $b) {
            Banner::updateOrCreate(
                ['hinh_anh' => $b['hinh_anh']],
                array_merge($b, ['thu_tu' => $i, 'is_active' => true, 'link' => route('products.index')]),
            );
        }
    }
}
