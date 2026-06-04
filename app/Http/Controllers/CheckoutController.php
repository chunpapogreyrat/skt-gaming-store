<?php

namespace App\Http\Controllers;

use App\Http\Requests\DatHangRequest;
use App\Services\DonHangService;
use App\Services\GioHangService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private GioHangService $gioHangService,
        private DonHangService $donHangService
    ) {}

    public function index(): View|RedirectResponse
    {
        $gioHang = $this->gioHangService->layGioHang();

        if ($gioHang->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống — không thể thanh toán');
        }

        $tongTien = $this->gioHangService->tinhTong();

        return view('don-hang.checkout', compact('gioHang', 'tongTien'));
    }

    public function datHang(DatHangRequest $request): RedirectResponse
    {
        try {
            $donHang = $this->donHangService->taoDonHang($request->validated());

            return redirect()
                ->route('orders.success', ['ma' => $donHang->ma_don_hang])
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }
}
