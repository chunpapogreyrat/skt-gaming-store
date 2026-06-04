<?php

namespace App\Services;

use App\Models\DanhGiaSanPham;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SanPhamService
{
    public function getFilteredProducts(array $filters): LengthAwarePaginator
    {
        $query = SanPham::query()
            ->with(['danhMuc', 'thuongHieu', 'hinhAnh'])
            ->where('is_active', true);

        if (! empty($filters['q'])) {
            $keyword = trim((string) $filters['q']);
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('ten', 'like', "%{$keyword}%")
                    ->orWhere('mo_ta_ngan', 'like', "%{$keyword}%")
                    ->orWhereHas('thuongHieu', function ($brandQuery) use ($keyword) {
                        $brandQuery->where('ten', 'like', "%{$keyword}%");
                    });
            });
        }

        if (! empty($filters['category']) && $filters['category'] !== 'all') {
            $query->whereHas('danhMuc', function ($categoryQuery) use ($filters) {
                $categoryQuery->where('slug', $filters['category']);
            });
        }

        if (! empty($filters['brand']) && $filters['brand'] !== 'all') {
            $query->whereHas('thuongHieu', function ($brandQuery) use ($filters) {
                $brandQuery->where('slug', $filters['brand']);
            });
        }

        if (isset($filters['price_min']) && is_numeric($filters['price_min'])) {
            $query->where('gia_ban', '>=', (int) $filters['price_min']);
        }

        if (isset($filters['price_max']) && is_numeric($filters['price_max'])) {
            $query->where('gia_ban', '<=', (int) $filters['price_max']);
        }

        if (($filters['tag'] ?? null) === 'sale') {
            $query->where('is_sale', true);
        }

        if (($filters['tag'] ?? null) === 'hot') {
            $query->where('is_hot', true);
        }

        $this->applySort($query, (string) ($filters['sort'] ?? 'default'));

        $perPage = min(max((int) ($filters['per_page'] ?? 12), 6), 48);

        return $query->paginate($perPage)->withQueryString();
    }

    public function getCategories(): Collection
    {
        return DanhMuc::query()
            ->where('is_active', true)
            ->withCount(['sanPhams as products_count' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('thu_tu')
            ->orderBy('ten')
            ->get();
    }

    public function getBrands(): Collection
    {
        return ThuongHieu::query()
            ->where('is_active', true)
            ->withCount(['sanPhams as products_count' => function ($query) {
                $query->where('is_active', true);
            }])
            ->having('products_count', '>', 0)
            ->orderBy('ten')
            ->get();
    }

    public function getDetail(SanPham $sanPham): SanPham
    {
        abort_unless($sanPham->is_active, 404);

        $sanPham->increment('luot_xem');

        return $sanPham->load([
            'danhMuc',
            'thuongHieu',
            'hinhAnh',
            'bienThe',
            'thongSo',
            'danhGia.taiKhoan',
        ]);
    }

    public function getRelatedProducts(SanPham $sanPham, int $limit = 8): Collection
    {
        return SanPham::query()
            ->with(['danhMuc', 'thuongHieu', 'hinhAnh'])
            ->where('is_active', true)
            ->where('id', '!=', $sanPham->id)
            ->where('danh_muc_id', $sanPham->danh_muc_id)
            ->orderByDesc('is_hot')
            ->orderByDesc('luot_ban')
            ->limit($limit)
            ->get();
    }

    public function getPurchasedOrder(int $taiKhoanId, int $sanPhamId): ?DonHang
    {
        return DonHang::query()
            ->where('tai_khoan_id', $taiKhoanId)
            ->where('trang_thai', 'da_giao')
            ->whereHas('chiTiet', function ($query) use ($sanPhamId) {
                $query->where('san_pham_id', $sanPhamId);
            })
            ->latest('ngay_tao')
            ->first();
    }

    public function hasReviewed(int $taiKhoanId, int $sanPhamId): bool
    {
        return DanhGiaSanPham::query()
            ->where('tai_khoan_id', $taiKhoanId)
            ->where('san_pham_id', $sanPhamId)
            ->exists();
    }

    private function applySort($query, string $sort): void
    {
        match ($sort) {
            'price-asc' => $query->orderBy('gia_ban'),
            'price-desc' => $query->orderByDesc('gia_ban'),
            'name' => $query->orderBy('ten'),
            'newest' => $query->orderByDesc('ngay_tao'),
            'rating' => $query->orderByDesc('diem_danh_gia')->orderByDesc('so_luong_danh_gia'),
            'best-seller' => $query->orderByDesc('luot_ban'),
            default => $query->orderByDesc('is_hot')->orderByDesc('is_sale')->orderByDesc('ngay_tao'),
        };
    }
}
