<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDanhGiaRequest;
use App\Models\DanhGiaSanPham;
use App\Models\SanPham;
use App\Services\SanPhamService;

class DanhGiaController extends Controller
{
    // Lưu đánh giá sản phẩm của người dùng và cập nhật lại điểm đánh giá trung bình
    public function store(StoreDanhGiaRequest $request, SanPham $sanPham, SanPhamService $sanPhamService)
    {
        $user = $request->user();

        // Mỗi tài khoản chỉ đánh giá 1 lần cho mỗi sản phẩm
        if ($sanPhamService->hasReviewed($user->id, $sanPham->id)) {
            return back()->withErrors([
                'review' => 'Bạn đã đánh giá sản phẩm này rồi.',
            ]);
        }

        // Cho phép mọi khách đã đăng nhập đánh giá; nếu có đơn đã giao thì đánh dấu "đã mua hàng"
        $purchasedOrder = $sanPhamService->getPurchasedOrder($user->id, $sanPham->id);

        DanhGiaSanPham::create([
            'san_pham_id' => $sanPham->id,
            'tai_khoan_id' => $user->id,
            'don_hang_id' => optional($purchasedOrder)->id,
            'so_sao' => $request->integer('so_sao'),
            'noi_dung' => $request->input('noi_dung'),
            'is_verified_purchase' => (bool) $purchasedOrder,
            'is_active' => true,
        ]);

        // Cập nhật rating theo kiểu cộng dồn (giữ số liệu seed sẵn, cộng thêm review mới)
        $soCu = (int) $sanPham->so_luong_danh_gia;
        $diemCu = (float) $sanPham->diem_danh_gia;
        $soMoi = $soCu + 1;
        $diemMoi = round((($diemCu * $soCu) + $request->integer('so_sao')) / $soMoi, 1);
        $sanPham->forceFill([
            'diem_danh_gia' => $diemMoi,
            'so_luong_danh_gia' => $soMoi,
        ])->save();

        return redirect()
            ->route('products.show', $sanPham)
            ->with('success', 'Đánh giá của bạn đã được ghi nhận.');
    }
}
