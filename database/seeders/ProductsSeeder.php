<?php

namespace Database\Seeders;

use App\Models\BienTheSanPham;
use App\Models\DanhMuc;
use App\Models\HinhAnhSanPham;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    /** Mapping slug danh mục sang tên hiển thị + thứ tự */
    private array $categories = [
        'keyboard'  => ['ten' => 'Bàn phím cơ',  'thu_tu' => 1],
        'mice'      => ['ten' => 'Chuột gaming', 'thu_tu' => 2],
        'mousepad'  => ['ten' => 'Lót chuột',    'thu_tu' => 3],
        'accessory' => ['ten' => 'Phụ kiện',     'thu_tu' => 4],
    ];

    public function run(): void
    {
        // ── 1. Seed danh mục ─────────────────────────────────
        $danhMucIds = [];
        foreach ($this->categories as $slug => $meta) {
            $dm = DanhMuc::updateOrCreate(
                ['slug' => $slug],
                ['ten' => $meta['ten'], 'thu_tu' => $meta['thu_tu'], 'is_active' => true]
            );
            $danhMucIds[$slug] = $dm->id;
        }

        // ── 2. Quét tất cả info.txt ──────────────────────────
        $productsBase = public_path('assets/images/products');
        $count = 0;

        foreach ($this->categories as $catSlug => $_) {
            $categoryDir = "$productsBase/$catSlug";
            if (!is_dir($categoryDir)) continue;

            foreach (scandir($categoryDir) as $entry) {
                if ($entry === '.' || $entry === '..') continue;
                $productDir = "$categoryDir/$entry";
                if (!is_dir($productDir)) continue;

                $infoFile = "$productDir/info.txt";
                if (!file_exists($infoFile)) continue;

                $data = $this->parseInfo($infoFile, $entry, $catSlug);
                if (!$data) continue;

                // ── Thương hiệu ──
                $thuongHieuId = null;
                if ($data['brand']) {
                    $brandSlug = Str::slug($data['brand']);
                    $th = ThuongHieu::updateOrCreate(
                        ['slug' => $brandSlug],
                        ['ten' => $data['brand'], 'is_active' => true]
                    );
                    $thuongHieuId = $th->id;
                }

                // ── Sản phẩm ──
                $sp = SanPham::updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'danh_muc_id'        => $danhMucIds[$catSlug],
                        'thuong_hieu_id'     => $thuongHieuId,
                        'ten'                => $data['name'],
                        'mo_ta_ngan'         => mb_substr($data['desc'], 0, 480),
                        'mo_ta_day_du'       => $data['desc'],
                        'gia_ban'            => $data['price'],
                        'gia_goc'            => $data['old_price'],
                        'so_luong_ton'       => $data['stock'],
                        'diem_danh_gia'      => $data['stars'],
                        'so_luong_danh_gia'  => max(1, (int) round($data['stars'] * 20)),
                        'is_hot'             => $data['stars'] >= 4.7,
                        'is_sale'            => $data['old_price'] !== null,
                        'is_active'          => true,
                    ]
                );

                // ── Hình ảnh ──
                HinhAnhSanPham::where('san_pham_id', $sp->id)->delete();
                foreach ($data['images'] as $i => $img) {
                    HinhAnhSanPham::create([
                        'san_pham_id' => $sp->id,
                        'duong_dan'   => "assets/images/products/$catSlug/{$data['slug']}/$img",
                        'thu_tu'      => $i,
                        'is_main'     => $i === 0,
                    ]);
                }

                // ── Biến thể màu (từ p8) ──
                BienTheSanPham::where('san_pham_id', $sp->id)->delete();
                foreach ($data['colors'] as $color) {
                    BienTheSanPham::create([
                        'san_pham_id'    => $sp->id,
                        'ten_bien_the'   => $color['name'],
                        'ma_hex'         => $color['hex'],
                        'gia_chenh_lech' => 0,
                        'so_luong_ton'   => max(1, intdiv($data['stock'], max(1, count($data['colors'])))),
                        'is_active'      => true,
                    ]);
                }

                $count++;
            }
        }

        $this->command->info("✓ Seeded {$count} sản phẩm từ assets/images/products/");
    }

    /** Parse info.txt thành array dữ liệu */
    private function parseInfo(string $file, string $folderName, string $catSlug): ?array
    {
        $text = file_get_contents($file);
        if ($text === false) return null;

        // Đảm bảo UTF-8 (file gốc có thể là UTF-8 with/without BOM)
        $text = preg_replace('/^\xEF\xBB\xBF/', '', $text);

        $lines = preg_split('/\r\n|\r|\n/', $text);
        $name = trim($lines[0] ?? $folderName);
        $brand = '';
        $desc = '';
        $stars = 4.5;
        $price = 0;
        $oldPrice = null;
        $stock = 10;
        $colors = [];
        $images = ['1.webp'];
        $slug = $folderName;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^p1.*?:\s*(.+)$/u', $line, $m))        $brand = trim($m[1]);
            elseif (preg_match('/^p2.*?:\s*(.+)$/u', $line, $m))    $name = trim($m[1]);
            elseif (preg_match('/^p3.*?:\s*(.+)$/u', $line, $m))    $desc = trim($m[1]);
            elseif (preg_match('/^p4.*?:\s*([\d.,]+)/u', $line, $m)) $stars = (float) str_replace(',', '.', $m[1]);
            elseif (preg_match('/Giá bán.*?:\s*([\d.,]+)\s*đ/iu', $line, $m)) {
                $price = (int) preg_replace('/\D/', '', $m[1]);
            }
            elseif (preg_match('/^p5.*?:\s*([\d.,]+)\s*đ/iu', $line, $m) && $price === 0) {
                $price = (int) preg_replace('/\D/', '', $m[1]);
            }
            elseif (preg_match('/^p6.*?:\s*(\d+)/u', $line, $m))    $stock = (int) $m[1];
            elseif (preg_match('/^p8.*?:\s*(.+)$/u', $line, $m))    {
                $colors = $this->parseColors($m[1]);
            }
            elseif (str_starts_with($line, '[Dữ liệu hệ thống]') || str_starts_with($line, '[Du lieu')) {
                if (preg_match('/slug=([^\s|]+)/u', $line, $m))   $slug = trim($m[1]);
                if (preg_match('/images=([^\s|]+)/u', $line, $m)) {
                    $images = array_filter(array_map('trim', explode(';', $m[1])));
                }
            }
        }

        // Fallback giá nếu chưa parse được — đặt giá mặc định theo danh mục
        if ($price === 0) {
            $defaultPrices = ['keyboard' => 2500000, 'mice' => 2000000, 'mousepad' => 800000, 'accessory' => 500000];
            $price = $defaultPrices[$catSlug] ?? 1000000;
        }

        // Random sale: 30% sản phẩm có sale 10-25%
        if (crc32($slug) % 10 < 3) {
            $oldPrice = (int) round($price / (1 - (10 + (crc32($slug) % 16)) / 100));
        }

        if (empty($colors)) {
            $colors = [['name' => 'Mặc định', 'hex' => '#1a1a1a']];
        }

        if (empty($images)) {
            $images = ['1.webp'];
        }

        return [
            'name'      => $name,
            'brand'     => $brand,
            'desc'      => $desc,
            'stars'     => $stars,
            'price'     => $price,
            'old_price' => $oldPrice,
            'stock'     => $stock,
            'colors'    => $colors,
            'images'    => $images,
            'slug'      => $slug,
        ];
    }

    /** Parse màu từ "Đen (Black) / Bạc (Silver)" → [['name'=>'Đen','hex'=>'#000'], ...] */
    private function parseColors(string $raw): array
    {
        $map = [
            'đen' => '#1a1a1a', 'den' => '#1a1a1a', 'black' => '#1a1a1a',
            'trắng' => '#f5f5f5', 'trang' => '#f5f5f5', 'white' => '#f5f5f5',
            'bạc' => '#c0c0c0', 'bac' => '#c0c0c0', 'silver' => '#c0c0c0',
            'đỏ' => '#e63946', 'do' => '#e63946', 'red' => '#e63946',
            'xanh' => '#2a9d8f', 'blue' => '#1d4ed8', 'green' => '#16a34a',
            'hồng' => '#ec4899', 'hong' => '#ec4899', 'pink' => '#ec4899',
            'tím' => '#a855f7', 'tim' => '#a855f7', 'purple' => '#a855f7',
            'vàng' => '#facc15', 'vang' => '#facc15', 'yellow' => '#facc15', 'gold' => '#d4af37',
            'cam' => '#fb923c', 'orange' => '#fb923c',
        ];

        $parts = preg_split('#[/,;]#', $raw);
        $colors = [];
        foreach ($parts as $part) {
            $part = trim(preg_replace('/[()]/', '', $part));
            $part = trim(preg_replace('/\.+$/', '', $part));
            if ($part === '') continue;
            $lower = mb_strtolower($part);
            $hex = '#888';
            foreach ($map as $key => $val) {
                if (mb_strpos($lower, $key) !== false) { $hex = $val; break; }
            }
            $colors[] = ['name' => $part, 'hex' => $hex];
        }
        return array_slice($colors, 0, 4);
    }
}
