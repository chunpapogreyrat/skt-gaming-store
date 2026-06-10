<?php

namespace Database\Seeders;

use App\Models\LienHe;
use Illuminate\Database\Seeder;

class LienHeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['ho_ten' => 'Trần Minh Quân', 'email' => 'quan.tran@gmail.com', 'so_dien_thoai' => '0905123456', 'chu_de' => 'tu-van', 'noi_dung' => 'Cho mình hỏi chuột Finalmouse còn hàng không, ship về Đà Nẵng mất bao lâu?', 'da_xu_ly' => false],
            ['ho_ten' => 'Lê Thị Hương', 'email' => 'huong.le@gmail.com', 'so_dien_thoai' => '0918777888', 'chu_de' => 'bao-hanh', 'noi_dung' => 'Bàn phím mình mua tháng trước bị liệt phím, bảo hành thế nào ạ?', 'da_xu_ly' => false],
            ['ho_ten' => 'Phạm Hoàng Long', 'email' => 'long.pham@gmail.com', 'so_dien_thoai' => null, 'chu_de' => 'setup', 'noi_dung' => 'Mình muốn build full setup trắng tầm 40 triệu, nhờ team tư vấn giúp.', 'da_xu_ly' => true],
        ];

        foreach ($data as $row) {
            LienHe::updateOrCreate(['email' => $row['email'], 'noi_dung' => $row['noi_dung']], $row);
        }
    }
}
