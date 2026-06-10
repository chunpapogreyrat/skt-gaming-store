<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LuuNhaPhanPhoiRequest;
use App\Models\NhaPhanPhoi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NhaPhanPhoiController extends Controller
{
    public function index(Request $request): View
    {
        $query = NhaPhanPhoi::query()->latest();

        if ($tuKhoa = $request->query('q')) {
            $query->where(function ($q) use ($tuKhoa) {
                $q->where('ten', 'like', "%{$tuKhoa}%")
                    ->orWhere('email', 'like', "%{$tuKhoa}%")
                    ->orWhere('quoc_gia', 'like', "%{$tuKhoa}%");
            });
        }

        if (in_array($request->query('status'), ['active', 'paused', 'ended'], true)) {
            $query->where('trang_thai', $request->query('status'));
        }

        $nhaPhanPhois = $query->paginate(15)->withQueryString();

        $thongKe = [
            'tong' => NhaPhanPhoi::count(),
            'active' => NhaPhanPhoi::where('trang_thai', 'active')->count(),
            'paused' => NhaPhanPhoi::where('trang_thai', 'paused')->count(),
            'tong_sku' => (int) NhaPhanPhoi::sum('so_sku'),
        ];

        return view('admin.nha-phan-phoi.index', compact('nhaPhanPhois', 'thongKe'));
    }

    public function store(LuuNhaPhanPhoiRequest $request): RedirectResponse
    {
        NhaPhanPhoi::create($request->validated());

        return redirect()->route('admin.suppliers.index')->with('success', 'Đã thêm nhà phân phối');
    }

    public function update(LuuNhaPhanPhoiRequest $request, int $id): RedirectResponse
    {
        NhaPhanPhoi::findOrFail($id)->update($request->validated());

        return redirect()->route('admin.suppliers.index')->with('success', 'Đã cập nhật nhà phân phối');
    }

    public function destroy(int $id): RedirectResponse
    {
        $npp = NhaPhanPhoi::findOrFail($id);
        $npp->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Đã xóa nhà phân phối ' . $npp->ten);
    }
}
