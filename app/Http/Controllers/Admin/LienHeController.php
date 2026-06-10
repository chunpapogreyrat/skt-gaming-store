<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LienHe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LienHeController extends Controller
{
    public function index(Request $request): View
    {
        $query = LienHe::query()->latest();

        if ($tuKhoa = $request->query('q')) {
            $query->where(function ($q) use ($tuKhoa) {
                $q->where('ho_ten', 'like', "%{$tuKhoa}%")
                    ->orWhere('email', 'like', "%{$tuKhoa}%")
                    ->orWhere('noi_dung', 'like', "%{$tuKhoa}%");
            });
        }

        $trangThai = $request->query('status');
        if ($trangThai === 'chua') {
            $query->where('da_xu_ly', false);
        } elseif ($trangThai === 'roi') {
            $query->where('da_xu_ly', true);
        }

        $lienHes = $query->paginate(15)->withQueryString();

        $thongKe = [
            'tong' => LienHe::count(),
            'chua_xu_ly' => LienHe::where('da_xu_ly', false)->count(),
        ];

        return view('admin.lien-he.index', compact('lienHes', 'thongKe'));
    }

    public function toggle(int $id): RedirectResponse
    {
        $lienHe = LienHe::findOrFail($id);
        $lienHe->update(['da_xu_ly' => ! $lienHe->da_xu_ly]);

        return back()->with('success', $lienHe->da_xu_ly
            ? 'Đã đánh dấu liên hệ của ' . $lienHe->ho_ten . ' là ĐÃ xử lý'
            : 'Đã chuyển liên hệ của ' . $lienHe->ho_ten . ' về CHƯA xử lý');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lienHe = LienHe::findOrFail($id);
        $lienHe->delete();

        return back()->with('success', 'Đã xóa liên hệ của ' . $lienHe->ho_ten);
    }
}
