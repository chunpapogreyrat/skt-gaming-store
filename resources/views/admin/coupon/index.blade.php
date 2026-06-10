@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá - YUKI Admin')
@section('nav-coupons', 'is-active')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Quản lý mã giảm giá</h1>
        <p class="admin-page-sub">{{ $maGiamGias->total() }} mã giảm giá</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="admin-btn admin-btn--primary"><i class="fa-solid fa-plus"></i> Thêm mã giảm giá</a>
</div>

@if (session('success'))
    <div class="alert alert-success py-2 small my-3"><i class="fa-solid fa-circle-check me-1"></i>{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger py-2 small my-3"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ session('error') }}</div>
@endif

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách mã</h3>
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="d-flex gap-2 flex-wrap align-items-center">
            <input name="q" value="{{ request('q') }}" class="admin-status-select" placeholder="Tìm mã code...">
            <button type="submit" class="admin-btn admin-btn--primary" title="Tìm"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request('q'))
                <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--ghost" title="Xóa lọc"><i class="fa-solid fa-xmark"></i></a>
            @endif
        </form>
    </div>
    <table class="admin-table">
        <thead><tr><th>Mã code</th><th>Giảm</th><th>Đơn tối thiểu</th><th>Đã dùng</th><th>Hạn</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
        <tbody>
            @forelse($maGiamGias as $ma)
            @php
                $chuaMo  = $ma->ngay_bat_dau && $ma->ngay_bat_dau->isFuture();
                $hetHan  = $ma->ngay_het_han && $ma->ngay_het_han->isPast();
                $hetLuot = $ma->so_lan_su_dung_toi_da && $ma->so_lan_da_dung >= $ma->so_lan_su_dung_toi_da;
                $trangThaiText = !$ma->trang_thai ? 'Ngừng'
                    : ($hetHan ? 'Hết hạn' : ($hetLuot ? 'Hết lượt' : ($chuaMo ? 'Chưa mở' : 'Hoạt động')));
            @endphp
            <tr class="admin-table__row">
                <td><div class="admin-table__name"><strong>{{ $ma->ma_code }}</strong></div></td>
                <td class="admin-table__price">{{ $ma->loai=='phan_tram' ? rtrim(rtrim(number_format($ma->gia_tri,2),'0'),'.').'%' : number_format($ma->gia_tri).'đ' }}</td>
                <td>{{ $ma->gia_tri_don_toi_thieu > 0 ? number_format($ma->gia_tri_don_toi_thieu).'đ' : '—' }}</td>
                <td>{{ $ma->so_lan_da_dung }} / {{ $ma->so_lan_su_dung_toi_da ?? '∞' }}</td>
                <td>{{ $ma->ngay_het_han?->format('d/m/Y') ?? '—' }}</td>
                <td><span class="admin-badge admin-badge--{{ $ma->conHieuLuc()?'done':'cancel' }}">{{ $trangThaiText }}</span></td>
                <td><div class="d-flex gap-2">
                    <a href="{{ route('admin.coupons.edit', $ma->id) }}" class="admin-icon-btn" title="Sửa"><i class="fa-solid fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.coupons.destroy', $ma->id) }}" onsubmit="return confirm('Xóa mã {{ $ma->ma_code }}?')">
                        @csrf @method('DELETE')
                        <button class="admin-icon-btn admin-icon-btn--danger" title="Xóa"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </div></td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="7" class="admin-table__muted">Chưa có mã giảm giá</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $maGiamGias->links() }}</div>
</section>
@endsection
