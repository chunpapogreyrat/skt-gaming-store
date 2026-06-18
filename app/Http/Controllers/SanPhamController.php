<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\Wishlist;
use App\Services\SanPhamService;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    // Hien thi danh sach san pham da loc theo tieu chi, kem danh muc, thuong hieu va bo loc hien tai
    public function index(Request $request, SanPhamService $sanPhamService)
    {
        return view('products.index', [
            'products' => $sanPhamService->getFilteredProducts($request->query()),
            'categories' => $sanPhamService->getCategories(),
            'brands' => $sanPhamService->getBrands(),
            'filters' => $request->query(),
        ]);
    }

    // Hien thi chi tiet san pham, san pham lien quan va trang thai wishlist/quyen danh gia cua nguoi dung
    public function show(SanPham $sanPham, SanPhamService $sanPhamService)
    {
        $sanPham = $sanPhamService->getDetail($sanPham);
        $user = auth()->user();
        $purchasedOrder = $user ? $sanPhamService->getPurchasedOrder($user->id, $sanPham->id) : null;
        $hasReviewed = $user ? $sanPhamService->hasReviewed($user->id, $sanPham->id) : false;
        $wishlistItem = $user
            ? Wishlist::where('tai_khoan_id', $user->id)->where('san_pham_id', $sanPham->id)->first()
            : null;

        return view('products.show', [
            'product' => $sanPham,
            'relatedProducts' => $sanPhamService->getRelatedProducts($sanPham),
            'canReview' => (bool) $purchasedOrder && ! $hasReviewed,
            'hasReviewed' => $hasReviewed,
            'wishlistItem' => $wishlistItem,
        ]);
    }
}
