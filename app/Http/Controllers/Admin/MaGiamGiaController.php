<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuuMaGiamGiaRequest;
use App\Models\MaGiamGia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaGiamGiaController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $maGiamGias = MaGiamGia::latest()->paginate(5);

        // AJAX (phân trang / reload bảng) → trả về HTML partial của bảng
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.coupon._table', compact('maGiamGias'))->render(),
            ]);
        }

        return view('admin.coupon.index', compact('maGiamGias'));
    }

    public function store(LuuMaGiamGiaRequest $request): RedirectResponse|JsonResponse
    {
        $coupon = MaGiamGia::create($request->validated());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã tạo mã ' . $coupon->ma_code]);
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá');
    }

    public function update(LuuMaGiamGiaRequest $request, int $id): RedirectResponse|JsonResponse
    {
        $coupon = MaGiamGia::findOrFail($id);
        $coupon->update($request->validated());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã cập nhật mã ' . $coupon->ma_code]);
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá');
    }

    public function destroy(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $coupon = MaGiamGia::findOrFail($id);
        $code = $coupon->ma_code;
        $coupon->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa mã ' . $code]);
        }

        return redirect()->route('admin.coupons.index')->with('success', 'Đã xóa mã giảm giá');
    }
}
