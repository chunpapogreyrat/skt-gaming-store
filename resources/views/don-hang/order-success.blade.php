@extends('layouts.app')

@section('title', 'Đặt hàng thành công - YUKI Gaming Store')

@section('content')
{{-- #region ORDER SUCCESS PAGE --}}
<main class="success-page container-fluid px-4 px-xl-5">
    <div class="success-page__inner" data-aos="zoom-in">
        <div class="success-page__check"><i class="fa-solid fa-check"></i></div>
        <span class="success-page__eyebrow">ĐƠN HÀNG #{{ $donHang->ma_don_hang }}</span>
        <h1 class="success-page__title">Đặt hàng thành công!</h1>
        <p class="success-page__desc">
            Cảm ơn bạn đã tin tưởng YUKI. Đơn hàng đang được xử lý và sẽ sớm lên đường đến tay bạn.
            Thông tin chi tiết đã được gửi qua email.
        </p>

        <div class="success-card">
            <div class="success-card__row">
                <span><i class="fa-solid fa-hashtag"></i> Mã đơn hàng</span>
                <strong>#{{ $donHang->ma_don_hang }}</strong>
            </div>
            <div class="success-card__row">
                <span><i class="fa-solid fa-user"></i> Người nhận</span>
                <strong>{{ $donHang->ten_nguoi_nhan }} · {{ $donHang->sdt_nguoi_nhan }}</strong>
            </div>
            <div class="success-card__row">
                <span><i class="fa-solid fa-location-dot"></i> Địa chỉ giao</span>
                <strong>{{ $donHang->dia_chi_giao_hang }}, {{ $donHang->quan_huyen }}, {{ $donHang->tinh_thanh }}</strong>
            </div>
            <div class="success-card__row">
                <span><i class="fa-solid fa-truck-fast"></i> Giao hàng dự kiến</span>
                <strong>2 - 4 ngày làm việc</strong>
            </div>
            <div class="success-card__row">
                <span><i class="fa-solid fa-credit-card"></i> Thanh toán</span>
                <strong>{{ $donHang->tenPhuongThuc() }}</strong>
            </div>
            <div class="success-card__row success-card__row--total">
                <span>Tổng thanh toán</span>
                <strong>{{ number_format($donHang->tong_tien) }}đ</strong>
            </div>
        </div>

        <div class="success-page__steps">
            <div class="success-step is-done"><span><i class="fa-solid fa-check"></i></span>Đã đặt hàng</div>
            <div class="success-step__line"></div>
            <div class="success-step {{ in_array($donHang->trang_thai_don_hang, ['dang_chuan_bi','dang_giao','da_giao']) ? 'is-active' : '' }}">
                <span><i class="fa-solid fa-box"></i></span>Đang đóng gói
            </div>
            <div class="success-step__line"></div>
            <div class="success-step {{ in_array($donHang->trang_thai_don_hang, ['dang_giao','da_giao']) ? 'is-active' : '' }}">
                <span><i class="fa-solid fa-truck"></i></span>Đang giao
            </div>
            <div class="success-step__line"></div>
            <div class="success-step {{ $donHang->trang_thai_don_hang === 'da_giao' ? 'is-active' : '' }}">
                <span><i class="fa-solid fa-house-circle-check"></i></span>Đã nhận
            </div>
        </div>

        <div class="success-page__actions">
            <a href="{{ route('home') }}" class="error-btn error-btn--primary">
                <i class="fa-solid fa-bag-shopping"></i> Tiếp tục mua sắm
            </a>
            @auth
            <a href="{{ route('orders.index') }}" class="error-btn error-btn--ghost">
                <i class="fa-solid fa-box"></i> Theo dõi đơn hàng
            </a>
            @endauth
        </div>
    </div>
</main>
{{-- #endregion --}}

{{-- #region TENZ SUCCESS MODAL --}}
<div class="tenz-modal" id="tenzModal" role="dialog" aria-modal="true">
    <div class="tenz-modal__bg"></div>
    <div class="tenz-modal__inner">
        <div class="tenz-modal__badge">⚡ Order Confirmed · YUKI</div>
        <p class="tenz-modal__slogan">
            Chuột đã trên tay,<br>
            <span>Aim ngang TenZ thôi nào!!</span>
        </p>
        <button class="tenz-modal__close-btn" id="tenzModalClose">
            <i class="fa-solid fa-xmark"></i> ĐÓNG
        </button>
    </div>
</div>
{{-- #endregion --}}
@endsection

@push('scripts')
<script>
(function () {
    var modal = document.getElementById('tenzModal');
    var closeBtn = document.getElementById('tenzModalClose');

    setTimeout(function () {
        modal.style.display = 'flex';
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                modal.classList.add('tenz-modal--visible');
            });
        });
    }, 400);

    // Modal KHÔNG tự đóng — chỉ đóng khi bấm nút X hoặc bấm ra nền (CART-06)
    function closeModal() {
        modal.classList.remove('tenz-modal--visible');
        setTimeout(function () { modal.style.display = 'none'; }, 500);
    }

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });
})();
</script>
@endpush
