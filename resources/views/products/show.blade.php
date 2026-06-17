@extends('layouts.app')

@section('title', $product->ten . ' - YUKI Gaming Store')

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
        <li><a href="{{ route('products.index', ['category' => $product->danhMuc?->slug]) }}">{{ $product->danhMuc?->ten }}</a></li>
        <li class="breadcrumb-bar__active">{{ $product->ten }}</li>
    </ol>
</nav>

<main class="container-fluid px-4 px-xl-5 detail-page">
    @if (session('success'))
        <div class="store-alert">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="store-alert store-alert--err">{{ $errors->first() }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="detail-gallery">
                @if ($product->discountPercent())
                    <div class="detail-gallery__badge">-{{ $product->discountPercent() }}%</div>
                @endif
                <div class="detail-gallery__main owl-carousel" id="galleryMain">
                    @forelse ($product->hinhAnh as $image)
                        <div class="detail-gallery__slide">
                            <img src="{{ asset($image->duong_dan) }}" alt="{{ $product->ten }}">
                        </div>
                    @empty
                        <div class="detail-gallery__slide">
                            <img src="{{ asset('assets/images/library/logo.png') }}" alt="{{ $product->ten }}">
                        </div>
                    @endforelse
                </div>
                <div class="detail-gallery__thumbs" id="galleryThumbs">
                    @forelse ($product->hinhAnh as $idx => $image)
                        <button class="detail-gallery__thumb {{ $idx === 0 ? 'is-active' : '' }}" data-idx="{{ $idx }}">
                            <img src="{{ asset($image->duong_dan) }}" alt="{{ $product->ten }}">
                        </button>
                    @empty
                        <button class="detail-gallery__thumb is-active" data-idx="0">
                            <img src="{{ asset('assets/images/library/logo.png') }}" alt="{{ $product->ten }}">
                        </button>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="detail-info">
                <span class="detail-info__brand">{{ $product->thuongHieu?->ten ?? 'SKT' }}</span>
                <h1 class="detail-info__title">{{ $product->ten }}</h1>
                <p class="detail-info__subtitle">{{ $product->mo_ta_ngan }}</p>

                <div class="detail-info__rating">
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= round($product->diem_danh_gia) ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="detail-info__rating-text">{{ number_format($product->diem_danh_gia, 1) }} ({{ $product->so_luong_danh_gia }} đánh giá)</span>
                </div>

                <div class="detail-info__price-box">
                    <span class="detail-info__price">{{ $product->formattedPrice() }}</span>
                    @if ($product->formattedOldPrice())
                        <del class="detail-info__old-price">{{ $product->formattedOldPrice() }}</del>
                        <span class="detail-info__save">Tiết kiệm {{ number_format($product->gia_goc - $product->gia_ban, 0, ',', '.') }}đ</span>
                    @endif
                </div>

                <div class="detail-info__stock">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ $product->so_luong_ton > 0 ? 'Còn hàng' : 'Hết hàng' }}
                    <span>({{ $product->so_luong_ton }} sản phẩm)</span>
                </div>

                <div class="detail-info__features">
                    <div class="feature-chip"><i class="fa-solid fa-layer-group"></i> {{ $product->danhMuc?->ten }}</div>
                    <div class="feature-chip"><i class="fa-solid fa-eye"></i> {{ $product->luot_xem }} lượt xem</div>
                    <div class="feature-chip"><i class="fa-solid fa-fire"></i> {{ $product->luot_ban }} đã bán</div>
                    @if ($product->is_hot)
                        <div class="feature-chip"><i class="fa-solid fa-bolt"></i> HOT</div>
                    @endif
                </div>

                @if ($product->bienThe->count() > 1)
                    <div class="detail-info__variants" id="detailVariants" data-base-price="{{ (int) $product->gia_ban }}">
                        <p class="detail-info__variant-label">Màu sắc: <span class="detail-info__variant-current" id="selectedVariantName"></span></p>
                        <div class="detail-info__swatches">
                            @foreach ($product->bienThe as $variant)
                                <button type="button"
                                    class="detail-swatch {{ $loop->first ? 'is-active' : '' }} {{ $variant->so_luong_ton <= 0 ? 'is-soldout' : '' }}"
                                    data-variant="{{ $variant->ten_bien_the }}"
                                    data-hex="{{ $variant->ma_hex ?: '#222' }}"
                                    data-pricediff="{{ (int) $variant->gia_chenh_lech }}"
                                    data-stock="{{ (int) $variant->so_luong_ton }}"
                                    title="{{ $variant->ten_bien_the }}"
                                    @disabled($variant->so_luong_ton <= 0)>
                                    <span class="detail-swatch__dot" style="background:{{ $variant->ma_hex ?: '#222' }}"></span>
                                    <span class="detail-swatch__name">{{ $variant->ten_bien_the }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="detail-info__actions">
                    <div class="detail-qty">
                        <button class="detail-qty__btn" id="detailQtyMinus" type="button">-</button>
                        <input type="text" value="1" readonly class="detail-qty__input" id="detailQtyInput">
                        <button class="detail-qty__btn" id="detailQtyPlus" type="button">+</button>
                    </div>
                    <button class="detail-btn detail-btn--cart" id="detailAddCart" type="button" data-product-id="{{ $product->id }}">
                        <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                    </button>
                    @auth
                        @if ($wishlistItem)
                            <form action="{{ route('wishlist.destroy', $wishlistItem) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button class="detail-btn detail-btn--buy" type="submit">
                                    <i class="fa-solid fa-heart-crack"></i> Bo yeu thich
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist.store', $product) }}" method="POST" class="m-0">
                                @csrf
                                <button class="detail-btn detail-btn--buy" type="submit">
                                    <i class="fa-regular fa-heart"></i> Yeu thich
                                </button>
                            </form>
                        @endif
                    @else
                        <a class="detail-btn detail-btn--buy text-decoration-none" href="{{ route('login') }}">
                            <i class="fa-regular fa-heart"></i> Yeu thich
                        </a>
                    @endauth
                    <a class="detail-btn detail-btn--buy text-decoration-none" href="{{ route('products.index') }}">Mua tiếp</a>
                </div>

                <div class="detail-info__policies">
                    <div class="policy-item"><i class="fa-solid fa-truck-fast"></i><span>Miễn phí giao hàng từ 500K</span></div>
                    <div class="policy-item"><i class="fa-solid fa-shield-halved"></i><span>Bảo hành chính hãng</span></div>
                    <div class="policy-item"><i class="fa-solid fa-rotate-left"></i><span>Đổi trả trong 7 ngày</span></div>
                </div>
            </div>
        </div>
    </div>

    @if ($product->thongSo->count() || $product->mo_ta_day_du)
        <section class="review-section mt-5" data-aos="fade-up">
            <h3 class="review-section__title"><i class="fa-solid fa-circle-info"></i> Mô tả & thông số</h3>
            @if ($product->mo_ta_day_du)
                <p class="review-card__text mb-3">{{ $product->mo_ta_day_du }}</p>
            @endif
            @if ($product->thongSo->count())
                <div class="review-list">
                    @foreach ($product->thongSo as $spec)
                        <div class="review-card d-flex justify-content-between gap-3">
                            <strong class="review-card__author">{{ $spec->ten }}</strong>
                            <span class="review-card__text">{{ $spec->gia_tri }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    <section class="review-section mt-5" data-aos="fade-up">
        <h3 class="review-section__title"><i class="fa-solid fa-comments"></i> Đánh giá khách hàng</h3>

        <div class="review-list">
            @forelse ($product->danhGia as $review)
                <div class="review-card">
                    <div class="review-card__head">
                        <div class="review-card__avatar">{{ mb_substr($review->taiKhoan?->ho_ten ?? 'SKT', 0, 2) }}</div>
                        <div class="review-card__meta">
                            <strong class="review-card__author">{{ $review->taiKhoan?->ho_ten ?? 'Khách hàng' }}</strong>
                            <small class="review-card__date">
                                {{ $review->ngay_tao?->format('d/m/Y') }}
                                @if ($review->is_verified_purchase) · Đã mua hàng @endif
                            </small>
                        </div>
                        <div class="review-card__stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->so_sao ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="review-card__text">{{ $review->noi_dung ?: 'Khách hàng chưa để lại nội dung.' }}</p>
                </div>
            @empty
                <div class="review-card">
                    <p class="review-card__text">Chưa có đánh giá cho sản phẩm này.</p>
                </div>
            @endforelse
        </div>

        @if (session('success'))
            <div class="alert alert-success my-3 py-2 small"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
        @endif

        @auth
            @if ($hasReviewed)
                <div class="review-form">
                    <h5 class="review-form__title">Viết đánh giá của bạn</h5>
                    <p class="review-card__text"><i class="fa-solid fa-circle-check me-1"></i> Bạn đã đánh giá sản phẩm này. Cảm ơn bạn!</p>
                </div>
            @else
                <form class="review-form" action="{{ route('products.reviews.store', $product) }}" method="POST">
                    @csrf
                    <h5 class="review-form__title">Viết đánh giá của bạn</h5>
                    @error('review') <div class="auth-error-msg mb-2">{{ $message }}</div> @enderror
                    @error('so_sao') <div class="auth-error-msg mb-2">{{ $message }}</div> @enderror
                    <div class="review-form__row">
                        <div class="review-form__rating-pick">
                            <span>Đánh giá:</span>
                            <div class="star-pick" id="starPick">
                                <i class="fa-solid fa-star" data-val="1"></i>
                                <i class="fa-solid fa-star" data-val="2"></i>
                                <i class="fa-solid fa-star" data-val="3"></i>
                                <i class="fa-solid fa-star" data-val="4"></i>
                                <i class="fa-solid fa-star" data-val="5"></i>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="so_sao" id="reviewSoSao" value="{{ old('so_sao', 5) }}">
                    <textarea class="review-form__textarea" name="noi_dung" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm...">{{ old('noi_dung') }}</textarea>
                    <button type="submit" class="review-form__submit"><i class="fa-solid fa-paper-plane"></i> Gửi đánh giá</button>
                </form>
            @endif
        @else
            <div class="review-form">
                <h5 class="review-form__title">Viết đánh giá của bạn</h5>
                <p class="review-card__text">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.</p>
            </div>
        @endauth
    </section>

    @if ($relatedProducts->count())
        <section class="related-section mt-5 mb-5" data-aos="fade-up">
            <h3 class="related-section__title"><i class="fa-solid fa-layer-group"></i> Sản Phẩm Tương Tự</h3>
            <div class="related-carousel owl-carousel">
                @foreach ($relatedProducts as $product)
                    @include('products._card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection

@push('scripts')
<script>
/* Star picker đánh giá → đồng bộ vào input ẩn so_sao */
(function () {
    var pick = document.getElementById('starPick');
    var input = document.getElementById('reviewSoSao');
    if (!pick || !input) return;
    var stars = pick.querySelectorAll('i');
    function paint(val) {
        stars.forEach(function (s, i) { s.classList.toggle('is-active', i < val); });
    }
    stars.forEach(function (s) {
        s.addEventListener('click', function () {
            var v = parseInt(s.dataset.val) || 5;
            input.value = v;
            paint(v);
        });
    });
    paint(parseInt(input.value) || 5); // tô sẵn theo giá trị mặc định
})();

/* Chọn biến thể màu + Thêm vào giỏ (server, kèm màu & số lượng) */
(function () {
    var wrap     = document.getElementById('detailVariants');
    var swatches = wrap ? Array.prototype.slice.call(wrap.querySelectorAll('.detail-swatch')) : [];
    var nameEl   = document.getElementById('selectedVariantName');
    var priceEl  = document.querySelector('.detail-info__price');
    var basePrice = wrap ? (parseInt(wrap.dataset.basePrice) || 0) : 0;

    function fmt(n) { return Number(n).toLocaleString('vi-VN') + 'đ'; }

    function select(sw) {
        swatches.forEach(function (s) { s.classList.remove('is-active'); });
        sw.classList.add('is-active');
        if (nameEl) nameEl.textContent = sw.dataset.variant || '';
        var diff = parseInt(sw.dataset.pricediff) || 0;
        if (priceEl && basePrice) priceEl.textContent = fmt(basePrice + diff);
    }

    if (swatches.length) {
        // mặc định chọn biến thể đầu tiên còn hàng
        var init = swatches.filter(function (s) { return !s.disabled; })[0] || swatches[0];
        select(init);
        swatches.forEach(function (sw) {
            sw.addEventListener('click', function () { if (!sw.disabled) select(sw); });
        });
    }

    // Thêm vào giỏ — POST lên server (animation bay vào giỏ do script.js lo)
    var addBtn   = document.getElementById('detailAddCart');
    var qtyInput = document.getElementById('detailQtyInput');
    var csrf     = document.querySelector('meta[name="csrf-token"]');
    csrf = csrf ? csrf.content : null;
    // Lấy id từ data-attribute của nút (tránh biến $product bị ghi đè bởi vòng lặp "sản phẩm tương tự")
    var productId = addBtn ? parseInt(addBtn.dataset.productId) : null;

    function openDrawer() {
        var drawer = document.getElementById('cartDrawer');
        if (!drawer) return;
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('is-locked');
    }

    function buildItem(item) {
        var sp = item.san_pham || {};
        var img = (sp.hinh_anh && sp.hinh_anh[0]) ? sp.hinh_anh[0].duong_dan : 'assets/images/library/logo.png';
        var price = Number(item.gia_tai_thoi_diem).toLocaleString('vi-VN') + 'đ';
        var variant = item.mau_sac || 'Mặc định';
        return '<div class="cart-item" data-item-id="' + item.id + '">'
            + '<div class="cart-item__img"><img src="/' + img + '" alt=""></div>'
            + '<div class="cart-item__info"><h6 class="cart-item__name">' + (sp.ten || 'Sản phẩm') + '</h6>'
            + '<span class="cart-item__price">' + price + '</span>'
            + '<p class="cart-item__variant">Phân loại: ' + variant + '</p></div>'
            + '<div class="cart-item__actions"><div class="qty-input">'
            + '<button type="button" class="qty-input__btn" data-drawer-minus>−</button>'
            + '<input type="text" value="' + item.so_luong + '" readonly>'
            + '<button type="button" class="qty-input__btn" data-drawer-plus>+</button></div>'
            + '<button type="button" class="cart-item__remove" data-drawer-remove aria-label="Xóa"><i class="fa-solid fa-trash-can"></i></button></div></div>';
    }

    function updateCartUI(data) {
        document.querySelectorAll('#cartBadge, #cartCount').forEach(function (b) {
            b.style.display = data.cart_count > 0 ? '' : 'none';
            b.textContent = data.cart_count;
        });
        var totalEl = document.getElementById('cartTotal');
        if (totalEl) totalEl.innerHTML = Number(data.tong.tong_tien).toLocaleString('vi-VN') + '<sup>đ</sup>';
        var list = document.getElementById('cartList');
        var empty = document.getElementById('cartDrawerEmpty');
        if (empty) empty.remove();
        if (list && data.item) {
            var existing = list.querySelector('.cart-item[data-item-id="' + data.item.id + '"]');
            if (existing) {
                var inp = existing.querySelector('.qty-input input');
                if (inp) inp.value = data.item.so_luong;
            } else {
                list.insertAdjacentHTML('beforeend', buildItem(data.item));
            }
        }
    }

    if (addBtn && csrf) {
        addBtn.addEventListener('click', function () {
            var active = wrap ? wrap.querySelector('.detail-swatch.is-active') : null;
            var mauSac = active ? active.dataset.variant : null;
            var qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

            fetch('/gio-hang', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ san_pham_id: productId, so_luong: qty, mau_sac: mauSac })
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.success) { alert((res && res.message) || 'Không thêm được sản phẩm'); return; }
                updateCartUI(res.data);
                setTimeout(openDrawer, 450); // mở giỏ sau khi animation bay xong
            })
            .catch(function () { alert('Có lỗi khi thêm vào giỏ, vui lòng thử lại.'); });
        });
    }
})();
</script>
@endpush
