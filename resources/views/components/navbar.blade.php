{{-- Thanh điều hướng chính + user menu --}}
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
                    @php $u = auth()->user(); $uInitial = mb_strtoupper(mb_substr($u->ho_ten ?? 'U', 0, 1)); @endphp
                    {{-- User menu kiểu thiết kế (.user-menu) — bấm avatar để mở --}}
                    <div class="user-menu" id="userMenu">
                        <button type="button" class="navbar__icon-btn user-menu__trigger" aria-label="Tài khoản">
                            <span class="user-menu__avatar">{{ $uInitial }}</span>
                        </button>
                        <div class="user-menu__panel">
                            <div class="user-menu__head">
                                <span class="user-menu__avatar user-menu__avatar--lg">{{ $uInitial }}</span>
                                <div class="user-menu__head-info">
                                    <div class="user-menu__name">{{ $u->ho_ten }}</div>
                                    <div class="user-menu__rank"><i class="fa-solid fa-bolt"></i> Game thủ YUKI</div>
                                </div>
                            </div>
                            <a href="{{ route('profile.show') }}" class="user-menu__profile-btn"><i class="fa-solid fa-id-badge"></i> Xem trang cá nhân</a>
                            <div class="user-menu__divider"></div>
                            <a href="{{ route('orders.index') }}" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-box-archive"></i></span> Đơn hàng của tôi <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>
                            <a href="{{ route('profile.show', ['tab' => 'wishlist']) }}" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-heart"></i></span> Sản phẩm yêu thích <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>
                            <a href="{{ route('static.contact') }}" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-circle-question"></i></span> Trợ giúp & hỗ trợ <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>
                            @if($u->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="user-menu__item"><span class="user-menu__ico"><i class="fa-solid fa-gauge-high"></i></span> Trang quản trị <i class="fa-solid fa-chevron-right user-menu__arr"></i></a>
                            @endif
                            <div class="user-menu__divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="user-menu__item user-menu__item--logout w-100 border-0 bg-transparent text-start"><span class="user-menu__ico"><i class="fa-solid fa-right-from-bracket"></i></span> Đăng xuất</button>
                            </form>
                            <div class="user-menu__foot">YUKI Gaming Store · v2.0</div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="navbar__icon-btn" aria-label="Đăng nhập"><i class="fa-regular fa-user"></i></a>
                @endauth
            </div>
        </div>
    </div>
</nav>
