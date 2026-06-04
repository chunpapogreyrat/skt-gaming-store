<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuuMaGiamGiaRequest;
use App\Models\MaGiamGia;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaGiamGiaController extends Controller
{
    public function index(): View
    {
        $maGiamGias = MaGiamGia::latest()->paginate(15);

        return view('admin.coupon.index', compact('maGiamGias'));
    }

    public function store(LuuMaGiamGiaRequest $request): RedirectResponse
    {
        MaGiamGia::create($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá');
    }

    public function update(LuuMaGiamGiaRequest $request, int $id): RedirectResponse
    {
        $coupon = MaGiamGia::findOrFail($id);
        $coupon->update($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá');
    }

    public function destroy(int $id): RedirectResponse
    {
        MaGiamGia::findOrFail($id)->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Đã xóa mã giảm giá');
    }
}
