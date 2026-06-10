<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuuMaGiamGiaRequest;
use App\Models\MaGiamGia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaGiamGiaController extends Controller
{
    public function index(Request $request): View
    {
        $query = MaGiamGia::query()->latest();

        if ($tuKhoa = $request->query('q')) {
            $query->where('ma_code', 'like', "%{$tuKhoa}%");
        }

        $maGiamGias = $query->paginate(15)->withQueryString();

        return view('admin.coupon.index', compact('maGiamGias'));
    }

    public function create(): View
    {
        return view('admin.coupon.form', ['maGiamGia' => new MaGiamGia()]);
    }

    public function store(LuuMaGiamGiaRequest $request): RedirectResponse
    {
        MaGiamGia::create($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá');
    }

    public function edit(int $id): View
    {
        return view('admin.coupon.form', ['maGiamGia' => MaGiamGia::findOrFail($id)]);
    }

    public function update(LuuMaGiamGiaRequest $request, int $id): RedirectResponse
    {
        MaGiamGia::findOrFail($id)->update($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá');
    }

    public function destroy(int $id): RedirectResponse
    {
        MaGiamGia::findOrFail($id)->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Đã xóa mã giảm giá');
    }
}
