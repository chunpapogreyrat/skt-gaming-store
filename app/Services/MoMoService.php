<?php

namespace App\Services;

use App\Models\DonHang;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Tích hợp thanh toán Ví MoMo (AIO v2).
 *
 * Mặc định chạy môi trường SANDBOX với bộ key test công khai của MoMo
 * (cấu hình ở config/services.php → momo). Không dùng tiền thật.
 *
 * Luồng:
 *  - taoThanhToan($donHang): ký request → gọi MoMo /create → trả payUrl (trang QR/app MoMo)
 *  - xacThucChuKy($data): xác thực chữ ký trên redirect/IPN MoMo gửi về
 *  - layMaDonHang($momoOrderId): tách mã đơn từ orderId gửi cho MoMo
 */
class MoMoService
{
    private string $partnerCode;
    private string $accessKey;
    private string $secretKey;
    private string $endpoint;

    public function __construct()
    {
        $cfg = config('services.momo');
        $this->partnerCode = $cfg['partner_code'];
        $this->accessKey = $cfg['access_key'];
        $this->secretKey = $cfg['secret_key'];
        $this->endpoint = $cfg['endpoint'];
    }

    /**
     * Tạo giao dịch MoMo, trả về payUrl để redirect khách sang trang thanh toán MoMo.
     * Trả null nếu thất bại (controller sẽ xử lý fallback).
     */
    public function taoThanhToan(DonHang $donHang): ?string
    {
        // orderId gửi MoMo phải DUY NHẤT mỗi lần → gắn thêm hậu tố.
        // Mã đơn dạng "SKT-123456" (không có "_") nên tách lại dễ dàng.
        $orderId = $donHang->ma_don_hang . '_' . Str::lower(Str::random(8));
        $requestId = (string) Str::uuid();
        $amount = (string) (int) round($donHang->tong_tien);
        $orderInfo = 'Thanh toan don hang ' . $donHang->ma_don_hang . ' - YUKI Gaming Store';
        $redirectUrl = route('momo.return');
        $ipnUrl = route('momo.ipn');
        $extraData = '';
        $requestType = 'captureWallet';

        // Chuỗi ký theo đúng thứ tự MoMo quy định (alphabet field)
        $rawSignature = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}"
            . "&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}"
            . "&partnerCode={$this->partnerCode}&redirectUrl={$redirectUrl}"
            . "&requestId={$requestId}&requestType={$requestType}";

        $signature = hash_hmac('sha256', $rawSignature, $this->secretKey);

        $payload = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'YUKI Gaming Store',
            'storeId' => 'YUKIStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'requestType' => $requestType,
            'autoCapture' => true,
            'extraData' => $extraData,
            'signature' => $signature,
        ];

        try {
            // PHP trên Windows thường thiếu CA bundle (curl.cainfo) → trỏ tới cacert.pem
            // kèm trong storage để verify SSL vẫn hoạt động. Nếu không có thì verify mặc định.
            $caBundle = storage_path('cacert.pem');
            $verify = is_file($caBundle) ? $caBundle : true;

            $res = Http::withOptions(['verify' => $verify])->timeout(20)->acceptJson()->post($this->endpoint, $payload);
            $data = $res->json();

            if (($data['resultCode'] ?? -1) == 0 && ! empty($data['payUrl'])) {
                // Lưu orderId MoMo vào bản ghi thanh toán để đối soát khi callback
                $donHang->thanhToan?->update(['ma_giao_dich' => $orderId]);

                return $data['payUrl'];
            }

            Log::warning('MoMo create thất bại', ['donHang' => $donHang->ma_don_hang, 'response' => $data]);
        } catch (\Throwable $e) {
            Log::error('MoMo create lỗi: ' . $e->getMessage(), ['donHang' => $donHang->ma_don_hang]);
        }

        return null;
    }

    /**
     * Xác thực chữ ký trên dữ liệu MoMo gửi về (redirect & IPN dùng chung công thức).
     */
    public function xacThucChuKy(array $d): bool
    {
        if (empty($d['signature'])) {
            return false;
        }

        $raw = "accessKey={$this->accessKey}"
            . "&amount=" . ($d['amount'] ?? '')
            . "&extraData=" . ($d['extraData'] ?? '')
            . "&message=" . ($d['message'] ?? '')
            . "&orderId=" . ($d['orderId'] ?? '')
            . "&orderInfo=" . ($d['orderInfo'] ?? '')
            . "&orderType=" . ($d['orderType'] ?? '')
            . "&partnerCode=" . ($d['partnerCode'] ?? '')
            . "&payType=" . ($d['payType'] ?? '')
            . "&requestId=" . ($d['requestId'] ?? '')
            . "&responseTime=" . ($d['responseTime'] ?? '')
            . "&resultCode=" . ($d['resultCode'] ?? '')
            . "&transId=" . ($d['transId'] ?? '');

        $expected = hash_hmac('sha256', $raw, $this->secretKey);

        return hash_equals($expected, (string) $d['signature']);
    }

    /**
     * Tách mã đơn (ma_don_hang) từ orderId đã gửi cho MoMo ("SKT-123456_abc123" → "SKT-123456").
     */
    public function layMaDonHang(string $momoOrderId): string
    {
        return explode('_', $momoOrderId)[0];
    }
}
