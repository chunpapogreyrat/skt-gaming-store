{{-- Lớp phủ tìm kiếm --}}
<div class="search-overlay" id="searchOverlay" aria-hidden="true">
    <div class="search-overlay__panel">
        <form class="search-overlay__head" action="{{ route('products.index') }}" method="GET">
            <i class="fa-solid fa-magnifying-glass search-overlay__icon"></i>
            <input type="text" name="q" id="searchInput" class="search-overlay__input" placeholder="Tìm chuột, bàn phím, tai nghe..." value="{{ request('q') }}">
            <button type="button" class="search-overlay__close" id="closeSearchBtn" aria-label="Đóng"><i class="fa-solid fa-xmark"></i></button>
        </form>
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
