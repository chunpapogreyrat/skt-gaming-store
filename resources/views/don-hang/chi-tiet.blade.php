@extends('layouts.app')

@section('title', 'Đơn hàng ' . $donHang->ma_don_hang . ' - YUKI Gaming Store')

@section('content')
@php
    $statusMap = [
        'cho_xac_nhan'  => ['Chờ xác nhận', 'order-status--pending', 'fa-clock'],
        'dang_chuan_bi' => ['Đang chuẩn bị', 'order-status--pending', 'fa-box'],
        'dang_giao'     => ['Đang giao', 'order-status--shipping', 'fa-truck'],
        'da_giao'       => ['Đã giao', 'order-status--done', 'fa-check'],
        'da_huy'        => ['Đã hủy', 'order-status--cancel', 'fa-xmark'],
    ];
    [$stLabel, $stClass, $stIcon] = $statusMap[$donHang->trang_thai_don_hang] ?? ['Đang xử lý', 'order-status--pending', 'fa-clock'];
    // Mức tiến trình: 1=đặt, 2=đóng gói, 3=giao, 4=nhận
    $level = ['cho_xac_nhan' => 1, 'dang_chuan_bi' => 2, 'dang_giao' => 3, 'da_giao' => 4][$donHang->trang_thai_don_hang] ?? 1;
    $daHuy = $donHang->trang_thai_don_hang === 'da_huy';
    $ptMap = ['cod' => 'COD - Thanh toán khi nhận hàng', 'bank' => 'Chuyển khoản ngân hàng', 'momo' => 'Ví MoMo', 'vnpay' => 'VNPAY'];
    $ptLabel = $ptMap[$donHang->phuong_thuc_thanh_toan] ?? strtoupper($donHang->phuong_thuc_thanh_toan ?? 'COD');
    $coTheHuy = in_array($donHang->trang_thai_don_hang, ['cho_xac_nhan', 'dang_chuan_bi'], true);
@endphp

<main class="order-detail container-fluid px-4 px-xl-5">
    @if (session('success'))
        <div class="alert alert-success my-3 py-2 small"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger my-3 py-2 small"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>
    @endif

    <header class="order-detail__head" data-aos="fade-up">
        <div>
            <h1 class="order-detail__code">Đơn hàng {{ $donHang->ma_don_hang }}</h1>
            <p class="order-detail__date"><i class="fa-regular fa-calendar"></i> Đặt ngày {{ optional($donHang->created_at)->format('d/m/Y H:i') }}</p>
        </div>
        <span class="order-status {{ $stClass }}"><i class="fa-solid {{ $stIcon }}"></i> {{ $stLabel }}</span>
    </header>

    @unless ($daHuy)
    <div class="success-page__steps" data-aos="fade-up" style="margin-bottom:32px">
        <div class="success-step {{ $level >= 1 ? 'is-done' : '' }}"><span><i class="fa-solid fa-check"></i></span>Đã đặt hàng</div>
        <div class="success-step__line"></div>
        <div class="success-step {{ $level > 2 ? 'is-done' : ($level == 2 ? 'is-active' : '') }}"><span><i class="fa-solid fa-box"></i></span>Đang đóng gói</div>
        <div class="success-step__line"></div>
        <div class="success-step {{ $level > 3 ? 'is-done' : ($level == 3 ? 'is-active' : '') }}"><span><i class="fa-solid fa-truck"></i></span>Đang giao</div>
        <div class="success-step__line"></div>
        <div class="success-step {{ $level >= 4 ? 'is-done' : '' }}"><span><i class="fa-solid fa-house-circle-check"></i></span>Đã nhận</div>
    </div>
    @endunless

    <div class="order-detail__grid">
        {{-- LEFT: items + shipping --}}
        <div data-aos="fade-right">
            <section class="order-detail__panel">
                <h3 class="order-detail__panel-title"><i class="fa-solid fa-box-open"></i> Sản phẩm trong đơn</h3>
                @foreach ($donHang->chiTiet as $item)
                    <div class="order-detail__item">
                        <img class="order-detail__item-img" src="{{ asset($item->anh_san_pham ?: 'assets/images/library/logo.png') }}" alt="{{ $item->ten_san_pham }}">
                        <div class="order-detail__item-info">
                            <div class="order-detail__item-name">{{ $item->ten_san_pham }}</div>
                            @if ($item->mau_sac)<div class="order-detail__item-meta">{{ $item->mau_sac }}</div>@endif
                        </div>
                        <div class="order-detail__item-qty">{{ number_format($item->don_gia) }}đ × {{ $item->so_luong }}</div>
                        <div class="order-detail__item-total">{{ number_format($item->thanh_tien) }}đ</div>
                    </div>
                @endforeach
            </section>

            <section class="order-detail__panel">
                <h3 class="order-detail__panel-title"><i class="fa-solid fa-truck-fast"></i> Thông tin giao hàng</h3>
                <div class="order-detail__info-row">
                    <i class="fa-regular fa-user"></i>
                    <span class="order-detail__info-label">Người nhận</span>
                    <span class="order-detail__info-value">{{ $donHang->ten_nguoi_nhan }}</span>
                </div>
                <div class="order-detail__info-row">
                    <i class="fa-solid fa-phone"></i>
                    <span class="order-detail__info-label">Số điện thoại</span>
                    <span class="order-detail__info-value">{{ $donHang->sdt_nguoi_nhan }}</span>
                </div>
                <div class="order-detail__info-row">
                    <i class="fa-solid fa-location-dot"></i>
                    <span class="order-detail__info-label">Địa chỉ</span>
                    <span class="order-detail__info-value">{{ collect([$donHang->dia_chi_giao_hang, $donHang->phuong_xa, $donHang->quan_huyen, $donHang->tinh_thanh])->filter()->implode(', ') }}</span>
                </div>
                @if ($donHang->ghi_chu)
                <div class="order-detail__info-row">
                    <i class="fa-solid fa-note-sticky"></i>
                    <span class="order-detail__info-label">Ghi chú</span>
                    <span class="order-detail__info-value">{{ $donHang->ghi_chu }}</span>
                </div>
                @endif
            </section>
        </div>

        {{-- RIGHT: summary --}}
        <aside data-aos="fade-left">
            <section class="order-detail__panel">
                <h3 class="order-detail__panel-title"><i class="fa-solid fa-receipt"></i> Tóm tắt thanh toán</h3>
                <div class="order-detail__sum-row"><span>Tạm tính</span><strong>{{ number_format($donHang->tam_tinh) }}đ</strong></div>
                <div class="order-detail__sum-row"><span>Phí vận chuyển</span>
                    <strong class="{{ $donHang->phi_ship > 0 ? '' : 'txt-green' }}">{{ $donHang->phi_ship > 0 ? number_format($donHang->phi_ship) . 'đ' : 'Miễn phí' }}</strong>
                </div>
                @if ($donHang->giam_gia > 0)
                <div class="order-detail__sum-row"><span>Giảm giá</span><strong class="txt-red">-{{ number_format($donHang->giam_gia) }}đ</strong></div>
                @endif
                <div class="order-detail__sum-total">
                    <span>Tổng cộng</span>
                    <strong>{{ number_format($donHang->tong_tien) }}đ</strong>
                </div>
            </section>

            <section class="order-detail__panel">
                <h3 class="order-detail__panel-title"><i class="fa-solid fa-credit-card"></i> Phương thức</h3>
                <div class="order-detail__info-row">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span class="order-detail__info-value">{{ $ptLabel }}</span>
                </div>

                @if ($coTheHuy)
                <form action="{{ route('orders.cancel', $donHang->ma_don_hang) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                    @csrf
                    <button type="submit" class="order-detail__cancel-btn">
                        <i class="fa-solid fa-xmark"></i> Hủy đơn hàng
                    </button>
                </form>
                @endif
            </section>

            <a href="{{ route('orders.index') }}" class="btn-outline w-100 mt-2 text-center"><span>← Về danh sách đơn</span></a>
        </aside>
    </div>
</main>
@endsection
