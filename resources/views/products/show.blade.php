@extends('layouts.app')

@section('title', $product->ten . ' - SKT Gaming Store')

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

                @if ($product->bienThe->count())
                    <div class="detail-info__variants">
                        <p class="detail-info__variant-label">Biến thể:</p>
                        <div class="detail-info__swatches">
                            @foreach ($product->bienThe as $variant)
                                <button class="detail-swatch {{ $loop->first ? 'is-active' : '' }}" style="background:{{ $variant->ma_hex ?: '#222' }}" title="{{ $variant->ten_bien_the }}"></button>
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
                    <button class="detail-btn detail-btn--cart" id="detailAddCart" type="button">
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

        <div class="review-form">
            <h4 class="review-form__title">Viết đánh giá</h4>
            @guest
                <p class="review-card__text">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.</p>
            @else
                @if ($canReview)
                    <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                        @csrf
                        <div class="review-form__row">
                            <select class="store-filter-input" name="so_sao" required>
                                <option value="">Chọn số sao</option>
                                @for ($star = 5; $star >= 1; $star--)
                                    <option value="{{ $star }}" @selected(old('so_sao') == $star)>{{ $star }} sao</option>
                                @endfor
                            </select>
                        </div>
                        <textarea class="review-form__textarea mt-3" name="noi_dung" rows="4" placeholder="Cảm nhận của bạn về sản phẩm...">{{ old('noi_dung') }}</textarea>
                        <button class="review-form__submit mt-3" type="submit">Gửi đánh giá</button>
                    </form>
                @elseif ($hasReviewed)
                    <p class="review-card__text">Bạn đã đánh giá sản phẩm này.</p>
                @else
                    <p class="review-card__text">Bạn cần mua và nhận sản phẩm này trước khi đánh giá.</p>
                @endif
            @endguest
        </div>
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
