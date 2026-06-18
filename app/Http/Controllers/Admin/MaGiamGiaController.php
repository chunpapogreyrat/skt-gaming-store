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
    // Hiển thị danh sách mã giảm giá, hỗ trợ tìm kiếm theo mã code và phân trang
    public function index(Request $request): View
    {
        $query = MaGiamGia::query()->latest();

        if ($tuKhoa = $request->query('q')) {
            $query->where('ma_code', 'like', "%{$tuKhoa}%");
        }

        $maGiamGias = $query->paginate(15)->withQueryString();

        return view('admin.coupon.index', compact('maGiamGias'));
    }

    // Hiển thị form tạo mới mã giảm giá
    public function create(): View
    {
        return view('admin.coupon.form', ['maGiamGia' => new MaGiamGia()]);
    }

    // Lưu mã giảm giá mới vào cơ sở dữ liệu sau khi xác thực dữ liệu
    public function store(LuuMaGiamGiaRequest $request): RedirectResponse
    {
        MaGiamGia::create($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá');
    }

    // Hiển thị form chỉnh sửa mã giảm giá theo id
    public function edit(int $id): View
    {
        return view('admin.coupon.form', ['maGiamGia' => MaGiamGia::findOrFail($id)]);
    }

    // Cập nhật thông tin mã giảm giá theo id sau khi xác thực dữ liệu
    public function update(LuuMaGiamGiaRequest $request, int $id): RedirectResponse
    {
        MaGiamGia::findOrFail($id)->update($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá');
    }

    // Bật/tắt trạng thái kích hoạt của mã giảm giá theo id
    public function toggle(int $id): RedirectResponse
    {
        $ma = MaGiamGia::findOrFail($id);
        $ma->update(['trang_thai' => !$ma->trang_thai]);

        return back()->with('success', 'Đã ' . ($ma->trang_thai ? 'bật' : 'tắt') . ' mã ' . $ma->ma_code);
    }

    // Xóa mã giảm giá khỏi cơ sở dữ liệu theo id
    public function destroy(int $id): RedirectResponse
    {
        MaGiamGia::findOrFail($id)->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Đã xóa mã giảm giá');
    }
}
