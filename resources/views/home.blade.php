@extends('layouts.app')

@section('title', 'YUKI Gaming Store - Đỉnh Cao Trải Nghiệm')

@section('content')

{{-- #region HERO --}}
<section class="hero-slider">
    <div class="hero-slider__bg" id="heroBg"></div>
    <div class="hero-slider__content">
        <h1 id="heroTitle"></h1>
        <p id="heroDesc"></p>
        <a href="{{ route('products.index') }}" class="btn-main"><span>Khám phá ngay</span></a>
    </div>
    <div class="hero-slider__track" id="heroTrack">
        <div class="hero-card" data-title="Gaming Gear Đỉnh Cao"
            data-desc="Trang bị vũ khí — chinh phục mọi chiến trường"
            style="background-image: url('{{ asset('assets/images/slider/1.jpg') }}')"></div>
        <div class="hero-card" data-title="Chuột Gaming Pro"
            data-desc="Cảm biến quang học bậc nhất — phản xạ 0 độ trễ"
            style="background-image: url('{{ asset('assets/images/slider/2.jpg') }}')"></div>
        <div class="hero-card" data-title="Bàn Phím Cơ Custom"
            data-desc="Hall Effect & Rapid Trigger — cú bấm hoàn hảo nhất"
            style="background-image: url('{{ asset('assets/images/slider/3.jpg') }}')"></div>
        <div class="hero-card" data-title="Màn Hình Esports 360Hz"
            data-desc="Từng khung hình là lợi thế — DyAc+ không bóng mờ"
            style="background-image: url('{{ asset('assets/images/slider/4.jpg') }}')"></div>
        <div class="hero-card" data-title="Setup RGB Cá Tính"
            data-desc="Góc chơi game nổi bật — đồng bộ từ bàn phím đến lót chuột"
            style="background-image: url('{{ asset('assets/images/slider/5.png') }}')"></div>
        <div class="hero-card" data-title="Màn Hình Gaming Sắc Nét"
            data-desc="Hiển thị mượt mà — tối ưu từng pha xử lý tốc độ cao"
            style="background-image: url('{{ asset('assets/images/slider/screen.png') }}')"></div>
    </div>
    <div class="hero-nav"><button id="prevBtn">&#8249;</button><button id="nextBtn">&#8250;</button></div>
</section>
{{-- #endregion --}}

{{-- #region MAIN --}}
<main class="container-fluid main-wrap px-4 px-xl-5">
    <div class="row g-4">

        {{-- COL 1 (3/12) — Sidebar --}}
        <aside class="col-lg-3">
            <div class="m-panel mb-4" data-aos="fade-right">
                <h5 class="m-panel__title">DANH MỤC SẢN PHẨM</h5>
                <ul class="cat-menu list-unstyled m-0">
                    @forelse($danhMucs as $dm)
                    <li>
                        <a href="{{ route('products.index', ['category' => $dm->slug]) }}" class="cat-menu__link">
                            <span>{{ $dm->ten }}</span><i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                    @empty
                    <li><a href="#" class="cat-menu__link"><span>Bàn Phím Cơ</span><i class="fa-solid fa-angle-right"></i></a></li>
                    <li><a href="#" class="cat-menu__link"><span>Chuột Gaming</span><i class="fa-solid fa-angle-right"></i></a></li>
                    <li><a href="#" class="cat-menu__link"><span>Tai Nghe Esports</span><i class="fa-solid fa-angle-right"></i></a></li>
                    <li><a href="#" class="cat-menu__link"><span>Lót Chuột & Phụ Kiện</span><i class="fa-solid fa-angle-right"></i></a></li>
                    @endforelse
                </ul>
            </div>

            <div class="m-panel mb-4" data-aos="fade-right" data-aos-delay="100">
                <h5 class="m-panel__title">TOP BÁN CHẠY</h5>
                <div class="top-list">
                    @forelse($topBanChay as $sp)
                    <a href="{{ route('products.show', $sp->slug) }}" class="top-card" style="text-decoration:none;color:inherit">
                        <div class="top-card__img"><img src="{{ asset($sp->mainImagePath()) }}" alt="{{ $sp->ten }}"></div>
                        <div class="top-card__info">
                            <p class="top-card__name">{{ $sp->ten }}</p>
                            <span class="top-card__price">{{ $sp->formattedPrice() }}</span>
                        </div>
                    </a>
                    @empty
                    <div class="top-card">
                        <div class="top-card__img"><img src="{{ asset('assets/images/products/keyboard/centauri/1.webp') }}" alt=""></div>
                        <div class="top-card__info">
                            <p class="top-card__name">Akko 3098B Neon</p>
                            <span class="top-card__price">2.450.000đ</span>
                        </div>
                    </div>
                    <div class="top-card">
                        <div class="top-card__img"><img src="{{ asset('assets/images/products/mice/tenz/1.webp') }}" alt=""></div>
                        <div class="top-card__info">
                            <p class="top-card__name">Logitech G Pro X</p>
                            <span class="top-card__price">3.190.000đ</span>
                        </div>
                    </div>
                    <div class="top-card">
                        <div class="top-card__img"><img src="{{ asset('assets/images/products/mice/frostlord/1.webp') }}" alt=""></div>
                        <div class="top-card__info">
                            <p class="top-card__name">HS80 Wireless</p>
                            <span class="top-card__price">2.990.000đ</span>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('products.index', ['category' => 'keyboard']) }}" class="ad-block mb-3" data-aos="fade-right" data-aos-delay="200">
                <img src="{{ asset('assets/images/banners/keyboard-banner.jpg') }}" alt="" class="ad-block__img">
                <div class="ad-block__overlay">
                    <span class="ad-block__tag">PROMOTION</span>
                    <h6 class="ad-block__title">TUẦN LỄ LOGITECH G</h6>
                    <p class="ad-block__sub">Giảm đến 40% phụ kiện</p>
                </div>
            </a>
            <a href="{{ route('products.index', ['tag' => 'sale']) }}" class="ad-block mb-3" data-aos="fade-right" data-aos-delay="300">
                <img src="{{ asset('assets/images/banners/mouse-banner.jpg') }}" alt="" class="ad-block__img">
                <div class="ad-block__overlay">
                    <span class="ad-block__tag">FLASH DEAL</span>
                    <h6 class="ad-block__title">GIẢM 50% PHÍM CƠ</h6>
                    <p class="ad-block__sub">Số lượng có hạn trong ngày</p>
                </div>
            </a>
        </aside>

        {{-- COL 2 (9/12) — Sale + Featured grid --}}
        <section class="col-lg-9">

            {{-- Sale trong ngày --}}
            <div class="sale-box mb-4" data-aos="fade-up">
                <div class="sale-box__header">
                    <div class="sale-box__title"><i class="fa-solid fa-fire"></i> SALE TRONG NGÀY</div>
                    <div class="sale-box__timer">
                        <span id="timerH">02</span>:<span id="timerM">41</span>:<span id="timerS">15</span>
                    </div>
                    <div class="sale-box__nav">
                        <button class="owl-prev-custom" id="salePrev"><i class="fa-solid fa-arrow-left"></i></button>
                        <button class="owl-next-custom" id="saleNext"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="sale-carousel owl-carousel">
                    @forelse($sanPhamSale as $sp)
                    <a href="{{ route('products.show', $sp->slug) }}" class="deal-card">
                        @if($sp->discountPercent())
                        <span class="deal-card__badge">-{{ $sp->discountPercent() }}%</span>
                        @endif
                        <div class="deal-card__img">
                            <img src="{{ asset($sp->mainImagePath()) }}" alt="{{ $sp->ten }}">
                            <span class="deal-card__sale-stamp">SALE</span>
                        </div>
                        <p class="deal-card__name">{{ $sp->ten }}</p>
                        <span class="deal-card__price">{{ $sp->formattedPrice() }}</span>
                    </a>
                    @empty
                    {{-- Placeholder khi chưa có sản phẩm sale --}}
                    <div class="deal-card">
                        <span class="deal-card__badge">-30%</span>
                        <div class="deal-card__img"><img src="{{ asset('assets/images/products/keyboard/arc65/1.webp') }}" alt=""></div>
                        <p class="deal-card__name">Custom Keycap Pink</p>
                        <span class="deal-card__price">450.000đ</span>
                    </div>
                    <div class="deal-card">
                        <span class="deal-card__badge">-15%</span>
                        <div class="deal-card__img"><img src="{{ asset('assets/images/products/mice/sycrox-v6/1.webp') }}" alt=""></div>
                        <p class="deal-card__name">Pulsar X2 Wireless</p>
                        <span class="deal-card__price">1.890.000đ</span>
                    </div>
                    <div class="deal-card">
                        <span class="deal-card__badge">-20%</span>
                        <div class="deal-card__img"><img src="{{ asset('assets/images/products/mice/beast-x-max/1.webp') }}" alt=""></div>
                        <p class="deal-card__name">Gaming Headset Pro</p>
                        <span class="deal-card__price">1.100.000đ</span>
                    </div>
                    <div class="deal-card">
                        <span class="deal-card__badge">-25%</span>
                        <div class="deal-card__img"><img src="{{ asset('assets/images/products/keyboard/luce60/1.webp') }}" alt=""></div>
                        <p class="deal-card__name">LUCE60 Custom</p>
                        <span class="deal-card__price">2.500.000đ</span>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Featured grid --}}
            <div class="featured-grid" data-aos="fade-up" data-aos-delay="80">
                @forelse($sanPhamNoiBat as $sp)
                <article class="p-card">
                    @if($sp->is_sale && $sp->discountPercent())
                    <span class="p-card__tag p-card__tag--sale">-{{ $sp->discountPercent() }}%</span>
                    @elseif($sp->is_hot)
                    <span class="p-card__tag p-card__tag--hot">HOT</span>
                    @endif
                    <div class="p-card__media">
                        <a href="{{ route('products.show', $sp->slug) }}">
                            <img src="{{ asset($sp->mainImagePath()) }}" alt="{{ $sp->ten }}">
                        </a>
                        <button class="p-card__quick" data-product-id="{{ $sp->id }}">
                            <i class="fa-solid fa-plus"></i> Chọn nhanh
                        </button>
                    </div>
                    <div class="p-card__body">
                        <span class="p-card__brand">{{ strtoupper($sp->thuongHieu->ten ?? '') }}</span>
                        <h6 class="p-card__name">
                            <a href="{{ route('products.show', $sp->slug) }}" style="color:inherit;text-decoration:none">{{ $sp->ten }}</a>
                        </h6>
                        <p class="p-card__desc">{{ Str::limit($sp->mo_ta_ngan, 50) }}</p>
                        <div class="p-card__bottom">
                            <div class="p-card__prices">
                                <span class="p-card__price">{{ $sp->formattedPrice() }}</span>
                                @if($sp->formattedOldPrice())
                                <del class="p-card__old">{{ $sp->formattedOldPrice() }}</del>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                    <p class="text-secondary mb-3">Chưa có sản phẩm nào — chờ Codex chạy seeder để load data thực.</p>
                    <a href="{{ route('products.index') }}" class="btn-outline"><span>Xem sản phẩm</span></a>
                </div>
                @endforelse
            </div>

        </section>
    </div>

    {{-- Partners --}}
    <div class="partners mt-5" data-aos="fade-up">
        <h5 class="partners__title">CÁC HÃNG HỢP TÁC</h5>
        <div class="partners__row">
            @for($i = 1; $i <= 12; $i++)
            <div class="partners__item" data-aos="zoom-in" data-aos-delay="{{ ($i-1) * 60 }}">
                <img src="{{ asset('assets/images/brands/brand-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.jpg') }}" alt="">
            </div>
            @endfor
        </div>
    </div>
</main>
{{-- #endregion --}}

@endsection

@push('scripts')
<script>
    AOS.init({ duration: 700, once: true });
</script>
@endpush
