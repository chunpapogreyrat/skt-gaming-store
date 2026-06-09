@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng - YUKI Gaming Store')

@section('content')
@php
    $statusMap = [
        'cho_xac_nhan'  => ['Chờ xác nhận', 'order-status--pending', 'fa-clock'],
        'dang_chuan_bi' => ['Đang chuẩn bị', 'order-status--pending', 'fa-box'],
        'dang_giao'     => ['Đang giao', 'order-status--shipping', 'fa-truck'],
        'da_giao'       => ['Đã giao', 'order-status--done', 'fa-check'],
        'da_huy'        => ['Đã hủy', 'order-status--cancel', 'fa-xmark'],
    ];
    $filters = [
        '' => 'Tất cả',
        'cho_xac_nhan' => 'Chờ xác nhận',
        'dang_giao' => 'Đang giao',
        'da_giao' => 'Đã giao',
        'da_huy' => 'Đã hủy',
    ];
@endphp

<main class="order-history container-fluid px-4 px-xl-5">
    <header class="order-history__head" data-aos="fade-up">
        <span class="order-history__eyebrow"><i class="fa-solid fa-box"></i> YUKI Order Center</span>
        <h1 class="order-history__title">Lịch sử đơn hàng</h1>
        <p class="order-history__subtitle">Theo dõi và quản lý tất cả đơn hàng của bạn</p>
    </header>

    <div class="order-history__filters">
        @foreach ($filters as $key => $label)
            <a href="{{ route('orders.index', $key ? ['status' => $key] : []) }}"
               class="order-history__filter {{ ($status ?? '') === $key ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="order-history__list">
        @forelse ($donHangs as $donHang)
            @php [$stLabel, $stClass, $stIcon] = $statusMap[$donHang->trang_thai_don_hang] ?? ['Đang xử lý', 'order-status--pending', 'fa-clock']; @endphp
            <article class="order-card" data-aos="fade-up">
                <div class="order-card__col">
                    <div class="order-card__code">{{ $donHang->ma_don_hang }}</div>
                    <div class="order-card__date"><i class="fa-regular fa-calendar"></i> {{ optional($donHang->created_at)->format('d/m/Y') }}</div>
                </div>
                <div class="order-card__col">
                    <div class="order-card__label">Sản phẩm</div>
                    <div class="order-card__value">{{ $donHang->chiTiet->sum('so_luong') }} sản phẩm</div>
                </div>
                <div class="order-card__col order-card__col--total">
                    <div class="order-card__label">Tổng tiền</div>
                    <div class="order-card__total">{{ number_format($donHang->tong_tien) }}đ</div>
                </div>
                <div class="order-card__col">
                    <span class="order-status {{ $stClass }}"><i class="fa-solid {{ $stIcon }}"></i> {{ $stLabel }}</span>
                </div>
                <div class="order-card__col order-card__col--action">
                    <a href="{{ route('orders.show', $donHang->ma_don_hang) }}" class="btn-outline" style="padding:10px 20px;font-size:12px">Xem chi tiết</a>
                </div>
            </article>
        @empty
            <div class="text-center text-secondary py-5">
                <i class="fa-solid fa-box-open" style="font-size:3rem;opacity:.3"></i>
                <p class="mt-3">Chưa có đơn hàng nào.</p>
                <a href="{{ route('products.index') }}" class="btn-main mt-2"><span>Mua sắm ngay</span></a>
            </div>
        @endforelse
    </div>

    <div class="store-pagination mt-4">
        {{ $donHangs->links() }}
    </div>
</main>
@endsection
