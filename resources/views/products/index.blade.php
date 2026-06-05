@extends('layouts.app')

@section('title', 'Sản Phẩm - SKT Gaming Store')

@section('content')
<nav class="breadcrumb-bar container-fluid px-4 px-xl-5">
    <ol class="breadcrumb-bar__list">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
        <li class="breadcrumb-bar__active">Sản phẩm</li>
    </ol>
</nav>

<main class="shop container-fluid px-4 px-xl-5">
    <header class="shop__head" data-aos="fade-up">
        <h1 class="shop__title">Kho Vũ Khí Gaming</h1>
        <p class="shop__sub">Danh sách sản phẩm lấy trực tiếp từ database Laravel.</p>
    </header>

    <div class="row g-4">
        <aside class="col-lg-3" data-aos="fade-right">
            <div class="shop-filter">
                <form method="GET" action="{{ route('products.index') }}" class="store-filter-form">
                    <h5 class="shop-filter__title"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</h5>
                    <input class="store-filter-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Tên sản phẩm, thương hiệu...">

                    <h5 class="shop-filter__title mt-4"><i class="fa-solid fa-filter"></i> Danh mục</h5>
                    <ul class="shop-filter__cats list-unstyled">
                        <li>
                            <a class="shop-cat {{ empty($filters['category']) || ($filters['category'] ?? '') === 'all' ? 'is-active' : '' }}" href="{{ route('products.index', request()->except('category', 'page')) }}">
                                Tất cả <span>{{ $categories->sum('products_count') }}</span>
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            <li>
                                <a class="shop-cat {{ ($filters['category'] ?? '') === $category->slug ? 'is-active' : '' }}" href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}">
                                    <i class="fa-solid fa-layer-group"></i> {{ $category->ten }} <span>{{ $category->products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <h5 class="shop-filter__title mt-4"><i class="fa-solid fa-copyright"></i> Thương hiệu</h5>
                    <select class="store-filter-input" name="brand">
                        <option value="">Tất cả thương hiệu</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(($filters['brand'] ?? '') === $brand->slug)>
                                {{ $brand->ten }} ({{ $brand->products_count }})
                            </option>
                        @endforeach
                    </select>

                    <h5 class="shop-filter__title mt-4"><i class="fa-solid fa-tags"></i> Khoảng giá</h5>
                    <div class="row g-2">
                        <div class="col-6">
                            <input class="store-filter-input" type="number" name="price_min" value="{{ $filters['price_min'] ?? '' }}" placeholder="Từ">
                        </div>
                        <div class="col-6">
                            <input class="store-filter-input" type="number" name="price_max" value="{{ $filters['price_max'] ?? '' }}" placeholder="Đến">
                        </div>
                    </div>

                    <h5 class="shop-filter__title mt-4"><i class="fa-solid fa-bolt"></i> Nhãn</h5>
                    <select class="store-filter-input" name="tag">
                        <option value="">Tất cả</option>
                        <option value="hot" @selected(($filters['tag'] ?? '') === 'hot')>Bán chạy / HOT</option>
                        <option value="sale" @selected(($filters['tag'] ?? '') === 'sale')>Đang giảm giá</option>
                    </select>

                    <button class="review-form__submit mt-3" type="submit">Áp dụng lọc</button>
                    <a class="shop-cat justify-content-center" href="{{ route('products.index') }}">Xóa bộ lọc</a>
                </form>

                <div class="shop-filter__promo">
                    <i class="fa-solid fa-gift"></i>
                    <p>Nhập mã <strong>YUKISALE</strong> giảm 10% toàn bộ đơn hàng.</p>
                </div>
            </div>
        </aside>

        <section class="col-lg-9" data-aos="fade-up" data-aos-delay="60">
            <form method="GET" action="{{ route('products.index') }}" class="shop-toolbar">
                @foreach (request()->except('sort', 'page') as $key => $value)
                    @if (is_scalar($value) && $value !== '')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <span class="shop-toolbar__count">Hiển thị <strong>{{ $products->total() }}</strong> sản phẩm</span>
                <div class="shop-toolbar__sort">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="default" @selected(($filters['sort'] ?? 'default') === 'default')>Mặc định</option>
                        <option value="price-asc" @selected(($filters['sort'] ?? '') === 'price-asc')>Giá: Thấp đến cao</option>
                        <option value="price-desc" @selected(($filters['sort'] ?? '') === 'price-desc')>Giá: Cao đến thấp</option>
                        <option value="name" @selected(($filters['sort'] ?? '') === 'name')>Tên A đến Z</option>
                        <option value="rating" @selected(($filters['sort'] ?? '') === 'rating')>Đánh giá cao</option>
                        <option value="best-seller" @selected(($filters['sort'] ?? '') === 'best-seller')>Bán chạy</option>
                        <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Mới nhất</option>
                    </select>
                </div>
            </form>

            @if ($products->count())
                <div class="shop-grid">
                    @foreach ($products as $product)
                        @include('products._card', ['product' => $product])
                    @endforeach
                </div>
                <div class="store-pagination">
                    {{ $products->links() }}
                </div>
            @else
                <div class="shop-empty is-show">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <strong>Không tìm thấy sản phẩm</strong>
                    <span>Thử chọn danh mục, thương hiệu hoặc mức giá khác.</span>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection
