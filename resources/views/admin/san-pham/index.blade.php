@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm - SKT Admin')
@section('nav-products', 'is-active')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h1 class="admin-page-title">Quản lý sản phẩm</h1>
        <p class="admin-page-sub">{{ $sanPhams->total() }} sản phẩm</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn--primary"><i class="fa-solid fa-plus"></i> Thêm sản phẩm</a>
</div>

<section class="admin-table-wrap">
    <div class="admin-table-wrap__head">
        <h3 class="admin-panel__title">Danh sách sản phẩm</h3>
        <form method="GET" class="d-flex gap-2">
            <select name="danh_muc" class="admin-status-select" onchange="this.form.submit()">
                <option value="">Tất cả danh mục</option>
                @foreach($danhMucs as $dm)
                <option value="{{ $dm->id }}" @selected(request('danh_muc')==$dm->id)>{{ $dm->ten_danh_muc ?? $dm->ten ?? $dm->id }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <table class="admin-table">
        <thead><tr><th>Sản phẩm</th><th>Danh mục</th><th>Giá bán</th><th>Tồn kho</th><th>Thao tác</th></tr></thead>
        <tbody>
            @forelse($sanPhams as $sp)
            <tr class="admin-table__row">
                <td><div class="admin-table__product">
                    <img class="admin-table__thumb" src="{{ asset('assets/images/products/'.($sp->danhMuc->slug ?? 'mice').'/'.($sp->slug ?? '').'/1.webp') }}" alt="">
                    <div><div class="admin-table__name">{{ $sp->ten_san_pham }}</div><div class="admin-table__muted">{{ $sp->thuong_hieu }}</div></div>
                </div></td>
                <td>{{ $sp->danhMuc->ten_danh_muc ?? $sp->danhMuc->ten ?? '—' }}</td>
                <td class="admin-table__price">{{ number_format($sp->gia_ban) }}đ</td>
                <td>
                    @php $kho = $sp->so_luong_kho ?? 0; @endphp
                    <span class="admin-badge admin-badge--{{ $kho==0?'stock-out':($kho<10?'stock-low':'stock-ok') }}">{{ $kho }}</span>
                </td>
                <td><div class="d-flex gap-2">
                    <a href="{{ route('admin.products.edit', $sp->id) }}" class="admin-icon-btn"><i class="fa-solid fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.products.destroy', $sp->id) }}" onsubmit="return confirm('Xóa sản phẩm này?')">
                        @csrf @method('DELETE')
                        <button class="admin-icon-btn admin-icon-btn--danger"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </div></td>
            </tr>
            @empty
            <tr class="admin-table__row"><td colspan="5" class="admin-table__muted">Chưa có sản phẩm (chờ Module 2 — Codex)</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">{{ $sanPhams->links() }}</div>
</section>
@endsection
