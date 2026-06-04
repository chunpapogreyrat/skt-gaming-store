<?php

namespace App\Http\Controllers;

use App\Services\SanPhamService;

class DanhMucController extends Controller
{
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
