@extends('layouts.admin')

@section('title', 'Doanh thu - YUKI Admin')
@section('nav-revenue', 'is-active')

@php
    // Định dạng gọn: 142.5M / 1.7K / số nguyên
    $fmt = function ($v) {
        if ($v >= 1000000) return rtrim(rtrim(number_format($v / 1000000, 1), '0'), '.') . 'M';
        if ($v >= 1000) return rtrim(rtrim(number_format($v / 1000, 1), '0'), '.') . 'K';
        return number_format($v);
    };
    $card = $baoCao['card'];
    $tenThang = ['', 'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

    // Badge xu hướng (% so tháng trước); null = không có kỳ trước
    $trend = function ($t) {
        if ($t === null) return '<span class="admin-stat__trend">— kỳ đầu</span>';
        $arrow = $t >= 0 ? 'up' : 'down';
        return '<span class="admin-stat__trend admin-stat__trend--' . $arrow . '"><i class="fa-solid fa-arrow-' . $arrow . '"></i> ' . abs($t) . '%</span>';
    };
@endphp

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Doanh thu</h1>
        <p class="admin-page-sub">{{ $tenThang[$baoCao['thang']] }} / {{ $baoCao['nam'] }} · chỉ tính đơn đã giao</p>
    </div>
    <form method="GET" action="{{ route('admin.revenue') }}" class="d-flex gap-2">
        <select name="thang" class="admin-status-select" onchange="this.form.submit()">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" @selected($baoCao['thang'] == $m)>T{{ $m }}</option>
            @endfor
        </select>
        <select name="nam" class="admin-status-select" onchange="this.form.submit()">
            @foreach ($baoCao['cac_nam'] as $y)
                <option value="{{ $y }}" @selected($baoCao['nam'] == $y)>{{ $y }}</option>
            @endforeach
        </select>
    </form>
</div>

{{-- STAT CARDS --}}
<section class="admin-stats" style="margin:24px 0">
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--red"><i class="fa-solid fa-chart-line"></i></div>
            {!! $trend($card['doanh_thu_mom']) !!}
        </div>
        <div class="admin-stat__value">{{ $fmt($card['doanh_thu']) }}</div>
        <div class="admin-stat__label">Doanh thu tháng này</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--cyan"><i class="fa-solid fa-circle-check"></i></div>
            {!! $trend($card['don_mom']) !!}
        </div>
        <div class="admin-stat__value">{{ $card['don_hoan_thanh'] }}</div>
        <div class="admin-stat__label">Đơn hoàn thành</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--amber"><i class="fa-solid fa-receipt"></i></div>
            {!! $trend($card['tb_mom']) !!}
        </div>
        <div class="admin-stat__value">{{ $fmt($card['tb_don']) }}</div>
        <div class="admin-stat__label">Giá trị TB/đơn</div>
    </div>
    <div class="admin-card">
        <div class="admin-stat__top">
            <div class="admin-stat__icon admin-stat__icon--green"><i class="fa-solid fa-user-plus"></i></div>
            {!! $trend($card['khach_mom']) !!}
        </div>
        <div class="admin-stat__value">{{ $card['khach_moi'] }}</div>
        <div class="admin-stat__label">Khách mới</div>
    </div>
</section>

{{-- CHART --}}
<div class="admin-panel mb-4">
    <div class="admin-panel__head">
        <h3 class="admin-panel__title">Biểu đồ doanh thu 12 tháng · {{ $baoCao['nam'] }}</h3>
    </div>
    @if ($baoCao['max_doanh_thu'] > 0)
    <div class="admin-chart" style="height:260px; padding-bottom:28px;">
        @foreach ($baoCao['thang_data'] as $m)
            @php $pct = $baoCao['max_doanh_thu'] > 0 ? round($m['doanh_thu'] / $baoCao['max_doanh_thu'] * 100) : 0; @endphp
            <div class="admin-chart__bar {{ $m['thang'] == $baoCao['thang'] ? 'is-selected' : '' }}"
                 style="height: {{ max($pct, 2) }}%"
                 data-label="T{{ $m['thang'] }}"
                 data-val="{{ $fmt($m['doanh_thu']) }}"
                 title="{{ $tenThang[$m['thang']] }}: {{ number_format($m['doanh_thu']) }}đ"></div>
        @endforeach
    </div>
    @else
        <p class="admin-table__muted" style="padding:24px 0">Chưa có doanh thu (đơn đã giao) trong năm {{ $baoCao['nam'] }}.</p>
    @endif
</div>

{{-- TABLE --}}
<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Chi tiết theo tháng · {{ $baoCao['nam'] }}</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr><th>Tháng</th><th>Doanh thu</th><th>Đơn hàng</th><th>Trung bình/đơn</th><th>So tháng trước</th></tr>
        </thead>
        <tbody>
            @foreach ($baoCao['thang_data'] as $m)
            <tr class="admin-table__row" @if($m['thang'] == $baoCao['thang']) style="background:rgba(0,255,255,.04)" @endif>
                <td><strong>{{ $tenThang[$m['thang']] }} / {{ $baoCao['nam'] }}</strong></td>
                <td class="admin-table__price">{{ number_format($m['doanh_thu']) }}đ</td>
                <td>{{ $m['so_don'] }}</td>
                <td>{{ number_format($m['tb_don']) }}đ</td>
                <td>
                    @if ($m['mom'] !== null)
                        <span class="admin-badge admin-badge--{{ $m['mom'] >= 0 ? 'done' : 'cancel' }}">{{ $m['mom'] >= 0 ? '+' : '' }}{{ $m['mom'] }}%</span>
                    @else
                        <span class="admin-table__muted">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<style>
.admin-chart__bar.is-selected { background: linear-gradient(180deg, var(--cyber-cyan, #00ffff), rgba(0,255,255,.35)); }
.admin-chart__bar::before {
    content: attr(data-val);
    position: absolute; top: -18px; left: 0; right: 0;
    text-align: center; font-size: 10px; color: var(--text-muted);
    opacity: 0; transition: opacity .2s;
}
.admin-chart__bar:hover::before { opacity: 1; }
</style>
@endsection
