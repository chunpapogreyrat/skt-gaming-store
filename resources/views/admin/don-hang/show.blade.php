@extends('layouts.admin')

@section('title', 'Chi tiết đơn ' . $donHang->ma_don_hang . ' - SKT Admin')
@section('nav-orders', 'is-active')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="admin-page-title">Đơn #{{ $donHang->ma_don_hang }}</h1>
        <p class="admin-page-sub">{{ $donHang->created_at?->format('d/m/Y H:i') }} · {{ $donHang->tenTrangThai() }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn--ghost"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
</div>

<div class="admin-grid-2">
    <div class="admin-panel">
        <h3 class="admin-panel__title mb-3">Sản phẩm</h3>
        <table class="admin-table">
            <thead><tr><th>Sản phẩm</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
            <tbody>
                @foreach($donHang->chiTiet as $ct)
                <tr class="admin-table__row">
                    <td>{{ $ct->ten_san_pham }}@if($ct->mau_sac)<div class="admin-table__muted">{{ $ct->mau_sac }}</div>@endif</td>
                    <td>{{ $ct->so_luong }}</td>
                    <td>{{ number_format($ct->don_gia) }}đ</td>
                    <td class="admin-table__price">{{ number_format($ct->thanh_tien) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="admin-panel">
        <h3 class="admin-panel__title mb-3">Thông tin giao hàng</h3>
        <p><strong>{{ $donHang->ten_nguoi_nhan }}</strong> · {{ $donHang->sdt_nguoi_nhan }}</p>
        <p class="admin-table__muted">{{ $donHang->dia_chi_giao_hang }}, {{ $donHang->quan_huyen }}, {{ $donHang->tinh_thanh }}</p>
        @if($donHang->ghi_chu)<p class="admin-table__muted mt-2">Ghi chú: {{ $donHang->ghi_chu }}</p>@endif

        <hr style="border-color:rgba(255,255,255,.08)">
        <div class="d-flex justify-content-between"><span class="admin-table__muted">Tạm tính</span><span>{{ number_format($donHang->tam_tinh) }}đ</span></div>
        <div class="d-flex justify-content-between"><span class="admin-table__muted">Phí ship</span><span>{{ number_format($donHang->phi_ship) }}đ</span></div>
        <div class="d-flex justify-content-between"><span class="admin-table__muted">Giảm giá</span><span>-{{ number_format($donHang->giam_gia) }}đ</span></div>
        <div class="d-flex justify-content-between mt-2"><strong>Tổng cộng</strong><strong class="admin-table__price">{{ number_format($donHang->tong_tien) }}đ</strong></div>

        <form method="POST" action="{{ route('admin.orders.status', $donHang->id) }}" class="mt-3">
            @csrf @method('PUT')
            <label class="admin-field__label">Cập nhật trạng thái</label>
            <select name="trang_thai_don_hang" class="admin-field__select mb-2">
                @foreach(['cho_xac_nhan'=>'Chờ xác nhận','dang_chuan_bi'=>'Đang chuẩn bị','dang_giao'=>'Đang giao','da_giao'=>'Đã giao','da_huy'=>'Đã hủy'] as $k=>$v)
                <option value="{{ $k }}" @selected($donHang->trang_thai_don_hang==$k)>{{ $v }}</option>
                @endforeach
            </select>
            <button class="admin-btn admin-btn--primary w-100"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
        </form>
    </div>
</div>
@endsection
