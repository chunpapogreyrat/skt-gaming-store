<?php

namespace App\Http\Controllers;

use App\Services\SanPhamService;

class DanhMucController extends Controller
{
    // Trả về danh sách danh mục kèm số lượng sản phẩm dưới dạng JSON cho sidebar
    public function sidebar(SanPhamService $sanPhamService)
    {
        return response()->json([
            'data' => $sanPhamService->getCategories()->map(function ($category) {
                return [
                    'ten' => $category->ten,
                    'slug' => $category->slug,
                    'products_count' => $category->products_count,
                ];
            }),
        ]);
    }
}
