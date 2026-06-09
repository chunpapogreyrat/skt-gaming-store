@extends('layouts.admin')

@section('title', 'Dashboard - YUKI Admin')
@section('nav-dashboard', 'is-active')

@section('content')
<h1 class="admin-page-title">Dashboard</h1>
<p class="admin-page-sub">Tổng quan hoạt động cửa hàng</p>

<section class="admin-stats">
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--red"><i class="fa-solid fa-sack-dollar"></i></div>
        </div>
        <div class="admin-stat__value">{{ number_format($thongKe['doanh_thu']) }}đ</div>
        <div class="admin-stat__label">Doanh thu (đã giao)</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--cyan"><i class="fa-solid fa-receipt"></i></div>
        </div>
        <div class="admin-stat__value">{{ number_format($thongKe['so_don_hang']) }}</div>
        <div class="admin-stat__label">Đơn hàng ({{ $thongKe['so_don_cho_xu_ly'] }} chờ xử lý)</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--green"><i class="fa-solid fa-box"></i></div>
        </div>
        <div class="admin-stat__value">{{ number_format($thongKe['so_san_pham']) }}</div>
        <div class="admin-stat__label">Sản phẩm</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--amber"><i class="fa-solid fa-users"></i></div>
        </div>
        <div class="admin-stat__value">{{ number_format($thongKe['so_nguoi_dung']) }}</div>
        <div class="admin-stat__label">Người dùng</div>
    </div>
</section>

<section class="admin-grid-2">
    <div class="admin-panel">
        <div class="admin-panel__head">
            <h3 class="admin-panel__title">Doanh thu 7 ngày</h3>
        </div>
        @php $max = max(array_values($doanhThu7Ngay)) ?: 1; @endphp
        <div class="admin-chart">
            @foreach($doanhThu7Ngay as $ngay => $tong)
            <div class="admin-chart__bar" style="height: {{ max(6, ($tong / $max) * 100) }}%"
                 data-label="{{ \Carbon\Carbon::parse($ngay)->format('d/m') }}"
                 title="{{ number_format($tong) }}đ"></div>
            @endforeach
        </div>
    </div>
    <div class="admin-panel">
        <div class="admin-panel__head"><h3 class="admin-panel__title">Trạng thái đơn</h3></div>
        <p class="admin-stat__label mb-2">Chờ xác nhận: <strong>{{ $thongKe['so_don_cho_xu_ly'] }}</strong></p>
        <p class="admin-stat__label">Tổng đơn: <strong>{{ $thongKe['so_don_hang'] }}</strong></p>
    </div>
</section>

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Đơn hàng mới nhất</h3>
        <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--ghost admin-btn--sm">Xem tất cả</a>
    </div>
    <table class="admin-table">
        <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Trạng thái</th></tr></thead>
        <tbody>
            @forelse($donMoiNhat as $don)
            <tr class="admin-table__row">
                <td><strong>#{{ $don->ma_don_hang }}</strong></td>
                <td>{{ $don->ten_nguoi_nhan }}</td>
                <td class="admin-table__price">{{ number_format($don->tong_tien) }}đ</td>
                <td><span class="admin-badge admin-badge--{{ ['cho_xac_nhan'=>'pending','dang_chuan_bi'=>'prep','dang_giao'=>'shipping','da_giao'=>'done','da_huy'=>'cancel'][$don->trang_thai_don_hang] ?? 'pending' }}">{{ $don->tenTrangThai() }}</span></td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="4" class="admin-table__muted">Chưa có đơn hàng</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
