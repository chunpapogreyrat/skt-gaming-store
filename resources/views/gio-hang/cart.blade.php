@extends('layouts.app')

@section('title', 'Giỏ hàng - SKT Gaming Store')

@section('content')
{{-- #region BREADCRUMB --}}
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-bar__active">Giỏ hàng</li>
    </ol>
</nav>
{{-- #endregion --}}

{{-- #region CART PAGE --}}
<main class="cart-page container-fluid px-4 px-xl-5">
    <section class="cart-page__hero" data-aos="fade-up">
        <span class="cart-page__eyebrow"><i class="fa-solid fa-cart-shopping"></i> SKT Checkout Lab</span>
        <h1 class="cart-page__title">Giỏ hàng</h1>
        <p class="cart-page__subtitle" id="cartPageProgressNote">
            @if($tongTien['tam_tinh'] >= 500000)
                Bạn được giao hàng miễn phí!
            @else
                Mua thêm {{ number_format(500000 - $tongTien['tam_tinh']) }}đ để được miễn phí ship
            @endif
        </p>
        <div class="cart-page__progress">
            <span class="cart-page__progress-fill" id="cartPageProgressFill"
                  style="width: {{ min(100, ($tongTien['tam_tinh'] / 500000) * 100) }}%"></span>
        </div>
    </section>

    <section class="cart-page__layout">
        <div class="cart-page__list" data-aos="fade-right">
            <div class="cart-page__head">
                <span>Sản phẩm</span>
                <span>Số lượng</span>
                <span>Tổng</span>
            </div>

            @forelse($gioHang->items as $item)
            <article class="cart-page__item" data-cart-row data-item-id="{{ $item->id }}" data-price="{{ $item->gia_tai_thoi_diem }}">
                <a class="cart-page__media" href="{{ route('products.show', $item->sanPham->slug ?? $item->san_pham_id) }}">
                    <img src="{{ asset('assets/images/products/' . ($item->sanPham->danh_muc->slug ?? 'mice') . '/' . ($item->sanPham->slug ?? '') . '/1.webp') }}"
                         alt="{{ $item->sanPham->ten_san_pham ?? '' }}">
                </a>
                <div class="cart-page__info">
                    <span class="cart-page__brand">{{ $item->sanPham->thuong_hieu ?? '' }}</span>
                    <h2 class="cart-page__name">
                        <a href="{{ route('products.show', $item->sanPham->slug ?? $item->san_pham_id) }}">
                            {{ $item->sanPham->ten_san_pham ?? 'Sản phẩm' }}
                        </a>
                    </h2>
                    @if($item->mau_sac)
                    <p class="cart-page__meta">{{ $item->mau_sac }}</p>
                    @endif
                    <span class="cart-page__price">{{ number_format($item->gia_tai_thoi_diem) }}đ</span>
                </div>
                <div class="cart-page__qty">
                    <button type="button" class="cart-page__remove" data-xoa-item="{{ $item->id }}" aria-label="Xóa sản phẩm">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                    <div class="cart-page__qty-box">
                        <button type="button" class="cart-page__qty-btn" data-cart-minus data-item-id="{{ $item->id }}" aria-label="Giảm số lượng">-</button>
                        <input class="cart-page__qty-input" type="text" value="{{ $item->so_luong }}" readonly data-item-id="{{ $item->id }}">
                        <button type="button" class="cart-page__qty-btn" data-cart-plus data-item-id="{{ $item->id }}" aria-label="Tăng số lượng">+</button>
                    </div>
                </div>
                <div class="cart-page__line-total">{{ number_format($item->thanhTien()) }}đ</div>
            </article>
            @empty
            {{-- Hiển thị giỏ trống --}}
            @endforelse

            <div class="cart-page__empty" id="cartPageEmpty" @if($gioHang->items->count() > 0) style="display:none" @endif>
                <i class="fa-solid fa-box-open"></i>
                <strong>Giỏ hàng đang trống</strong>
                <span>Quay lại cửa hàng và chọn vũ khí mới cho setup của bạn.</span>
            </div>
        </div>

        <aside class="cart-page__summary" data-aos="fade-left">
            <div class="cart-page__summary-glow"></div>
            <h2 class="cart-page__summary-title">Tóm tắt đơn hàng</h2>
            <div class="cart-page__summary-row">
                <span>Tạm tính</span>
                <strong id="cartPageSubtotal">{{ number_format($tongTien['tam_tinh']) }}đ</strong>
            </div>
            <div class="cart-page__summary-row">
                <span>Phí vận chuyển</span>
                <strong id="cartPageShip">
                    @if($tongTien['phi_ship'] == 0)
                        <span class="txt-green">Miễn phí</span>
                    @else
                        {{ number_format($tongTien['phi_ship']) }}đ
                    @endif
                </strong>
            </div>
            <div class="cart-page__summary-row">
                <span>Ưu đãi</span>
                <strong class="txt-red" id="cartPageDiscount">-{{ number_format($tongTien['giam_gia']) }}đ</strong>
            </div>
            <div class="cart-page__total-row">
                <span>Tổng</span>
                <strong id="cartPageTotal">{{ number_format($tongTien['tong_tien']) }} VND</strong>
            </div>
            <p class="cart-page__tax">Đã bao gồm thuế. Phí ship sẽ được tính khi thanh toán nếu đơn không đạt mốc miễn phí.</p>

            <label class="cart-page__label" for="cartNote">Ghi chú đơn hàng</label>
            <textarea id="cartNote" class="cart-page__note" placeholder="Ví dụ: gói kỹ, giao sau 18h, cần tư vấn build..."></textarea>

            <label class="cart-page__label" for="cartCoupon">Mã ưu đãi</label>
            <div class="cart-page__coupon">
                <input id="cartCoupon" type="text" placeholder="SKTSALE">
                <button type="button" id="cartCouponBtn">Áp dụng</button>
            </div>
            <p class="cart-page__coupon-msg" id="cartCouponMsg"></p>

            <a href="{{ route('checkout.index') }}" class="cart-page__checkout">
                <i class="fa-solid fa-lock"></i>
                Thanh toán
            </a>
            <a href="{{ route('home') }}" class="cart-page__continue">
                <i class="fa-solid fa-arrow-left"></i>
                Tiếp tục mua sắm
            </a>
        </aside>
    </section>
</main>
{{-- #endregion --}}

{{-- Confirm modal đã ở trong layouts/app.blade.php (dùng chung mọi trang) --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function ajaxCart(url, method, data, onSuccess) {
        console.log('[cart] ' + method + ' ' + url, data || '');
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: data ? JSON.stringify(data) : null,
        })
        .then(async r => {
            const text = await r.text();
            try { return { ok: r.ok, status: r.status, data: JSON.parse(text) }; }
            catch (e) { return { ok: false, status: r.status, data: { success: false, message: 'Server error ' + r.status, raw: text.substring(0, 200) } }; }
        })
        .then(result => {
            console.log('[cart] response', result);
            if (!result.ok) {
                alert('Lỗi: ' + (result.data.message || result.status));
                return;
            }
            onSuccess(result.data);
        })
        .catch(err => {
            console.error('[cart] network error', err);
            alert('Lỗi mạng: ' + err.message);
        });
    }

    function updateTotals(tong) {
        document.getElementById('cartPageSubtotal').textContent = formatVnd(tong.tam_tinh) + 'đ';
        document.getElementById('cartPageDiscount').textContent = '-' + formatVnd(tong.giam_gia) + 'đ';
        document.getElementById('cartPageTotal').textContent = formatVnd(tong.tong_tien) + ' VND';
        if (tong.phi_ship === 0) {
            document.getElementById('cartPageShip').innerHTML = '<span class="txt-green">Miễn phí</span>';
        } else {
            document.getElementById('cartPageShip').textContent = formatVnd(tong.phi_ship) + 'đ';
        }
    }

    function updateBadge(count) {
        const badges = document.querySelectorAll('#cartBadge, #cartCount');
        badges.forEach(b => b.textContent = count);
    }

    function formatVnd(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // +/- buttons
    document.querySelectorAll('[data-cart-plus]').forEach(btn => {
        btn.addEventListener('click', function () {
            const itemId = this.dataset.itemId;
            const input = document.querySelector('.cart-page__qty-input[data-item-id="' + itemId + '"]');
            const newQty = parseInt(input.value) + 1;
            ajaxCart('/gio-hang/' + itemId, 'PATCH', { so_luong: newQty }, function (res) {
                if (res.success) {
                    input.value = newQty;
                    const row = input.closest('[data-cart-row]');
                    const price = parseInt(row.dataset.price);
                    row.querySelector('.cart-page__line-total').textContent = formatVnd(price * newQty) + 'đ';
                    updateTotals(res.data.tong);
                    updateBadge(res.data.cart_count);
                }
            });
        });
    });

    document.querySelectorAll('[data-cart-minus]').forEach(btn => {
        btn.addEventListener('click', function () {
            const itemId = this.dataset.itemId;
            const input = document.querySelector('.cart-page__qty-input[data-item-id="' + itemId + '"]');
            const newQty = parseInt(input.value) - 1;
            if (newQty < 1) return;
            ajaxCart('/gio-hang/' + itemId, 'PATCH', { so_luong: newQty }, function (res) {
                if (res.success) {
                    input.value = newQty;
                    const row = input.closest('[data-cart-row]');
                    const price = parseInt(row.dataset.price);
                    row.querySelector('.cart-page__line-total').textContent = formatVnd(price * newQty) + 'đ';
                    updateTotals(res.data.tong);
                    updateBadge(res.data.cart_count);
                }
            });
        });
    });

    // Delete — dùng skSktConfirm dùng chung từ layouts.app
    document.querySelectorAll('[data-xoa-item]').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id = this.dataset.xoaItem;
            const row = document.querySelector('[data-item-id="' + id + '"][data-cart-row]');
            const name = row?.querySelector('.cart-page__name')?.textContent.trim();
            const ok = await window.skSktConfirm(name);
            if (!ok) return;
            ajaxCart('/gio-hang/' + id, 'DELETE', null, function (res) {
                if (res.success) {
                    if (row) row.remove();
                    if (res.data?.tong) updateTotals(res.data.tong);
                    if (res.data) updateBadge(res.data.cart_count);
                    if (res.data?.cart_count === 0) {
                        document.getElementById('cartPageEmpty').style.display = '';
                    }
                } else {
                    alert(res.message || 'Không xóa được sản phẩm');
                }
            });
        });
    });

    // Coupon
    document.getElementById('cartCouponBtn').addEventListener('click', function () {
        const code = document.getElementById('cartCoupon').value.trim();
        if (!code) return;
        ajaxCart('/gio-hang/coupon', 'POST', { ma_code: code }, function (res) {
            const msg = document.getElementById('cartCouponMsg');
            msg.textContent = res.message;
            msg.className = 'cart-page__coupon-msg ' + (res.success ? 'txt-green' : 'txt-red');
            if (res.success && res.data) {
                updateTotals(res.data);
            }
        });
    });
});
</script>
@endpush
