<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThemGioHangRequest;
use App\Http\Requests\CapNhatGioHangRequest;
use App\Services\GioHangService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GioHangController extends Controller
{
    // Khởi tạo controller, tiêm service xử lý giỏ hàng
    public function __construct(
        private GioHangService $gioHangService
    ) {}

    // Hiển thị trang giỏ hàng cùng tổng tiền
    public function index()
    {
        $gioHang = $this->gioHangService->layGioHang();
        $tongTien = $this->gioHangService->tinhTong();

        return view('gio-hang.cart', compact('gioHang', 'tongTien'));
    }

    // Thêm sản phẩm vào giỏ hàng, trả về JSON kèm số lượng và tổng tiền
    public function them(ThemGioHangRequest $request): JsonResponse
    {
        $item = $this->gioHangService->themSanPham(
            $request->san_pham_id,
            $request->input('so_luong', 1),
            $request->mau_sac
        );

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng',
            'data' => [
                'item' => $item,
                'cart_count' => $this->gioHangService->demSoLuong(),
                'tong' => $this->gioHangService->tinhTong(),
            ],
        ]);
    }

    // Cập nhật số lượng một mục trong giỏ hàng, trả về JSON kèm tổng tiền
    public function capNhat(CapNhatGioHangRequest $request, int $itemId): JsonResponse
    {
        $item = $this->gioHangService->capNhatSoLuong($itemId, $request->so_luong);
        $tongTien = $this->gioHangService->tinhTong();

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật số lượng',
            'data' => [
                'item' => $item,
                'tong' => $tongTien,
                'cart_count' => $this->gioHangService->demSoLuong(),
            ],
        ]);
    }

    // Xóa một sản phẩm khỏi giỏ hàng, trả về JSON kèm tổng tiền còn lại
    public function xoa(int $itemId): JsonResponse
    {
        $this->gioHangService->xoaItem($itemId);
        $tongTien = $this->gioHangService->tinhTong();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'data' => [
                'tong' => $tongTien,
                'cart_count' => $this->gioHangService->demSoLuong(),
            ],
        ]);
    }

    // Xóa toàn bộ sản phẩm trong giỏ hàng, trả về JSON với số lượng bằng 0
    public function xoaTatCa(): JsonResponse
    {
        $this->gioHangService->xoaTatCa();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng',
            'data' => [
                'tong' => $this->gioHangService->tinhTong(),
                'cart_count' => 0,
            ],
        ]);
    }

    // Trả về số lượng sản phẩm hiện có trong giỏ hàng dưới dạng JSON
    public function demSoLuong(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ['cart_count' => $this->gioHangService->demSoLuong()],
        ]);
    }
}
