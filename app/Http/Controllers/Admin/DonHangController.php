<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Services\DonHangService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonHangController extends Controller
{
    // Khởi tạo controller và tiêm service xử lý nghiệp vụ đơn hàng
    public function __construct(
        private DonHangService $donHangService
    ) {}

    // Hiển thị danh sách đơn hàng, hỗ trợ lọc theo trạng thái đơn hàng
    public function index(Request $request): View
    {
        $query = DonHang::with('taiKhoan')->latest();

        if ($trangThai = $request->query('trang_thai')) {
            $query->where('trang_thai_don_hang', $trangThai);
        }

        $donHangs = $query->paginate(15)->withQueryString();

        return view('admin.don-hang.index', compact('donHangs'));
    }

    // Hiển thị chi tiết một đơn hàng kèm sản phẩm, thanh toán, tài khoản, mã giảm giá
    public function show(int $id): View
    {
        $donHang = DonHang::with('chiTiet', 'thanhToan', 'taiKhoan', 'maGiamGia')->findOrFail($id);

        return view('admin.don-hang.show', compact('donHang'));
    }

    // Kiểm tra hợp lệ và cập nhật trạng thái đơn hàng qua service
    public function capNhatTrangThai(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'trang_thai_don_hang' => 'required|in:cho_xac_nhan,dang_chuan_bi,dang_giao,da_giao,da_huy',
        ]);

        $donHang = DonHang::findOrFail($id);
        $this->donHangService->capNhatTrangThai($donHang, $request->trang_thai_don_hang);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
    }
}
