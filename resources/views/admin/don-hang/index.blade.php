@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng - SKT Admin')
@section('nav-orders', 'is-active')

@php
$badge = ['cho_xac_nhan'=>'pending','dang_chuan_bi'=>'prep','dang_giao'=>'shipping','da_giao'=>'done','da_huy'=>'cancel'];
@endphp

@section('content')
<h1 class="admin-page-title">Quản lý đơn hàng</h1>
<p class="admin-page-sub">{{ $donHangs->total() }} đơn hàng</p>

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Tất cả đơn hàng</h3>
        <form method="GET">
            <select name="trang_thai" class="admin-status-select" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="cho_xac_nhan" @selected(request('trang_thai')=='cho_xac_nhan')>Chờ xác nhận</option>
                <option value="dang_chuan_bi" @selected(request('trang_thai')=='dang_chuan_bi')>Đang chuẩn bị</option>
                <option value="dang_giao" @selected(request('trang_thai')=='dang_giao')>Đang giao</option>
                <option value="da_giao" @selected(request('trang_thai')=='da_giao')>Đã giao</option>
                <option value="da_huy" @selected(request('trang_thai')=='da_huy')>Đã hủy</option>
            </select>
        </form>
    </div>
    <table class="admin-table">
        <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày</th><th>Tổng tiền</th><th>Thanh toán</th><th>Đổi trạng thái</th></tr></thead>
        <tbody>
            @forelse($donHangs as $don)
            <tr class="admin-table__row">
                <td><a href="{{ route('admin.orders.show', $don->id) }}"><strong>#{{ $don->ma_don_hang }}</strong></a></td>
                <td>{{ $don->ten_nguoi_nhan }}<div class="admin-table__muted">{{ $don->sdt_nguoi_nhan }}</div></td>
                <td>{{ $don->created_at?->format('d/m/Y') }}</td>
                <td class="admin-table__price">{{ number_format($don->tong_tien) }}đ</td>
                <td><span class="admin-badge admin-badge--{{ $don->trang_thai_thanh_toan=='da_thanh_toan'?'done':'pending' }}">{{ strtoupper($don->phuong_thuc_thanh_toan) }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.orders.status', $don->id) }}">
                        @csrf @method('PUT')
                        <select name="trang_thai_don_hang" class="admin-status-select" onchange="this.form.submit()">
                            @foreach(['cho_xac_nhan'=>'Chờ xác nhận','dang_chuan_bi'=>'Đang chuẩn bị','dang_giao'=>'Đang giao','da_giao'=>'Đã giao','da_huy'=>'Đã hủy'] as $k=>$v)
                            <option value="{{ $k }}" @selected($don->trang_thai_don_hang==$k)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Không có đơn hàng</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $donHangs->links() }}</div>
</section>
@endsection
