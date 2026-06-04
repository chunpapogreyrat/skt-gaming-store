<?php

namespace App\Http\Controllers;

use App\Services\GioHangService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaGiamGiaController extends Controller
{
    public function __construct(
        private GioHangService $gioHangService
    ) {}

    public function apDung(Request $request): JsonResponse
    {
        $request->validate([
            'ma_code' => 'required|string|max:50',
        ]);

        $result = $this->gioHangService->apDungMaGiamGia($request->ma_code);

        return response()->json($result);
    }

    public function huy(): JsonResponse
    {
        session()->forget('ma_giam_gia_id');
        $tongTien = $this->gioHangService->tinhTong();

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy mã giảm giá',
            'data' => $tongTien,
        ]);
    }
}
