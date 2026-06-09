<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Services\DonHangService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DonHangController extends Controller
{
    public function __construct(
        private DonHangService $donHangService
    ) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $validStatus = ['cho_xac_nhan', 'dang_chuan_bi', 'dang_giao', 'da_giao', 'da_huy'];

        $donHangs = DonHang::with('chiTiet')
            ->where('tai_khoan_id', Auth::id())
            ->when(in_array($status, $validStatus, true), fn ($q) => $q->where('trang_thai_don_hang', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('don-hang.lich-su', compact('donHangs', 'status'));
    }

    public function show(string $ma): View
    {
        $donHang = DonHang::with('chiTiet.sanPham', 'thanhToan', 'maGiamGia')
            ->where('ma_don_hang', $ma)
            ->where(function ($q) {
                $q->where('tai_khoan_id', Auth::id())
                  ->orWhereNull('tai_khoan_id');
            })
            ->firstOrFail();

        return view('don-hang.chi-tiet', compact('donHang'));
    }

    public function success(string $ma): View
    {
        $donHang = DonHang::with('chiTiet')
            ->where('ma_don_hang', $ma)
            ->firstOrFail();

        return view('don-hang.order-success', compact('donHang'));
    }

    public function huy(string $ma): RedirectResponse
    {
        $donHang = DonHang::where('ma_don_hang', $ma)
            ->where('tai_khoan_id', Auth::id())
            ->firstOrFail();

        $thanhCong = $this->donHangService->huyDonHang($donHang, 'Khách yêu cầu hủy');

        return redirect()->route('orders.show', $ma)->with(
            $thanhCong ? 'success' : 'error',
            $thanhCong ? 'Đã hủy đơn hàng' : 'Không thể hủy đơn ở trạng thái hiện tại'
        );
    }
}
