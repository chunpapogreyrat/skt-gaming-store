<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SKT Gaming Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .store-link-card { color: inherit; text-decoration: none; }
        .store-link-card:hover { color: inherit; }
        .store-pagination .pagination { gap: 6px; justify-content: center; margin-top: 24px; }
        .store-pagination .page-link { background: rgba(10,12,16,.65); border-color: rgba(255,255,255,.08); color: #cbd5e1; border-radius: 8px; }
        .store-pagination .active .page-link,
        .store-pagination .page-link:hover { background: var(--red); border-color: var(--red); color: #fff; }
        .store-filter-form { display: grid; gap: 10px; }
        .store-filter-input { width: 100%; background: rgba(10,12,16,.6); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; color: #fff; font-size: .85rem; padding: 9px 12px; outline: none; }
        .store-filter-input:focus { border-color: var(--red); }
        .store-alert { border: 1px solid rgba(255,255,255,.08); border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; color: #dbeafe; background: rgba(0,229,255,.07); }
        .store-alert--err { color: #fecdd3; background: rgba(255,0,60,.08); border-color: rgba(255,0,60,.25); }
    </style>
    @stack('styles')
</head>
<body class="dark-theme">
    <div class="announcement-bar">
        <div class="announcement-bar__track">
            <span>MIEN PHI VAN CHUYEN don hang tu 500K &nbsp;&bull;&nbsp;</span>
            <span>FLASH SALE MOI THU 6 - GIAM DEN 50% &nbsp;&bull;&nbsp;</span>
            <span>BAO HANH CHINH HANG 24 THANG &nbsp;&bull;&nbsp;</span>
            <span>FINALMOUSE ULX VUA VE KHO &nbsp;&bull;&nbsp;</span>
            <span>MIEN PHI VAN CHUYEN don hang tu 500K &nbsp;&bull;&nbsp;</span>
            <span>FLASH SALE MOI THU 6 - GIAM DEN 50% &nbsp;&bull;&nbsp;</span>
        </div>
    </div>

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
                    <li><a href="{{ route('products.index', ['tag' => 'hot']) }}" class="navbar__link">Bán chạy</a></li>
                    <li><a href="{{ route('products.index', ['tag' => 'sale']) }}" class="navbar__link">Sale</a></li>
                </ul>
                <div class="navbar__actions">
                    <a href="{{ route('products.index') }}" class="navbar__icon-btn" aria-label="Tìm kiếm"><i class="fa-solid fa-magnifying-glass"></i></a>
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('profile.show') }}" class="navbar__icon-btn" aria-label="Tài khoản"><i class="fa-regular fa-user"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="navbar__icon-btn" aria-label="Đăng nhập"><i class="fa-regular fa-user"></i></a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="site-footer mt-5">
        <div class="container-fluid px-4 px-xl-5">
            <div class="row g-4 site-footer__top">
                <div class="col-lg-5 col-md-6">
                    <a href="{{ route('home') }}" class="site-footer__logo"><span class="site-footer__logo-skt">SKT</span> GAMING STORE</a>
                    <p class="site-footer__desc">Vu khi toi thuong cho game thu chuyen nghiep. Engineered for extreme performance.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="site-footer__col-title">SAN PHAM</h6>
                    <ul class="site-footer__links list-unstyled">
                        <li><a href="{{ route('products.index', ['category' => 'keyboard']) }}">Ban phim co</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'mice']) }}">Chuot gaming</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'mousepad']) }}">Lot chuot</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="site-footer__col-title">TAI KHOAN</h6>
                    <ul class="site-footer__links list-unstyled">
                        @auth
                            <li><a href="{{ route('profile.show') }}">Tai khoan cua toi</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn p-0 text-secondary">Dang xuat</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Dang nhap</a></li>
                            <li><a href="{{ route('register') }}">Dang ky</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
