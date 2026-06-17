<?php

namespace Database\Seeders;

use App\Models\BienTheSanPham;
use App\Models\HinhAnhSanPham;
use App\Models\SanPham;
use Illuminate\Database\Seeder;

/**
 * Biến thể màu CHÍNH XÁC theo ảnh thật của sản phẩm.
 *
 * Dữ liệu màu được xác định bằng cách xem trực tiếp ảnh từng sản phẩm:
 * mỗi màu = màu thực sự xuất hiện trong ảnh, mã hex lấy từ thân sản phẩm,
 * và gắn với đúng ảnh để trang khách đổi ảnh khi chọn màu (kiểu Shopee).
 *
 * Chạy SAU ProductsSeeder (ProductsSeeder tạo ảnh + biến thể mặc định từ info.txt,
 * seeder này ghi đè lại biến thể cho các SP có ảnh nhiều màu).
 *
 * Mỗi phần tử: 'slug' => [ ['tên', '#hex', 'ảnh.webp'|null], ... ]
 */
class BienTheMauSeeder extends Seeder
{
    private array $map = [
        // ── Bàn phím ──
        'arc65'           => [['Đen (Black)', '#2b2b2d', '1.webp']],
        'centauri'        => [['Trắng (White)', '#e9e9e7', '1.webp']],
        'luce60'          => [['Bạc (Silver)', '#cfd0d2', '1.webp']],
        'made68-ultra-v2' => [['Đen (Black)', '#1c1c20', '1.webp'], ['Trắng (White)', '#e6e7ea', '2.webp']],
        'pcmk'            => [['Trắng (White)', '#dcdcde', '1.webp']],
        'realforce-r4'    => [['Trắng (White)', '#ececea', '1.webp']],
        'wooting'         => [['Đen (Black)', '#1a1a1a', '2.webp']],
        'xpunk'           => [['Hồng (Pink)', '#f0a9c0', '3.webp'], ['Trắng hồng (Pink White)', '#f3d7e0', '2.webp']],

        // ── Chuột ──
        'akitsu'          => [['Đen (Black)', '#2b2b2d', '2.webp'], ['Trắng (White)', '#eef0f1', '3.webp']],
        'beast-x-max'     => [['Xanh ngọc (Cyan)', '#9ad8da', '1.webp'], ['Đỏ đen (Red Black)', '#a52230', '2.webp'], ['Trắng xanh (White Blue)', '#bfe0dd', '3.webp']],
        'finalmouse-ulx'  => [['Xám (Grey)', '#a7a39a', '2.webp'], ['Đỏ đô (Maroon)', '#7c2230', '3.webp'], ['Xanh lá (Green)', '#1f5d44', '4.webp'], ['Tím (Purple)', '#3a2a3f', '5.webp']],
        'frostlord'       => [['Trắng (White)', '#dfe3e6', '2.webp'], ['Đen (Black)', '#1e2329', null]],
        'maya-x'          => [['Hồng (Pink)', '#f4a9c4', '1.webp'], ['Tím (Purple)', '#9c5fc4', '2.webp'], ['Xanh ngọc (Teal)', '#34c6b6', '3.webp']],
        'superstrike'     => [['Trắng (White)', '#f2f2f2', '1.webp'], ['Đen (Black)', '#1a1a1a', null]],
        'sycrox-v6'       => [['Xanh băng (Ice Blue)', '#9cc6d6', '1.webp'], ['Trắng (White)', '#f4f4f4', '2.webp'], ['Đen (Black)', '#1a1a1a', '3.webp']],
        'viperv4pro'      => [['Đen (Black)', '#161616', '1.webp'], ['Trắng (White)', '#f3f3f3', '2.webp']],
        'x2cl'            => [['Đen (Black)', '#222426', '1.webp'], ['Trắng (White)', '#f4f4f4', '2.webp'], ['Xanh ngọc (Teal Green)', '#7cc4ad', '3.webp']],

        // ── Lót chuột ──
        'hayate-otsu-v2'  => [['Đen (Black)', '#1a1a1a', '1.webp'], ['Đỏ (Red)', '#c1272d', '2.webp']],
        'hien'            => [['Đen (Black)', '#1c1c1c', '1.webp'], ['Đỏ (Red)', '#c4302b', '2.webp']],
        'saturn-pro'      => [['Đen (Black)', '#181818', '1.webp'], ['Đỏ (Red)', '#c0322f', '2.webp'], ['Xanh dương (Blue)', '#2a2d5e', '3.webp']],
        'type99'          => [['Đen (Black)', '#1a1a1a', '1.webp'], ['Xanh rêu (Olive Green)', '#8b9a3b', '2.webp'], ['Xám nâu (Taupe Grey)', '#574f47', '3.webp']],
        'wl-qisha'        => [['Đen (Black)', '#262321', '1.webp']],
        'yuki-aim-demon1' => [['Tím (Purple)', '#5b3a6e', '1.webp']],
        'yuki-aim-monokuro' => [['Đen (Black)', '#1c1c1e', '1.webp']],
        'yuki-aim-oni'    => [['Trắng (White)', '#c9c7c8', '1.webp']],

        // ── Phụ kiện ──
        'pulsar-supergrip'       => [['Đen (Black)', '#262626', '1.webp']],
        'pulsar-x-prx-arm-sleeve' => [['Xanh tím (Navy)', '#2b2178', '1.webp']],
    ];

    public function run(): void
    {
        $doi = 0;

        foreach ($this->map as $slug => $colors) {
            $sp = SanPham::where('slug', $slug)->first();
            if (! $sp) {
                continue;
            }

            // Map basename ảnh → id ảnh của chính sản phẩm này
            $anhTheoTen = HinhAnhSanPham::where('san_pham_id', $sp->id)->get()
                ->mapWithKeys(fn ($a) => [basename($a->duong_dan) => $a->id]);

            $n = max(1, count($colors));
            $tonMoi = max(0, (int) $sp->so_luong_ton);
            $tonChia = intdiv($tonMoi, $n);
            $tonDu = $tonMoi % $n;

            // Dựng lại toàn bộ biến thể cho SP này
            BienTheSanPham::where('san_pham_id', $sp->id)->delete();

            foreach ($colors as $i => [$ten, $hex, $anhFile]) {
                $ton = $tonChia + ($i < $tonDu ? 1 : 0);

                BienTheSanPham::create([
                    'san_pham_id'    => $sp->id,
                    'ten_bien_the'   => $ten,
                    'ma_hex'         => $hex,
                    'hinh_anh_id'    => $anhFile ? ($anhTheoTen[$anhFile] ?? null) : null,
                    'gia_chenh_lech' => 0,
                    'so_luong_ton'   => $ton,
                    'is_active'      => true,
                ]);
            }

            $doi++;
        }

        $this->command->info("✓ Cập nhật biến thể màu theo ảnh cho {$doi} sản phẩm.");
    }
}
