<?php

namespace App\Http\Controllers;

use App\Http\Requests\DatHangRequest;
use App\Models\DonHang;
use App\Services\DonHangService;
use App\Services\GioHangService;
use App\Services\MoMoService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    // Khởi tạo controller, tiêm các service giỏ hàng, đơn hàng và MoMo
    public function __construct(
        private GioHangService $gioHangService,
        private DonHangService $donHangService,
        private MoMoService $moMoService
    ) {}

    // Hiển thị trang thanh toán, chuyển về giỏ nếu giỏ hàng trống
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

    // Xử lý đặt hàng: tạo đơn, nếu chọn MoMo thì chuyển sang cổng thanh toán, ngược lại báo thành công
    public function datHang(DatHangRequest $request): RedirectResponse
    {
        try {
            $donHang = $this->donHangService->taoDonHang($request->validated());
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }

        // Thanh toán Ví MoMo → chuyển sang trang thanh toán MoMo
        if ($donHang->phuong_thuc_thanh_toan === 'momo') {
            $payUrl = $this->moMoService->taoThanhToan($donHang);

            if ($payUrl) {
                return redirect()->away($payUrl);
            }

            // Không tạo được payUrl → đơn vẫn còn (chờ thanh toán), báo khách
            return redirect()
                ->route('orders.success', ['ma' => $donHang->ma_don_hang])
                ->with('error', 'Chưa kết nối được MoMo. Đơn đã được tạo, bạn có thể thử thanh toán lại hoặc liên hệ shop.');
        }

        // COD và các phương thức khác
        return redirect()
            ->route('orders.success', ['ma' => $donHang->ma_don_hang])
            ->with('success', 'Đặt hàng thành công!');
    }

    /**
     * MoMo redirect khách về đây sau khi thanh toán (chạy tốt trên localhost).
     */
    public function momoReturn(Request $request): RedirectResponse
    {
        $data = $request->all();

        if (! $this->moMoService->xacThucChuKy($data)) {
            return redirect()->route('cart.index')
                ->with('error', 'Chữ ký thanh toán MoMo không hợp lệ.');
        }

        $donHang = DonHang::where('ma_don_hang', $this->moMoService->layMaDonHang($data['orderId'] ?? ''))->first();

        if (! $donHang) {
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ((string) ($data['resultCode'] ?? '') === '0') {
            // Idempotent: chỉ cập nhật nếu chưa thanh toán
            if ($donHang->trang_thai_thanh_toan !== 'da_thanh_toan') {
                $this->donHangService->danhDauDaThanhToan($donHang, $data['transId'] ?? null, $data);
            }

            return redirect()->route('orders.success', ['ma' => $donHang->ma_don_hang])
                ->with('success', 'Thanh toán MoMo thành công!');
        }

        $this->donHangService->danhDauThanhToanThatBai($donHang, $data);

        return redirect()->route('orders.success', ['ma' => $donHang->ma_don_hang])
            ->with('error', 'Thanh toán MoMo chưa hoàn tất: ' . ($data['message'] ?? 'đã hủy'));
    }

    /**
     * IPN MoMo gọi server-to-server (cần URL public/ngrok). Phải trả 204 cho MoMo.
     */
    public function momoIpn(Request $request)
    {
        $data = $request->all();

        if ($this->moMoService->xacThucChuKy($data)) {
            $donHang = DonHang::where('ma_don_hang', $this->moMoService->layMaDonHang($data['orderId'] ?? ''))->first();

            if ($donHang) {
                if ((string) ($data['resultCode'] ?? '') === '0') {
                    if ($donHang->trang_thai_thanh_toan !== 'da_thanh_toan') {
                        $this->donHangService->danhDauDaThanhToan($donHang, $data['transId'] ?? null, $data);
                    }
                } else {
                    $this->donHangService->danhDauThanhToanThatBai($donHang, $data);
                }
            }
        }

        // MoMo yêu cầu trả về HTTP 204 No Content
        return response()->noContent();
    }
}
