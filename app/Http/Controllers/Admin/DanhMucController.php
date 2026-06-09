<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuuDanhMucRequest;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DanhMucController extends Controller
{
    public function index(): View
    {
        $danhMucs = DanhMuc::withCount('sanPhams')
            ->orderBy('thu_tu')
            ->orderBy('ten')
            ->paginate(15);

        $tongDanhMuc = DanhMuc::count();
        $tongSanPham = SanPham::count();

        return view('admin.danh-muc.index', compact('danhMucs', 'tongDanhMuc', 'tongSanPham'));
    }

    public function store(LuuDanhMucRequest $request): RedirectResponse
    {
        DanhMuc::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Đã thêm danh mục');
    }

    public function update(LuuDanhMucRequest $request, int $id): RedirectResponse
    {
        DanhMuc::findOrFail($id)->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật danh mục');
    }

    public function destroy(int $id): RedirectResponse
    {
        $danhMuc = DanhMuc::withCount('sanPhams')->findOrFail($id);

        if ($danhMuc->san_phams_count > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa: danh mục còn ' . $danhMuc->san_phams_count . ' sản phẩm');
        }

        $danhMuc->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục');
    }
}
