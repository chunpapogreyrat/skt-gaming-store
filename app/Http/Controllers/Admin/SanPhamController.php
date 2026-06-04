<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin CRUD sản phẩm.
 * PHỤ THUỘC: App\Models\SanPham, App\Models\DanhMuc (Module 2 — Codex).
 * Khi Codex hoàn tất model + migration san_phams/danh_mucs, controller này chạy được ngay.
 * Field giả định: ten_san_pham, thuong_hieu, slug, gia_ban, gia_nhap,
 *                 so_luong_kho, danh_muc_id, mo_ta_ngan, mo_ta, so_sao.
 */
class SanPhamController extends Controller
{
    public function index(Request $request): View
    {
        $query = SanPham::with('danhMuc')->latest();

        if ($danhMucId = $request->query('danh_muc')) {
            $query->where('danh_muc_id', $danhMucId);
        }

        if ($tuKhoa = $request->query('q')) {
            $query->where('ten_san_pham', 'like', "%{$tuKhoa}%");
        }

        $sanPhams = $query->paginate(15)->withQueryString();
        $danhMucs = DanhMuc::all();

        return view('admin.san-pham.index', compact('sanPhams', 'danhMucs'));
    }

    public function create(): View
    {
        $danhMucs = DanhMuc::all();

        return view('admin.san-pham.form', ['sanPham' => new SanPham(), 'danhMucs' => $danhMucs]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        SanPham::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm');
    }

    public function edit(int $id): View
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMuc::all();

        return view('admin.san-pham.form', compact('sanPham', 'danhMucs'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $sanPham = SanPham::findOrFail($id);
        $data = $this->validateData($request);
        $sanPham->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm');
    }

    public function destroy(int $id): RedirectResponse
    {
        SanPham::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'ten_san_pham' => 'required|string|max:200',
            'thuong_hieu' => 'nullable|string|max:100',
            'slug' => 'nullable|string|max:200',
            'danh_muc_id' => 'required|integer',
            'gia_ban' => 'required|numeric|min:0',
            'gia_nhap' => 'nullable|numeric|min:0',
            'so_luong_kho' => 'required|integer|min:0',
            'so_sao' => 'nullable|numeric|min:0|max:5',
            'mo_ta_ngan' => 'nullable|string|max:500',
            'mo_ta' => 'nullable|string',
        ]);
    }
}
