@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá - SKT Admin')
@section('nav-coupons', 'is-active')

@section('content')
<h1 class="admin-page-title">Quản lý mã giảm giá</h1>
<p class="admin-page-sub">Tạo và theo dõi chương trình khuyến mãi</p>

<div class="admin-grid-2">
    <section class="admin-table-wrap">
        <div class="admin-table-wrap__head"><h3 class="admin-panel__title">Danh sách mã</h3></div>
        <table class="admin-table">
            <thead><tr><th>Mã code</th><th>Giảm</th><th>Đã dùng</th><th>Hạn</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @forelse($maGiamGias as $ma)
                <tr class="admin-table__row">
                    <td><strong>{{ $ma->ma_code }}</strong></td>
                    <td class="admin-table__price">{{ $ma->loai=='phan_tram' ? $ma->gia_tri.'%' : number_format($ma->gia_tri).'đ' }}</td>
                    <td>{{ $ma->so_lan_da_dung }} / {{ $ma->so_lan_su_dung_toi_da ?? '∞' }}</td>
                    <td>{{ $ma->ngay_het_han?->format('d/m/Y') ?? '—' }}</td>
                    <td><span class="admin-badge admin-badge--{{ $ma->conHieuLuc()?'done':'cancel' }}">{{ $ma->conHieuLuc()?'Hoạt động':'Ngừng' }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.coupons.destroy', $ma->id) }}" onsubmit="return confirm('Xóa mã này?')">
                            @csrf @method('DELETE')
                            <button class="admin-icon-btn admin-icon-btn--danger"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="admin-table__row"><td colspan="6" class="admin-table__muted">Chưa có mã giảm giá</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="admin-pagination">{{ $maGiamGias->links() }}</div>
    </section>

    <section class="admin-panel">
        <h3 class="admin-panel__title mb-3">Tạo mã mới</h3>
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="admin-field">
                <label class="admin-field__label">Mã code</label>
                <input type="text" name="ma_code" class="admin-field__input" style="text-transform:uppercase" value="{{ old('ma_code') }}" required>
                @error('ma_code')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Loại giảm</label>
                <select name="loai" class="admin-field__select">
                    <option value="phan_tram">Phần trăm (%)</option>
                    <option value="so_tien">Số tiền (đ)</option>
                </select>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Giá trị</label>
                <input type="number" name="gia_tri" class="admin-field__input" value="{{ old('gia_tri') }}" required>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                <input type="number" name="gia_tri_don_toi_thieu" class="admin-field__input" value="{{ old('gia_tri_don_toi_thieu', 0) }}">
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Số lượt tối đa</label>
                    <input type="number" name="so_lan_su_dung_toi_da" class="admin-field__input" value="{{ old('so_lan_su_dung_toi_da') }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Ngày hết hạn</label>
                    <input type="date" name="ngay_het_han" class="admin-field__input" value="{{ old('ngay_het_han') }}">
                </div>
            </div>
            <input type="hidden" name="trang_thai" value="1">
            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-plus"></i> Tạo mã</button>
            </div>
        </form>
    </section>
</div>
@endsection
