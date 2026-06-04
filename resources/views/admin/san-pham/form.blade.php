@extends('layouts.admin')

@section('title', ($sanPham->exists ? 'Sửa' : 'Thêm') . ' sản phẩm - SKT Admin')
@section('nav-products', 'is-active')

@section('content')
<h1 class="admin-page-title">{{ $sanPham->exists ? 'Sửa' : 'Thêm' }} sản phẩm</h1>
<p class="admin-page-sub"><a href="{{ route('admin.products.index') }}" class="admin-table__muted">Sản phẩm</a> / {{ $sanPham->exists ? $sanPham->ten_san_pham : 'Thêm mới' }}</p>

<form method="POST" action="{{ $sanPham->exists ? route('admin.products.update', $sanPham->id) : route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form-grid">
    @csrf
    @if($sanPham->exists) @method('PUT') @endif

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Thông tin cơ bản</h3>
            <div class="admin-field">
                <label class="admin-field__label">Tên sản phẩm</label>
                <input type="text" name="ten_san_pham" class="admin-field__input" value="{{ old('ten_san_pham', $sanPham->ten_san_pham) }}" required>
                @error('ten_san_pham')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Thương hiệu</label>
                    <input type="text" name="thuong_hieu" class="admin-field__input" value="{{ old('thuong_hieu', $sanPham->thuong_hieu) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Slug</label>
                    <input type="text" name="slug" class="admin-field__input" value="{{ old('slug', $sanPham->slug) }}">
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả ngắn</label>
                <textarea name="mo_ta_ngan" class="admin-field__textarea">{{ old('mo_ta_ngan', $sanPham->mo_ta_ngan) }}</textarea>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả chi tiết</label>
                <textarea name="mo_ta" class="admin-field__textarea">{{ old('mo_ta', $sanPham->mo_ta) }}</textarea>
            </div>
        </div>
    </div>

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Giá & Kho</h3>
            <div class="admin-field">
                <label class="admin-field__label">Giá bán (đ)</label>
                <input type="number" name="gia_ban" class="admin-field__input" value="{{ old('gia_ban', $sanPham->gia_ban) }}" required>
                @error('gia_ban')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Giá nhập (đ)</label>
                <input type="number" name="gia_nhap" class="admin-field__input" value="{{ old('gia_nhap', $sanPham->gia_nhap) }}">
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Số lượng kho</label>
                <input type="number" name="so_luong_kho" class="admin-field__input" value="{{ old('so_luong_kho', $sanPham->so_luong_kho) }}" required>
            </div>
        </div>

        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Phân loại</h3>
            <div class="admin-field">
                <label class="admin-field__label">Danh mục</label>
                <select name="danh_muc_id" class="admin-field__select" required>
                    @foreach($danhMucs as $dm)
                    <option value="{{ $dm->id }}" @selected(old('danh_muc_id', $sanPham->danh_muc_id)==$dm->id)>{{ $dm->ten_danh_muc ?? $dm->ten ?? $dm->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Số sao (0-5)</label>
                <input type="number" name="so_sao" class="admin-field__input" min="0" max="5" step="0.1" value="{{ old('so_sao', $sanPham->so_sao) }}">
            </div>
        </div>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--ghost">Hủy</a>
        </div>
    </div>
</form>
@endsection
