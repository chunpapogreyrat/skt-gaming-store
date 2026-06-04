@extends('layouts.app')

@section('title', 'Thanh toán - SKT Gaming Store')

@section('content')
{{-- #region BREADCRUMB --}}
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
        <li class="breadcrumb-bar__active">Thanh toán</li>
    </ol>
</nav>
{{-- #endregion --}}

{{-- #region CHECKOUT PAGE --}}
<main class="co-page container-fluid px-4 px-xl-5">
    <header class="co-page__head" data-aos="fade-up">
        <span class="co-page__eyebrow"><i class="fa-solid fa-lock"></i> SKT Secure Checkout</span>
        <h1 class="co-page__title">Thanh toán</h1>
        <p class="co-page__subtitle">Hoàn tất đơn hàng của bạn — bảo mật SSL · Đổi trả 7 ngày</p>
    </header>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">

            {{-- LEFT: forms --}}
            <div class="col-lg-7" data-aos="fade-right">

                {{-- Thông tin giao hàng --}}
                <section class="co-panel mb-4">
                    <h3 class="co-panel__title"><i class="fa-solid fa-truck-fast"></i> Thông Tin Giao Hàng</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="co-label">Họ và tên</label>
                            <div class="co-field"><i class="fa-regular fa-user"></i>
                                <input type="text" name="ten_nguoi_nhan"
                                       value="{{ old('ten_nguoi_nhan', auth()->user()->ho_ten ?? '') }}"
                                       placeholder="Nguyễn Văn A" required>
                            </div>
                            @error('ten_nguoi_nhan')<p class="txt-red small">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="co-label">Số điện thoại</label>
                            <div class="co-field"><i class="fa-solid fa-phone"></i>
                                <input type="tel" name="sdt_nguoi_nhan"
                                       value="{{ old('sdt_nguoi_nhan', auth()->user()->so_dien_thoai ?? '') }}"
                                       placeholder="0901 234 567" required>
                            </div>
                            @error('sdt_nguoi_nhan')<p class="txt-red small">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-12">
                            <label class="co-label">Email</label>
                            <div class="co-field"><i class="fa-regular fa-envelope"></i>
                                <input type="email" name="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       placeholder="email@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="co-label">Tỉnh / Thành phố</label>
                            <div class="co-field"><i class="fa-solid fa-city"></i>
                                <select name="tinh_thanh" required>
                                    <option value="">-- Chọn --</option>
                                    @foreach(['TP. Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng'] as $tinh)
                                        <option value="{{ $tinh }}" @selected(old('tinh_thanh') === $tinh)>{{ $tinh }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tinh_thanh')<p class="txt-red small">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="co-label">Quận / Huyện</label>
                            <div class="co-field"><i class="fa-solid fa-map-pin"></i>
                                <select name="quan_huyen" required>
                                    <option value="">-- Chọn --</option>
                                    @foreach(['Quận 1', 'Quận 3', 'Quận 7', 'Thủ Đức', 'Bình Thạnh', 'Tân Bình'] as $quan)
                                        <option value="{{ $quan }}" @selected(old('quan_huyen') === $quan)>{{ $quan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('quan_huyen')<p class="txt-red small">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-12">
                            <label class="co-label">Địa chỉ cụ thể</label>
                            <div class="co-field"><i class="fa-solid fa-location-dot"></i>
                                <input type="text" name="dia_chi_giao_hang"
                                       value="{{ old('dia_chi_giao_hang') }}"
                                       placeholder="Số nhà, tên đường, phường..." required>
                            </div>
                            @error('dia_chi_giao_hang')<p class="txt-red small">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-12">
                            <label class="co-label">Ghi chú đơn hàng (tuỳ chọn)</label>
                            <textarea class="co-textarea" name="ghi_chu" rows="3"
                                placeholder="Ví dụ: giao giờ hành chính, gọi trước khi giao...">{{ old('ghi_chu') }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- Vận chuyển --}}
                <section class="co-panel mb-4">
                    <h3 class="co-panel__title"><i class="fa-solid fa-box"></i> Phương Thức Vận Chuyển</h3>
                    <div class="co-options">
                        <label class="co-option is-selected">
                            <input type="radio" name="phi_ship" value="{{ $tongTien['phi_ship'] }}" checked>
                            <span class="co-option__radio"></span>
                            <span class="co-option__icon"><i class="fa-solid fa-truck"></i></span>
                            <span class="co-option__info">
                                <strong>Giao hàng tiêu chuẩn</strong>
                                <small>2 - 4 ngày · {{ $tongTien['phi_ship'] == 0 ? 'Miễn phí' : 'Phí ' . number_format($tongTien['phi_ship']) . 'đ' }}</small>
                            </span>
                            <span class="co-option__price">{{ $tongTien['phi_ship'] == 0 ? 'Miễn phí' : number_format($tongTien['phi_ship']) . 'đ' }}</span>
                        </label>
                        <label class="co-option">
                            <input type="radio" name="phi_ship" value="40000">
                            <span class="co-option__radio"></span>
                            <span class="co-option__icon"><i class="fa-solid fa-bolt"></i></span>
                            <span class="co-option__info">
                                <strong>Giao hàng hỏa tốc</strong>
                                <small>Trong 2 giờ · Nội thành</small>
                            </span>
                            <span class="co-option__price">+40.000đ</span>
                        </label>
                    </div>
                </section>

                {{-- Thanh toán --}}
                <section class="co-panel">
                    <h3 class="co-panel__title"><i class="fa-solid fa-credit-card"></i> Phương Thức Thanh Toán</h3>
                    <div class="co-options">
                        <label class="co-option is-selected">
                            <input type="radio" name="phuong_thuc_thanh_toan" value="cod" checked>
                            <span class="co-option__radio"></span>
                            <span class="co-option__icon co-option__icon--green"><i class="fa-solid fa-money-bill-wave"></i></span>
                            <span class="co-option__info">
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                                <small>Trả tiền mặt khi nhận sản phẩm</small>
                            </span>
                        </label>
                        <label class="co-option">
                            <input type="radio" name="phuong_thuc_thanh_toan" value="momo">
                            <span class="co-option__radio"></span>
                            <span class="co-option__icon co-option__icon--momo"><i class="fa-solid fa-wallet"></i></span>
                            <span class="co-option__info">
                                <strong>Ví MoMo</strong>
                                <small>Quét mã QR thanh toán nhanh</small>
                            </span>
                        </label>
                        <label class="co-option">
                            <input type="radio" name="phuong_thuc_thanh_toan" value="vnpay">
                            <span class="co-option__radio"></span>
                            <span class="co-option__icon co-option__icon--cyan"><i class="fa-solid fa-building-columns"></i></span>
                            <span class="co-option__info">
                                <strong>VNPay (Chuyển khoản / Thẻ)</strong>
                                <small>Internet Banking · Visa · Mastercard</small>
                            </span>
                        </label>
                    </div>
                </section>
            </div>

            {{-- RIGHT: order summary --}}
            <div class="col-lg-5" data-aos="fade-left">
                <aside class="co-summary">
                    <div class="co-summary__glow"></div>
                    <h3 class="co-summary__title">Đơn Hàng Của Bạn</h3>

                    <div class="co-summary__items">
                        @foreach($gioHang->items as $item)
                        <div class="co-sum-item" data-price="{{ $item->gia_tai_thoi_diem }}">
                            <div class="co-sum-item__img">
                                <img src="{{ asset('assets/images/products/' . ($item->sanPham->danh_muc->slug ?? 'mice') . '/' . ($item->sanPham->slug ?? '') . '/1.webp') }}"
                                     alt="{{ $item->sanPham->ten_san_pham ?? '' }}">
                                <span class="co-sum-item__qty">{{ $item->so_luong }}</span>
                            </div>
                            <div class="co-sum-item__info">
                                <p class="co-sum-item__name">{{ $item->sanPham->ten_san_pham ?? 'Sản phẩm' }}</p>
                                @if($item->mau_sac)
                                <span class="co-sum-item__meta">{{ $item->mau_sac }}</span>
                                @endif
                            </div>
                            <span class="co-sum-item__price">{{ number_format($item->gia_tai_thoi_diem * $item->so_luong) }}đ</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="co-summary__row"><span>Tạm tính</span><strong>{{ number_format($tongTien['tam_tinh']) }}đ</strong></div>
                    <div class="co-summary__row"><span>Phí vận chuyển</span>
                        <strong>
                            @if($tongTien['phi_ship'] == 0)
                                <span class="txt-green">Miễn phí</span>
                            @else
                                {{ number_format($tongTien['phi_ship']) }}đ
                            @endif
                        </strong>
                    </div>
                    @if($tongTien['giam_gia'] > 0)
                    <div class="co-summary__row"><span>Ưu đãi</span><strong class="txt-red">-{{ number_format($tongTien['giam_gia']) }}đ</strong></div>
                    @endif
                    <div class="co-summary__total"><span>Tổng cộng</span><strong>{{ number_format($tongTien['tong_tien']) }}đ</strong></div>

                    <button type="submit" class="co-place-btn">
                        <i class="fa-solid fa-lock"></i> ĐẶT HÀNG NGAY
                    </button>
                    <a href="{{ route('cart.index') }}" class="co-back-link"><i class="fa-solid fa-arrow-left"></i> Quay lại giỏ hàng</a>

                    <div class="co-trust">
                        <span><i class="fa-solid fa-shield-halved"></i> Bảo mật SSL</span>
                        <span><i class="fa-solid fa-rotate-left"></i> Đổi trả 7 ngày</span>
                        <span><i class="fa-solid fa-medal"></i> Chính hãng 100%</span>
                    </div>
                </aside>
            </div>
        </div>
    </form>
</main>
{{-- #endregion --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Highlight option được chọn
    document.querySelectorAll('.co-options').forEach(group => {
        group.addEventListener('change', function (e) {
            if (e.target.type !== 'radio') return;
            group.querySelectorAll('.co-option').forEach(o => o.classList.remove('is-selected'));
            e.target.closest('.co-option').classList.add('is-selected');
        });
    });
});
</script>
@endpush
