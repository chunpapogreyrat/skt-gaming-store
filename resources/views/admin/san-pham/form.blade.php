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
                <label class="admin-field__label">Thêm ảnh sản phẩm (cho slider chi tiết)</label>
                <div id="imgDropzone" class="img-dropzone">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p><strong>Kéo &amp; thả ảnh vào đây</strong><br><span>hoặc bấm để chọn — có thể thêm nhiều ảnh</span></p>
                    <input type="file" name="hinh_anh[]" id="imgInput" multiple accept="image/*" hidden>
                </div>
                <div id="imgPreview" class="img-preview"></div>
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

@push('styles')
<style>
    .img-dropzone { border: 2px dashed rgba(255,255,255,.18); border-radius: 10px; padding: 24px 16px; text-align: center; cursor: pointer; transition: .2s; color: var(--text-muted); }
    .img-dropzone:hover, .img-dropzone.is-drag { border-color: var(--red); background: rgba(255,0,60,.06); color: #fff; }
    .img-dropzone i { font-size: 1.7rem; color: var(--red); }
    .img-dropzone p { margin: 8px 0 0; font-size: .85rem; }
    .img-dropzone span { font-size: .78rem; opacity: .7; }
    .img-preview { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .img-preview__item { position: relative; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); background:#fff; }
    .img-preview__item img { width: 100%; height: 100%; object-fit: contain; }
    .img-preview__rm { position: absolute; top: 2px; right: 2px; width: 20px; height: 20px; border: 0; border-radius: 50%; background: rgba(0,0,0,.7); color: #fff; cursor: pointer; line-height: 18px; font-size: 14px; padding: 0; }
</style>
@endpush

@push('scripts')
<script>
(function () {
    var dz = document.getElementById('imgDropzone');
    var input = document.getElementById('imgInput');
    var preview = document.getElementById('imgPreview');
    if (!dz || !input) return;
    var store = new DataTransfer();

    function render() {
        preview.innerHTML = '';
        Array.from(store.files).forEach(function (file, idx) {
            var url = URL.createObjectURL(file);
            var item = document.createElement('div');
            item.className = 'img-preview__item';
            item.innerHTML = '<img src="' + url + '" alt=""><button type="button" class="img-preview__rm" data-idx="' + idx + '">&times;</button>';
            preview.appendChild(item);
        });
    }
    function addFiles(files) {
        Array.from(files).forEach(function (f) { if (f.type.indexOf('image/') === 0) store.items.add(f); });
        input.files = store.files;
        render();
    }

    dz.addEventListener('click', function () { input.click(); });
    input.addEventListener('change', function () {
        // file lấy từ hộp thoại -> gom vào store rồi gán lại
        var picked = Array.from(input.files);
        // tránh đệ quy: chỉ thêm file chưa có trong store
        var current = Array.from(store.files);
        if (picked.length && picked !== current) {
            picked.forEach(function (f) {
                var dup = current.some(function (c) { return c.name === f.name && c.size === f.size; });
                if (!dup && f.type.indexOf('image/') === 0) store.items.add(f);
            });
            input.files = store.files;
            render();
        }
    });

    ['dragover', 'dragenter'].forEach(function (ev) {
        dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('is-drag'); });
    });
    ['dragleave', 'dragend'].forEach(function (ev) {
        dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('is-drag'); });
    });
    dz.addEventListener('drop', function (e) {
        e.preventDefault();
        dz.classList.remove('is-drag');
        addFiles(e.dataTransfer.files);
    });

    preview.addEventListener('click', function (e) {
        var btn = e.target.closest('.img-preview__rm');
        if (!btn) return;
        var idx = parseInt(btn.dataset.idx);
        var nt = new DataTransfer();
        Array.from(store.files).forEach(function (f, i) { if (i !== idx) nt.items.add(f); });
        store = nt;
        input.files = store.files;
        render();
    });
})();
</script>
@endpush
