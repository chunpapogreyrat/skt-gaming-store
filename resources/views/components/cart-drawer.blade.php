@props(['items' => [], 'total' => 0, 'count' => 0])
{{-- Ngăn kéo giỏ hàng (dữ liệu từ View Composer của layouts.app) --}}
<div class="cart-drawer" id="cartDrawer" aria-hidden="true">
    <div class="cart-drawer__backdrop" id="cartBackdrop"></div>
    <aside class="cart-drawer__panel">
        <header class="cart-drawer__head">
            <h5 class="cart-drawer__title">
                Giỏ hàng <span class="cart-drawer__count" id="cartCount">{{ $count }}</span>
            </h5>
            <button class="cart-drawer__close" id="closeCartBtn" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </header>
        <div class="cart-drawer__progress">
            <p class="cart-drawer__progress-text"><i class="fa-solid fa-truck-fast"></i> Bạn được giao hàng miễn phí!</p>
            <div class="cart-drawer__bar"><span class="cart-drawer__bar-fill"></span></div>
        </div>
        <div class="cart-drawer__list" id="cartList">
            @forelse($items as $item)
            <div class="cart-item" data-item-id="{{ $item->id }}">
                <div class="cart-item__img">
                    @php $img = optional($item->sanPham->hinhAnh->first())->duong_dan ?? 'assets/images/library/logo.png'; @endphp
                    <img src="{{ asset($img) }}" alt="{{ $item->sanPham->ten ?? '' }}">
                </div>
                <div class="cart-item__info">
                    <h6 class="cart-item__name">{{ $item->sanPham->ten ?? 'Sản phẩm' }}</h6>
                    <span class="cart-item__price">{{ number_format($item->gia_tai_thoi_diem) }}đ</span>
                    <p class="cart-item__variant">Phân loại: {{ $item->mau_sac ?? 'Mặc định' }}</p>
                </div>
                <div class="cart-item__actions">
                    <div class="qty-input">
                        <button type="button" class="qty-input__btn" data-drawer-minus>−</button>
                        <input type="text" value="{{ $item->so_luong }}" readonly>
                        <button type="button" class="qty-input__btn" data-drawer-plus>+</button>
                    </div>
                    <button type="button" class="cart-item__remove" data-drawer-remove aria-label="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
            @empty
            <div class="text-center text-secondary py-5" id="cartDrawerEmpty">
                <i class="fa-solid fa-cart-shopping" style="font-size:2.5rem;opacity:.3"></i>
                <p class="mt-3">Giỏ hàng đang trống</p>
            </div>
            @endforelse
        </div>
        <footer class="cart-drawer__foot">
            <div class="cart-drawer__total">
                <span class="cart-drawer__total-label">Tổng</span>
                <span class="cart-drawer__total-value" id="cartTotal">{{ number_format($total) }}<sup>đ</sup></span>
            </div>
            <p class="cart-drawer__tax">Đã bao gồm thuế. <a href="#">Phí ship</a> sẽ được tính khi thanh toán</p>
            <a href="#" class="cart-drawer__note-link"><i class="fa-solid fa-pen"></i> Thêm ghi chú</a>
            <div class="cart-drawer__actions">
                <a href="{{ route('cart.index') }}" class="cart-drawer__btn cart-drawer__btn--outline">Xem giỏ hàng</a>
                <a href="{{ route('checkout.index') }}" class="cart-drawer__btn cart-drawer__btn--primary"><i class="fa-solid fa-lock"></i> Thanh toán</a>
            </div>
        </footer>
    </aside>
</div>
