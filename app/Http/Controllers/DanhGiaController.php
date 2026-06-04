<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDanhGiaRequest;
use App\Models\DanhGiaSanPham;
use App\Models\SanPham;
use App\Services\SanPhamService;

class DanhGiaController extends Controller
{
    public function store(StoreDanhGiaRequest $request, SanPham $sanPham, SanPhamService $sanPhamService)
    {
        $user = $request->user();
        $purchasedOrder = $sanPhamService->getPurchasedOrder($user->id, $sanPham->id);

        if (! $purchasedOrder) {
            return back()->withErrors([
                'review' => 'Bạn cần mua và nhận sản phẩm này trước khi đánh giá.',
            ])->withInput();
        }

        if ($sanPhamService->hasReviewed($user->id, $sanPham->id)) {
            return back()->withErrors([
                'review' => 'Bạn đã đánh giá sản phẩm này rồi.',
            ]);
        }

        DanhGiaSanPham::create([
            'san_pham_id' => $sanPham->id,
            'tai_khoan_id' => $user->id,
            'don_hang_id' => $purchasedOrder->id,
            'so_sao' => $request->integer('so_sao'),
            'noi_dung' => $request->input('noi_dung'),
            'is_verified_purchase' => true,
            'is_active' => true,
        ]);

        return redirect()
            ->route('products.show', $sanPham)
            ->with('success', 'Đánh giá của bạn đã được ghi nhận.');
    }
}
