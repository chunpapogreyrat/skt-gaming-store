<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SKT Gaming Store - Đỉnh Cao Trải Nghiệm')</title>

    {{-- CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        <a href="{{ route('home') }}" class="navbar__logo"><span class="navbar__logo-skt">SKT</span> GAMING</a>
        <button class="navbar__toggle" id="navToggle"><i class="fa-solid fa-bars"></i></button>
        <div class="navbar__menu" id="navMenu">
            <ul class="navbar__links">
                <li class="navbar__item navbar__has-drop">
                    <a href="{{ route('products.index') }}" class="navbar__link {{ request()->routeIs('products.*') ? 'navbar__link--active' : '' }}">
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
                <a href="{{ route('home') }}" class="site-footer__logo"><span class="site-footer__logo-skt">SKT</span> GAMING STORE</a>
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
                <p class="site-footer__copyright">© 2026 SKT Gaming. Designed with Cyber-precision.</p>
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
                Giỏ hàng <span class="cart-drawer__count" id="cartCount">{{ session('cart_count', 0) }}</span>
            </h5>
            <button class="cart-drawer__close" id="closeCartBtn" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </header>
        <div class="cart-drawer__progress">
            <p class="cart-drawer__progress-text"><i class="fa-solid fa-truck-fast"></i> Bạn được giao hàng miễn phí!</p>
            <div class="cart-drawer__bar"><span class="cart-drawer__bar-fill"></span></div>
        </div>
        <div class="cart-drawer__list" id="cartList">
            {{-- Được render bằng JS / AJAX --}}
        </div>
        <footer class="cart-drawer__foot">
            <div class="cart-drawer__total">
                Tổng cộng <span id="cartTotal">0đ</span>
            </div>
            <a href="{{ route('cart.index') }}" class="btn-main w-100 text-center"><span>Xem giỏ hàng</span></a>
            <a href="{{ route('checkout.index') }}" class="btn-outline w-100 text-center mt-2"><span>Thanh toán ngay</span></a>
        </footer>
    </aside>
</div>
{{-- #endregion --}}

{{-- JS CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

{{-- JS dự án --}}
<script src="{{ asset('assets/js/script.js') }}"></script>

@stack('scripts')

</body>
</html>
