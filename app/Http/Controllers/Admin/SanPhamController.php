<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Admin CRUD sản phẩm — khớp schema thực của Codex (Module 2):
 * SanPham: ten, slug, danh_muc_id, thuong_hieu_id, gia_ban, gia_goc,
 *          so_luong_ton, diem_danh_gia, is_hot, is_sale, is_active,
 *          mo_ta_ngan, mo_ta_day_du.
 */
class SanPhamController extends Controller
{
    public function index(Request $request): View
    {
        $query = SanPham::with(['danhMuc', 'thuongHieu'])->orderByDesc('ngay_tao');

        if ($danhMucId = $request->query('danh_muc')) {
            $query->where('danh_muc_id', $danhMucId);
        }

        if ($tuKhoa = $request->query('q')) {
            $query->where('ten', 'like', "%{$tuKhoa}%");
        }

        $sanPhams = $query->paginate(15)->withQueryString();
        $danhMucs = DanhMuc::orderBy('thu_tu')->get();

        return view('admin.san-pham.index', compact('sanPhams', 'danhMucs'));
    }

    public function create(): View
    {
        return view('admin.san-pham.form', [
            'sanPham' => new SanPham(),
            'danhMucs' => DanhMuc::orderBy('thu_tu')->get(),
            'thuongHieus' => ThuongHieu::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $sanPham = SanPham::create($data);
        $this->luuHinhAnh($sanPham, $request);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm');
    }

    public function edit(int $id): View
    {
        return view('admin.san-pham.form', [
            'sanPham' => SanPham::findOrFail($id),
            'danhMucs' => DanhMuc::orderBy('thu_tu')->get(),
            'thuongHieus' => ThuongHieu::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $sanPham = SanPham::findOrFail($id);
        $data = $this->validateData($request);
        $sanPham->update($data);
        $this->luuHinhAnh($sanPham, $request);

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm');
    }

    public function destroy(int $id): RedirectResponse
    {
        SanPham::findOrFail($id)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'ten' => 'required|string|max:200',
            'slug' => 'nullable|string|max:220',
            'danh_muc_id' => 'required|exists:danh_mucs,id',
            'thuong_hieu_id' => 'nullable|exists:thuong_hieu,id',
            'gia_ban' => 'required|numeric|min:0',
            'gia_goc' => 'nullable|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'mo_ta_ngan' => 'nullable|string|max:500',
            'mo_ta_day_du' => 'nullable|string',
            'is_hot' => 'sometimes|boolean',
            'is_sale' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        // Auto slug nếu trống
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['ten']);
        }

        $data['is_hot'] = $request->boolean('is_hot');
        $data['is_sale'] = $request->boolean('is_sale');
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }

    /**
     * Lưu ảnh sản phẩm: xóa ảnh được chọn + upload ảnh mới vào public/uploads/products.
     */
    private function luuHinhAnh(SanPham $sanPham, Request $request): void
    {
        $request->validate([
            'hinh_anh' => 'nullable|array',
            'hinh_anh.*' => 'image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'xoa_anh' => 'nullable|array',
        ], [
            'hinh_anh.*.image' => 'File tải lên phải là ảnh.',
            'hinh_anh.*.max' => 'Mỗi ảnh tối đa 4MB.',
        ]);

        // 1) Xóa ảnh được tick (chỉ xóa file vật lý nếu là ảnh upload)
        if ($request->filled('xoa_anh')) {
            $sanPham->hinhAnh()->whereIn('id', (array) $request->input('xoa_anh'))->get()
                ->each(function ($img) {
                    if (str_starts_with($img->duong_dan, 'uploads/')) {
                        $abs = public_path($img->duong_dan);
                        if (is_file($abs)) { @unlink($abs); }
                    }
                    $img->delete();
                });
        }

        // 2) Upload ảnh mới
        if ($request->hasFile('hinh_anh')) {
            $dir = public_path('uploads/products');
            if (! is_dir($dir)) { @mkdir($dir, 0755, true); }

            $thuTu = (int) $sanPham->hinhAnh()->max('thu_tu');
            $coAnhChinh = $sanPham->hinhAnh()->where('is_main', true)->exists();

            foreach ($request->file('hinh_anh') as $file) {
                $ten = uniqid('sp' . $sanPham->id . '_') . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $ten);

                $sanPham->hinhAnh()->create([
                    'duong_dan' => 'uploads/products/' . $ten,
                    'thu_tu' => ++$thuTu,
                    'is_main' => $coAnhChinh ? false : true,
                ]);
                $coAnhChinh = true;
            }
        }
    }
}
