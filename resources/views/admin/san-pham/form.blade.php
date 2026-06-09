@extends('layouts.admin')

@section('title', ($sanPham->exists ? 'Sửa' : 'Thêm') . ' sản phẩm - YUKI Admin')
@section('nav-products', 'is-active')

@section('content')
<h1 class="admin-page-title">{{ $sanPham->exists ? 'Sửa' : 'Thêm' }} sản phẩm</h1>
<p class="admin-page-sub"><a href="{{ route('admin.products.index') }}" class="admin-table__muted">Sản phẩm</a> / {{ $sanPham->exists ? $sanPham->ten : 'Thêm mới' }}</p>

<form method="POST" action="{{ $sanPham->exists ? route('admin.products.update', $sanPham->id) : route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form-grid">
    @csrf
    @if($sanPham->exists) @method('PUT') @endif

    <div>
        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Thông tin cơ bản</h3>
            <div class="admin-field">
                <label class="admin-field__label">Tên sản phẩm</label>
                <input type="text" name="ten" class="admin-field__input" value="{{ old('ten', $sanPham->ten) }}" required>
                @error('ten')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field__row">
                <div class="admin-field">
                    <label class="admin-field__label">Slug (tự sinh nếu trống)</label>
                    <input type="text" name="slug" class="admin-field__input" value="{{ old('slug', $sanPham->slug) }}">
                </div>
                <div class="admin-field">
                    <label class="admin-field__label">Thương hiệu</label>
                    <select name="thuong_hieu_id" class="admin-field__select">
                        <option value="">— Không —</option>
                        @foreach($thuongHieus as $th)
                        <option value="{{ $th->id }}" @selected(old('thuong_hieu_id', $sanPham->thuong_hieu_id)==$th->id)>{{ $th->ten }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả ngắn</label>
                <textarea name="mo_ta_ngan" class="admin-field__textarea">{{ old('mo_ta_ngan', $sanPham->mo_ta_ngan) }}</textarea>
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Mô tả chi tiết</label>
                <textarea name="mo_ta_day_du" class="admin-field__textarea" rows="6">{{ old('mo_ta_day_du', $sanPham->mo_ta_day_du) }}</textarea>
            </div>
        </div>

        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Hình ảnh sản phẩm</h3>
            @if($sanPham->exists && $sanPham->hinhAnh->count())
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @foreach($sanPham->hinhAnh as $img)
                    <label style="position:relative;width:84px;height:84px;border-radius:8px;overflow:hidden;border:1px solid rgba(255,255,255,.12);cursor:pointer;display:block;background:#fff">
                        <img src="{{ asset($img->duong_dan) }}" alt="" style="width:100%;height:100%;object-fit:contain">
                        @if($img->is_main)<span style="position:absolute;top:2px;left:2px;background:var(--red);color:#fff;font-size:9px;padding:1px 5px;border-radius:3px">Chính</span>@endif
                        <span style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,.65);padding:2px 4px;border-radius:3px">
                            <input type="checkbox" name="xoa_anh[]" value="{{ $img->id }}" title="Xóa ảnh này">
                        </span>
                    </label>
                    @endforeach
                </div>
                <p class="admin-table__muted small mb-3">Tick ô góc phải mỗi ảnh để xóa khi lưu.</p>
            @endif
            <div class="admin-field">
                <label class="admin-field__label">Thêm ảnh (chọn nhiều)</label>
                <input type="file" name="hinh_anh[]" class="admin-field__input" multiple accept="image/*">
                @error('hinh_anh.*')<p class="txt-red small">{{ $message }}</p>@enderror
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
                <label class="admin-field__label">Giá gốc — gạch ngang (đ)</label>
                <input type="number" name="gia_goc" class="admin-field__input" value="{{ old('gia_goc', $sanPham->gia_goc) }}">
            </div>
            <div class="admin-field">
                <label class="admin-field__label">Số lượng tồn</label>
                <input type="number" name="so_luong_ton" class="admin-field__input" value="{{ old('so_luong_ton', $sanPham->so_luong_ton ?? 0) }}" required>
            </div>
        </div>

        <div class="admin-panel mb-3">
            <h3 class="admin-panel__title mb-3">Phân loại & Trạng thái</h3>
            <div class="admin-field">
                <label class="admin-field__label">Danh mục</label>
                <select name="danh_muc_id" class="admin-field__select" required>
                    <option value="">— Chọn —</option>
                    @foreach($danhMucs as $dm)
                    <option value="{{ $dm->id }}" @selected(old('danh_muc_id', $sanPham->danh_muc_id)==$dm->id)>{{ $dm->ten }}</option>
                    @endforeach
                </select>
                @error('danh_muc_id')<p class="txt-red small">{{ $message }}</p>@enderror
            </div>
            <div class="admin-field">
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $sanPham->is_active ?? true))>
                    Hiển thị (active)
                </label>
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_hot" value="1" @checked(old('is_hot', $sanPham->is_hot ?? false))>
                    Sản phẩm HOT
                </label>
                <label class="admin-field__label d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_sale" value="1" @checked(old('is_sale', $sanPham->is_sale ?? false))>
                    Đang giảm giá (SALE)
                </label>
            </div>
        </div>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--ghost">Hủy</a>
        </div>
    </div>
</form>
@endsection
