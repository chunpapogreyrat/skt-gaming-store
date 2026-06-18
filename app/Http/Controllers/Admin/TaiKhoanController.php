<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaiKhoan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaiKhoanController extends Controller
{
    // Hiển thị danh sách tài khoản, hỗ trợ lọc theo vai trò (role)
    public function index(Request $request): View
    {
        $query = TaiKhoan::query()->latest('ngay_tao');

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        $taiKhoans = $query->paginate(15)->withQueryString();

        return view('admin.tai-khoan.index', compact('taiKhoans'));
    }

    // Bật/tắt trạng thái kích hoạt của tài khoản theo id
    public function doiTrangThai(int $id): RedirectResponse
    {
        $taiKhoan = TaiKhoan::findOrFail($id);
        $taiKhoan->update(['is_active' => !$taiKhoan->is_active]);

        return redirect()->back()->with('success', 'Đã đổi trạng thái tài khoản');
    }
}
