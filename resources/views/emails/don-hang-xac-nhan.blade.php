<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng {{ $donHang->ma_don_hang }}</title>
</head>
@php
    $assetBase = rtrim(config('services.mail_asset_url'), '/');
    $imgUrl = fn ($p) => $assetBase . '/' . ltrim($p ?: 'assets/images/library/logo.png', '/');
    $daThanhToan = $donHang->trang_thai_thanh_toan === 'da_thanh_toan';
@endphp
<body style="margin:0;padding:0;background:#0f1115;font-family:Arial,Helvetica,sans-serif;color:#e7e9ee;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0f1115;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#171a21;border:1px solid #262b36;border-radius:14px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#ff003c,#7a0021);padding:28px 32px;">
                            <h1 style="margin:0;font-size:22px;color:#fff;letter-spacing:1px;">YUKI GAMING STORE</h1>
                            <p style="margin:6px 0 0;color:#ffd7df;font-size:13px;">Cảm ơn bạn đã đặt hàng!</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:28px 32px;">
                            <p style="margin:0 0 6px;font-size:16px;">Xin chào <strong>{{ $donHang->ten_nguoi_nhan }}</strong>,</p>
                            <p style="margin:0 0 20px;font-size:14px;color:#aab2c0;line-height:1.6;">
                                Đơn hàng của bạn đã được tiếp nhận. Mã đơn:
                                <strong style="color:#ff486d;">{{ $donHang->ma_don_hang }}</strong>.
                                Trạng thái: <strong>{{ $donHang->tenTrangThai() }}</strong>.
                            </p>

                            {{-- Danh sách sản phẩm --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                @foreach($donHang->chiTiet as $ct)
                                <tr>
                                    <td style="padding:10px 0;border-bottom:1px solid #262b36;" width="56">
                                        <img src="{{ $imgUrl($ct->anh_san_pham) }}" width="48" height="48" alt="" style="border-radius:8px;background:#fff;object-fit:contain;">
                                    </td>
                                    <td style="padding:10px 10px;border-bottom:1px solid #262b36;font-size:13px;color:#e7e9ee;">
                                        {{ $ct->ten_san_pham }}
                                        @if($ct->mau_sac)<br><span style="color:#7c8696;font-size:12px;">{{ $ct->mau_sac }}</span>@endif
                                        <br><span style="color:#7c8696;font-size:12px;">SL: {{ $ct->so_luong }} × {{ number_format($ct->don_gia) }}đ</span>
                                    </td>
                                    <td align="right" style="padding:10px 0;border-bottom:1px solid #262b36;font-size:13px;white-space:nowrap;">
                                        {{ number_format($ct->thanh_tien) }}đ
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            {{-- Tổng tiền --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;font-size:14px;">
                                <tr><td style="padding:4px 0;color:#aab2c0;">Tạm tính</td><td align="right">{{ number_format($donHang->tam_tinh) }}đ</td></tr>
                                <tr><td style="padding:4px 0;color:#aab2c0;">Phí vận chuyển</td><td align="right">{{ $donHang->phi_ship > 0 ? number_format($donHang->phi_ship).'đ' : 'Miễn phí' }}</td></tr>
                                @if($donHang->giam_gia > 0)
                                <tr><td style="padding:4px 0;color:#aab2c0;">Ưu đãi</td><td align="right" style="color:#ff486d;">-{{ number_format($donHang->giam_gia) }}đ</td></tr>
                                @endif
                                <tr><td style="padding:10px 0 0;font-size:16px;"><strong>Tổng cộng</strong></td><td align="right" style="padding:10px 0 0;font-size:18px;color:#ff486d;"><strong>{{ number_format($donHang->tong_tien) }}đ</strong></td></tr>
                            </table>

                            {{-- Thông tin giao hàng --}}
                            <div style="margin-top:22px;padding:16px;background:#11141a;border-radius:10px;border:1px solid #262b36;">
                                @php
                                    $diaChiParts = array_filter([
                                        $donHang->dia_chi_giao_hang,
                                        $donHang->phuong_xa,
                                        $donHang->quan_huyen,
                                        $donHang->tinh_thanh,
                                    ]);
                                @endphp
                                <p style="margin:0 0 8px;font-size:13px;color:#7c8696;text-transform:uppercase;letter-spacing:.5px;">Giao đến</p>
                                <p style="margin:0;font-size:14px;line-height:1.6;">
                                    {{ $donHang->ten_nguoi_nhan }} — {{ $donHang->sdt_nguoi_nhan }}<br>
                                    {{ implode(', ', $diaChiParts) }}<br>
                                    Thanh toán: <strong>{{ $donHang->tenPhuongThuc() }}</strong>
                                    @if($daThanhToan)
                                        <span style="color:#39ff14;font-weight:bold;"> — ✓ Đã thanh toán</span>
                                    @else
                                        <span style="color:#ffb703;"> — Chưa thanh toán</span>
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px;background:#11141a;border-top:1px solid #262b36;">
                            <p style="margin:0;font-size:12px;color:#7c8696;line-height:1.6;">
                                Đây là email tự động từ YUKI Gaming Store. Mọi thắc mắc vui lòng liên hệ
                                <a href="mailto:bigbosss2k5@gmail.com" style="color:#ff486d;text-decoration:none;">bigbosss2k5@gmail.com</a>
                                hoặc Zalo 0909877520.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
