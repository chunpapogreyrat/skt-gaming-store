<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'YUKI Gaming Store - Đỉnh Cao Trải Nghiệm')</title>

    {{-- CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    {{-- CSS dự án --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>

<body class="dark-theme">

{{-- #region ANNOUNCEMENT BAR --}}
<div class="announcement-bar">
    <div class="announcement-bar__track">
        <span>⚡ MIỄN PHÍ VẬN CHUYỂN đơn hàng từ 500K &nbsp;&bull;&nbsp;</span>
        <span>🎮 FLASH SALE MỖI THỨ 6 — GIẢM ĐẾN 50% &nbsp;&bull;&nbsp;</span>
        <span>🏆 BẢO HÀNH CHÍNH HÃNG 24 THÁNG &nbsp;&bull;&nbsp;</span>
        <span>🔥 SẢN PHẨM MỚI: FINALMOUSE ULX VỪA VỀ KHO &nbsp;&bull;&nbsp;</span>
        <span>⚡ MIỄN PHÍ VẬN CHUYỂN đơn hàng từ 500K &nbsp;&bull;&nbsp;</span>
        <span>🎮 FLASH SALE MỖI THỨ 6 — GIẢM ĐẾN 50% &nbsp;&bull;&nbsp;</span>
        <span>🏆 BẢO HÀNH CHÍNH HÃNG 24 THÁNG &nbsp;&bull;&nbsp;</span>
        <span>🔥 SẢN PHẨM MỚI: FINALMOUSE ULX VỪA VỀ KHO &nbsp;&bull;&nbsp;</span>
    </div>
</div>
{{-- #endregion --}}

{{-- #region NAVBAR --}}
<nav class="navbar" id="mainNav">
    <div class="navbar__container">
        <a href="{{ route('home') }}" class="navbar__logo"><span class="navbar__logo-yuki">YUKI</span> GAMING</a>
        <button class="navbar__toggle" id="navToggle"><i class="fa-solid fa-bars"></i></button>
        <div class="navbar__menu" id="navMenu">
            <ul class="navbar__links">
                <li class="navbar__item navbar__has-drop">
                    <a href="{{ route('home') }}" class="navbar__link {{ request()->routeIs('home') ? 'navbar__link--active' : '' }}">
                        Gaming Gear <i class="fa-solid fa-angle-down navbar__caret"></i>
                    </a>
                    <div class="navbar__dropdown">
                        <a href="{{ route('products.index', ['category' => 'keyboard']) }}" class="navbar__drop-link"><i class="fa-solid fa-keyboard"></i> Bàn Phím Cơ</a>
                        <a href="{{ route('products.index', ['category' => 'mice']) }}" class="navbar__drop-link"><i class="fa-solid fa-computer-mouse"></i> Chuột Gaming</a>
                        <a href="{{ route('products.index', ['category' => 'accessory']) }}" class="navbar__drop-link"><i class="fa-solid fa-headphones"></i> Phụ Kiện</a>
                        <a href="{{ route('products.index', ['category' => 'mousepad']) }}" class="navbar__drop-link"><i class="fa-solid fa-grip"></i> Lót Chuột</a>
                    </div>
                </li>
                <li class="navbar__item navbar__has-drop">
                    <a href="{{ route('static.setups') }}" class="navbar__link {{ request()->routeIs('static.setups') ? 'navbar__link--active' : '' }}">
                        Góc game thủ <i class="fa-solid fa-angle-down navbar__caret"></i>
                    </a>
                    <div class="navbar__dropdown">
                        <a href="{{ route('static.setups') }}" class="navbar__drop-link"><i class="fa-solid fa-display"></i> Setup đỉnh cao</a>
                        <a href="{{ route('static.setups') }}" class="navbar__drop-link"><i class="fa-solid fa-gamepad"></i> Trải nghiệm sản phẩm</a>
                        <a href="{{ route('static.setups') }}" class="navbar__drop-link"><i class="fa-solid fa-broom"></i> Vệ sinh thiết bị</a>
                    </div>
                </li>
                <li><a href="{{ route('static.about') }}" class="navbar__link {{ request()->routeIs('static.about') ? 'navbar__link--active' : '' }}">Giới thiệu về chúng tui</a></li>
                <li><a href="{{ route('static.contact') }}" class="navbar__link {{ request()->routeIs('static.contact') ? 'navbar__link--active' : '' }}">Liên hệ</a></li>
            </ul>
            <div class="navbar__actions">
                <button type="button" class="navbar__icon-btn navbar__icon-btn--btn" id="openSearchBtn" aria-label="Tìm kiếm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button type="button" class="navbar__icon-btn navbar__icon-btn--btn" id="openCartBtn" aria-label="Giỏ hàng">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="navbar__badge" id="cartBadge">{{ session('cart_count', 0) }}</span>
                </button>
                @auth
                    <div class="navbar__item navbar__has-drop">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('profile.show') }}" class="navbar__icon-btn" aria-label="Tài khoản"><i class="fa-regular fa-user"></i></a>
                        <div class="navbar__dropdown">
                            <a href="{{ route('profile.show') }}" class="navbar__drop-link"><i class="fa-solid fa-user"></i> Tài khoản</a>
                            <a href="{{ route('orders.index') }}" class="navbar__drop-link"><i class="fa-solid fa-box"></i> Đơn hàng</a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="navbar__drop-link"><i class="fa-solid fa-gauge-high"></i> Quản trị</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="navbar__drop-link w-100 text-start border-0 bg-transparent">
                                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="navbar__icon-btn" aria-label="Đăng nhập"><i class="fa-regular fa-user"></i></a>
                @endauth
            </div>
        </div>
    </div>
</nav>
{{-- #endregion --}}

{{-- #region MAIN CONTENT --}}
@yield('content')
{{-- #endregion --}}

{{-- #region FOOTER --}}
<footer class="site-footer mt-5">
    <div class="container-fluid px-4 px-xl-5">
        <div class="row g-4 site-footer__top">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="site-footer__logo"><span class="site-footer__logo-yuki">YUKI</span> GAMING STORE</a>
                <p class="site-footer__desc">Vũ khí tối thượng cho game thủ chuyên nghiệp. Engineered for extreme performance.</p>
                <div class="site-footer__socials">
                    <a href="#" class="social-btn social-btn--web"><i class="fa-solid fa-globe"></i></a>
                    <a href="#" class="social-btn social-btn--yt"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="social-btn social-btn--fb"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-btn social-btn--dc"><i class="fa-brands fa-discord"></i></a>
                    <a href="#" class="social-btn social-btn--tk"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" class="social-btn social-btn--ig"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="site-footer__col-title">SẢN PHẨM</h6>
                <ul class="site-footer__links list-unstyled">
                    <li><a href="{{ route('products.index', ['category' => 'keyboard']) }}">Bàn phím cơ</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'mice']) }}">Chuột gaming</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'accessory']) }}">Tai nghe</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'mousepad']) }}">Lót chuột</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="site-footer__col-title">HỖ TRỢ</h6>
                <ul class="site-footer__links list-unstyled">
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Giao hàng hỏa tốc</a></li>
                    <li><a href="{{ route('static.about') }}">Giới thiệu</a></li>
                    <li><a href="{{ route('static.contact') }}">Liên hệ chúng tôi</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="site-footer__col-title">THANH TOÁN</h6>
                <div class="site-footer__payments">
                    <span class="pay-icon pay-icon--visa" title="Visa"><i class="fa-brands fa-cc-visa"></i></span>
                    <span class="pay-icon pay-icon--master" title="Mastercard"><i class="fa-brands fa-cc-mastercard"></i></span>
                    <span class="pay-icon pay-icon--momo" title="MoMo"><i class="fa-solid fa-wallet"></i></span>
                    <span class="pay-icon pay-icon--bank" title="Internet Banking"><i class="fa-solid fa-building-columns"></i></span>
                    <span class="pay-icon pay-icon--paypal" title="PayPal"><i class="fa-brands fa-paypal"></i></span>
                </div>
                <p class="site-footer__copyright">© 2026 YUKI Gaming. Designed with Cyber-precision.</p>
            </div>
        </div>
    </div>
</footer>
{{-- #endregion --}}

{{-- #region SEARCH OVERLAY --}}
<div class="search-overlay" id="searchOverlay" aria-hidden="true">
    <div class="search-overlay__panel">
        <div class="search-overlay__head">
            <i class="fa-solid fa-magnifying-glass search-overlay__icon"></i>
            <input type="text" id="searchInput" class="search-overlay__input" placeholder="Tìm chuột, bàn phím, tai nghe...">
            <button class="search-overlay__close" id="closeSearchBtn" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="search-overlay__divider"></div>
        <div class="search-overlay__body">
            <p class="search-overlay__label">Search menu</p>
            <ul class="search-overlay__menu list-unstyled">
                <li><a href="{{ route('products.index', ['category' => 'mice']) }}"><i class="fa-solid fa-computer-mouse"></i> Chuột Gaming</a></li>
                <li><a href="{{ route('products.index', ['category' => 'keyboard']) }}"><i class="fa-solid fa-keyboard"></i> Bàn Phím</a></li>
                <li><a href="{{ route('products.index', ['category' => 'mousepad']) }}"><i class="fa-solid fa-grip"></i> Lót Chuột</a></li>
                <li><a href="{{ route('products.index', ['category' => 'accessory']) }}"><i class="fa-solid fa-headphones"></i> Tai Nghe</a></li>
                <li><a href="{{ route('products.index', ['tag' => 'sale']) }}"><i class="fa-solid fa-tag"></i> Khuyến Mãi</a></li>
            </ul>
        </div>
    </div>
    <div class="search-overlay__backdrop" id="searchBackdrop"></div>
</div>
{{-- #endregion --}}

{{-- #region CART DRAWER --}}
<div class="cart-drawer" id="cartDrawer" aria-hidden="true">
    <div class="cart-drawer__backdrop" id="cartBackdrop"></div>
    <aside class="cart-drawer__panel">
        <header class="cart-drawer__head">
            <h5 class="cart-drawer__title">
                Giỏ hàng <span class="cart-drawer__count" id="cartCount">{{ $cartDrawerCount ?? 0 }}</span>
            </h5>
            <button class="cart-drawer__close" id="closeCartBtn" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </header>
        <div class="cart-drawer__progress">
            <p class="cart-drawer__progress-text"><i class="fa-solid fa-truck-fast"></i> Bạn được giao hàng miễn phí!</p>
            <div class="cart-drawer__bar"><span class="cart-drawer__bar-fill"></span></div>
        </div>
        <div class="cart-drawer__list" id="cartList">
            @forelse($cartDrawerItems ?? [] as $item)
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
                <span class="cart-drawer__total-value" id="cartTotal">{{ number_format($cartDrawerTotal ?? 0) }}<sup>đ</sup></span>
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
{{-- #endregion --}}

{{-- #region CONFIRM MODAL (dùng chung cho cart drawer + cart page) --}}
<div class="confirm-modal" id="confirmModal">
    <div class="confirm-modal__backdrop" id="confirmBackdrop"></div>
    <div class="confirm-modal__box">
        <div class="confirm-modal__icon"><i class="fa-solid fa-trash-can"></i></div>
        <h6 class="confirm-modal__title">Xóa sản phẩm?</h6>
        <p class="confirm-modal__text" id="confirmText">Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?</p>
        <div class="confirm-modal__actions">
            <button class="confirm-modal__btn confirm-modal__btn--cancel" id="confirmCancel">Hủy bỏ</button>
            <button class="confirm-modal__btn confirm-modal__btn--confirm" id="confirmOk">Xóa luôn</button>
        </div>
    </div>
</div>
{{-- #endregion --}}

{{-- #region CART DRAWER AJAX HANDLERS --}}
<script>
(function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrf) return;

    function cartApi(url, method, body) {
        return fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: body ? JSON.stringify(body) : null,
        }).then(r => r.json());
    }

    function updateBadgeAndTotal(count, total) {
        document.querySelectorAll('#cartBadge, #cartCount').forEach(b => {
            // Clear inline display:none từ initCartDrawer cũ; ẩn nếu count = 0
            b.style.display = count > 0 ? '' : 'none';
            // Animation bounce khi đổi số
            if (b.textContent !== String(count)) {
                b.classList.remove('badge-pop');
                void b.offsetWidth; // reflow để restart animation
                b.classList.add('badge-pop');
            }
            b.textContent = count;
        });
        const totalEl = document.getElementById('cartTotal');
        if (totalEl) totalEl.innerHTML = Number(total).toLocaleString('vi-VN') + '<sup>đ</sup>';
    }

    // Confirm modal with promise — dùng cho cả drawer + cart page
    window.skSktConfirm = function (productName) {
        const modal = document.getElementById('confirmModal');
        const ok = document.getElementById('confirmOk');
        const cancel = document.getElementById('confirmCancel');
        const backdrop = document.getElementById('confirmBackdrop');
        const text = document.getElementById('confirmText');
        if (!modal) return Promise.resolve(confirm('Xóa ' + (productName || 'sản phẩm') + '?'));
        if (productName) text.textContent = 'Xóa "' + productName + '" khỏi giỏ hàng?';
        modal.classList.add('is-open');
        return new Promise(resolve => {
            function close(r) {
                modal.classList.remove('is-open');
                ok.removeEventListener('click', onOk);
                cancel.removeEventListener('click', onCancel);
                backdrop.removeEventListener('click', onCancel);
                resolve(r);
            }
            function onOk() { close(true); }
            function onCancel() { close(false); }
            ok.addEventListener('click', onOk);
            cancel.addEventListener('click', onCancel);
            backdrop.addEventListener('click', onCancel);
        });
    };

    // Drawer: delete with confirm
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('[data-drawer-remove]');
        if (!btn) return;
        const item = btn.closest('.cart-item');
        const id = item?.dataset.itemId;
        if (!id) return;
        const name = item.querySelector('.cart-item__name')?.textContent.trim();
        if (!await window.skSktConfirm(name)) return;

        const res = await cartApi('/gio-hang/' + id, 'DELETE');
        if (res.success) {
            item.remove();
            updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
            if (res.data.cart_count === 0) {
                const list = document.getElementById('cartList');
                if (list && !list.querySelector('#cartDrawerEmpty')) {
                    list.innerHTML = '<div class="text-center text-secondary py-5" id="cartDrawerEmpty"><i class="fa-solid fa-cart-shopping" style="font-size:2.5rem;opacity:.3"></i><p class="mt-3">Giỏ hàng đang trống</p></div>';
                }
            }
        } else {
            alert(res.message || 'Không xóa được sản phẩm');
        }
    });

    // Drawer: qty +/-
    document.addEventListener('click', async function (e) {
        const plus = e.target.closest('[data-drawer-plus]');
        const minus = e.target.closest('[data-drawer-minus]');
        if (!plus && !minus) return;
        const item = (plus || minus).closest('.cart-item');
        const id = item?.dataset.itemId;
        const input = item.querySelector('.qty-input input');
        if (!id || !input) return;
        const newQty = parseInt(input.value) + (plus ? 1 : -1);
        if (newQty < 1) return;

        const res = await cartApi('/gio-hang/' + id, 'PATCH', { so_luong: newQty });
        if (res.success) {
            input.value = newQty;
            updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
        }
    });

    // Build cart-item HTML khớp với server-render (same markup)
    function buildCartItemHTML(item) {
        const sp = item.san_pham || {};
        const img = (sp.hinh_anh && sp.hinh_anh[0]) ? sp.hinh_anh[0].duong_dan : 'assets/images/library/logo.png';
        const price = Number(item.gia_tai_thoi_diem).toLocaleString('vi-VN') + 'đ';
        const variant = item.mau_sac || 'Mặc định';
        return `
            <div class="cart-item" data-item-id="${item.id}">
                <div class="cart-item__img"><img src="/${img}" alt=""></div>
                <div class="cart-item__info">
                    <h6 class="cart-item__name">${sp.ten || 'Sản phẩm'}</h6>
                    <span class="cart-item__price">${price}</span>
                    <p class="cart-item__variant">Phân loại: ${variant}</p>
                </div>
                <div class="cart-item__actions">
                    <div class="qty-input">
                        <button type="button" class="qty-input__btn" data-drawer-minus>−</button>
                        <input type="text" value="${item.so_luong}" readonly>
                        <button type="button" class="qty-input__btn" data-drawer-plus>+</button>
                    </div>
                    <button type="button" class="cart-item__remove" data-drawer-remove aria-label="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>`;
    }

    // Quick add: animation + POST + DOM update (no reload)
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('.p-card__quick[data-product-id]');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        const id = parseInt(btn.dataset.productId);
        if (!id) return;
        e.stopImmediatePropagation(); // chặn initFlyToCart (script.js) thêm giỏ client-side lần 2

        // Animation paper plane
        if (typeof window.skSktFlyPaperPlane === 'function') {
            window.skSktFlyPaperPlane(btn);
        }

        const res = await cartApi('/gio-hang', 'POST', { san_pham_id: id, so_luong: 1 });
        if (!res.success) {
            alert(res.message || 'Không thêm được sản phẩm');
            return;
        }

        // Cập nhật drawer DOM mà không reload
        const list = document.getElementById('cartList');
        const empty = document.getElementById('cartDrawerEmpty');
        if (empty) empty.remove();

        const existing = list?.querySelector(`.cart-item[data-item-id="${res.data.item.id}"]`);
        if (existing) {
            // Update qty
            const input = existing.querySelector('.qty-input input');
            if (input) input.value = res.data.item.so_luong;
        } else {
            // Append new
            list.insertAdjacentHTML('beforeend', buildCartItemHTML(res.data.item));
        }
        updateBadgeAndTotal(res.data.cart_count, res.data.tong.tong_tien);
    }, true);
})();
</script>
{{-- #endregion --}}

{{-- JS CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tsparticles/slim@3/tsparticles.slim.bundle.min.js"></script>

{{-- JS dự án --}}
<script src="{{ asset('assets/js/script.js') }}"></script>

{{-- AOS fix: script.js init với once:false/mirror:true + tính sai khi ảnh chưa load → nội dung trên màn bị ẩn (opacity:0) tới khi cuộn.
     Sau khi load xong, ép hiện mọi phần tử [data-aos] (vẫn giữ animation cho phần dưới khi cuộn). --}}
<script>
(function () {
    function fixAos() {
        // Re-init once:true (script.js để once:false/mirror:true gỡ aos-animate khỏi section cao -> ẩn grid con)
        if (window.AOS) AOS.init({ once: true, duration: 700, offset: 0, mirror: false });
        document.querySelectorAll('[data-aos]').forEach(function (el) {
            el.classList.add('aos-animate');
        });
    }
    // chạy SAU handler load nội bộ của AOS
    window.addEventListener('load', function () { setTimeout(fixAos, 80); });
    setTimeout(fixAos, 1200); // fallback nếu load đã xong
})();
</script>

@stack('scripts')

</body>
</html>
