@extends('layouts.admin')

@section('title', ($maGiamGia->exists ? 'Sửa' : 'Thêm') . ' mã giảm giá - YUKI Admin')
@section('nav-coupons', 'is-active')

@section('content')
<h1 class="admin-page-title">{{ $maGiamGia->exists ? 'Sửa' : 'Thêm' }} mã giảm giá</h1>
<p class="admin-page-sub"><a href="{{ route('admin.coupons.index') }}" class="admin-table__muted">Mã giảm giá</a> / {{ $maGiamGia->exists ? $maGiamGia->ma_code : 'Thêm mới' }}</p>

<form method="POST" action="{{ $maGiamGia->exists ? route('admin.coupons.update', $maGiamGia->id) : route('admin.coupons.store') }}" class="admin-form-grid">
    @csrf
    @if($maGiamGia->exists) @method('PUT') @endif

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Thông tin mã</h3>
            <div class="admin-field">
                <label class="admin-field__label">Mã code</label>
                <input type="text" name="ma_code" class="admin-field__input" style="text-transform:uppercase" value="{{ old('ma_code', $maGiamGia->ma_code) }}" placeholder="VD: YUKISALE" required>
                @error('ma_code')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Loại giảm</label>
                    <select name="loai" class="admin-field__select">
                        <option value="phan_tram" @selected(old('loai', $maGiamGia->loai)==='phan_tram')>Phần trăm (%)</option>
                        <option value="so_tien" @selected(old('loai', $maGiamGia->loai)==='so_tien')>Số tiền (đ)</option>
                    </select>
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Giá trị</label>
                    <input type="number" name="gia_tri" class="admin-field__input" value="{{ old('gia_tri', $maGiamGia->gia_tri) }}" placeholder="10" required>
                    @error('gia_tri')<p class="txt-red small">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Đơn tối thiểu (đ)</label>
                <input type="number" name="gia_tri_don_toi_thieu" class="admin-field__input" value="{{ old('gia_tri_don_toi_thieu', $maGiamGia->gia_tri_don_toi_thieu ?? 0) }}">
                <p class="admin-table__muted small">Để 0 nếu áp dụng cho mọi đơn.</p>
            </div>
        </div>
    </div>

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Giới hạn & Hiệu lực</h3>
            <div class="admin-field">
                <label class="admin-field__label">Số lượt sử dụng tối đa</label>
                <input type="number" name="so_lan_su_dung_toi_da" class="admin-field__input" value="{{ old('so_lan_su_dung_toi_da', $maGiamGia->so_lan_su_dung_toi_da) }}" placeholder="Để trống = không giới hạn">
                @error('so_lan_su_dung_toi_da')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Ngày bắt đầu</label>
                    <input type="date" name="ngay_bat_dau" class="admin-field__input" value="{{ old('ngay_bat_dau', optional($maGiamGia->ngay_bat_dau)->format('Y-m-d')) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Ngày hết hạn</label>
                    <input type="date" name="ngay_het_han" class="admin-field__input" value="{{ old('ngay_het_han', optional($maGiamGia->ngay_het_han)->format('Y-m-d')) }}">
                    @error('ngay_het_han')<p class="txt-red small">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Trạng thái</label>
                <select name="trang_thai" class="admin-field__select">
                    <option value="1" @selected(old('trang_thai', $maGiamGia->trang_thai ?? 1)==1)>Hoạt động</option>
                    <option value="0" @selected(old('trang_thai', $maGiamGia->trang_thai ?? 1)==0)>Ngừng</option>
                </select>
            </div>
        </div>

        @if($maGiamGia->exists)
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Thống kê</h3>
            <p class="admin-field__label mb-1">Đã dùng: <strong>{{ $maGiamGia->so_lan_da_dung }}</strong> / {{ $maGiamGia->so_lan_su_dung_toi_da ?? '∞' }} lượt</p>
        </div>
        @endif

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu mã giảm giá</button>
            <a href="{{ route('admin.coupons.index') }}" class="admin-btn admin-btn--ghost">Hủy</a>
        </div>
    </div>
</form>
@endsection
